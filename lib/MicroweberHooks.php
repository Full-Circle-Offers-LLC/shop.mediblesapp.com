<?php

include_once(__DIR__ . '/MicroweberStorage.php');
include_once(__DIR__ . '/MicroweberVersionsManager.php');
include_once(__DIR__ . '/MicroweberInstallCommand.php');
include_once(__DIR__ . '/MicroweberCpanelApi.php');
include_once(__DIR__ . '/MicroweberLogger.php');

class MicroweberHooks
{
    private $input;
    private $storage;
    public $logger;

    public function __construct($input = false)
    {
        $this->input = $input;
        $this->storage = new MicroweberStorage();
        $this->logger = new MicroweberLogger();
    }

    // Embed hook attribute information.
    public function describe()
    {
        $add_account = array(
            'category' => 'Whostmgr',
            'event' => 'Accounts::Create',
            'stage' => 'post',
            'hook' => '/var/cpanel/microweber/mw_hooks.php --add-account',
            'exectype' => 'script',
        );
        $remove_account = array(
            'category' => 'Whostmgr',
            'event' => 'Accounts::Remove',
            'stage' => 'post',
            'hook' => '/var/cpanel/microweber/mw_hooks.php --remove-account',
            'exectype' => 'script',
        );
        return json_encode(array($add_account, $remove_account));
    }

    public function remove_account()
    {

        $result = 1;
        $message = "Removing account";   // This string is a reason for $result.
        $this->log($message);

        // Return the hook result and message.
        return array($result, $message);


    }

    public function add_account()
    {
        $input = $this->input;
        $cpapi = new MicroweberCpanelApi();


        $domain = $input['data']['domain'];
        $installPath = $input['data']['homedir'];
        $adminEmail = $input['data']['contactemail'];
        $adminUsername = $input['data']['user'];
        $adminPassword = $input['data']['pass'];


        //@todo check for existing
        $source_path = '/usr/share/microweber/latest/';


        if (!$this->checkIfAutoInstall()) {
            $this->log('Website auto install is not enabled');
            return;

        }
        if (!$cpapi->checkIfFeatureEnabled($adminUsername)) {
            $this->log('Website feature is not enabled for user ' . $adminUsername);
            return;
        }
        $this->log('Website will be installed for user ' . $adminUsername);


        $dbDriver = $this->getDbTypeForInstall();

        $this->log('Adding website to account');
        $dbHost = 'localhost';
        $installPath = $installPath . '/public_html/';


        $isSym = $this->checkIfSymlinkInstall();

        $branding = false;
        $config = $this->storage->read();


        $this->install($domain, $source_path, $installPath, $adminEmail, $adminUsername, $adminPassword, $dbHost, $dbDriver, $is_symlink = $isSym, $config);
    }


    // ----------------------

    public function install($domain, $source_path, $installPath, $adminEmail, $adminUsername, $adminPassword, $dbHost = 'localhost', $dbDriver = 'mysql', $is_symlink = false, $extra_config = false)
    {
        $cpapi = new MicroweberCpanelApi();

        $source_folder = $source_path;


        $version_manager = new MicroweberVersionsManager($source_folder);
        if (!$version_manager->hasDownloaded()) {
            $version_manager->download();
        }
        if (!$version_manager->hasDownloaded()) {
            $this->log('Error: Source cannot be downloaded in ' . $source_folder);
            return;
        }
        $this->log('Source files to use are in ' . $source_folder);

        $dbNameLength = 15;
        $dbPrefix = $cpapi->makeDbPrefixFromUsername($adminUsername);
        $dbName = $dbPrefix . str_replace('.', '', $domain);
        $dbName = substr($dbName, 0, $dbNameLength);

        $dbUsername = $dbName;
        $dbPass = $cpapi->randomPassword(12);


        if ($dbDriver == 'sqlite') {
            $this->log('Using sqlite for ' . $dbUsername);
            $dbHost = 'storage/database.sqlite';

        } else {


            $this->log('Creating database user ' . $dbUsername);
            $cpapi->execUapi($adminUsername, 'Mysql', 'create_user', array('name' => $dbUsername, 'password' => $dbPass));


            $this->log('Creating database ' . $dbName);
            $cpapi->execUapi($adminUsername, 'Mysql', 'create_database', array('name' => $dbName));

            $this->log('Setting privileges ' . $dbUsername);
            $cpapi->execUapi($adminUsername, 'Mysql', 'set_privileges_on_database', array('user' => $dbUsername, 'database' => $dbName, 'privileges' => 'ALL PRIVILEGES'));

        }

        //         //php artisan microweber:install admin@site.com admin password storage/database1.sqlite microweber microweber nopass sqlite -p site_ -t liteness -d 1

        $opts = array();
        $opts['user'] = $adminUsername;
        $opts['pass'] = $adminPassword;
        $opts['email'] = $adminEmail;
        $opts['database_driver'] = $dbDriver;
        $opts['database_user'] = $dbUsername;
        $opts['database_host'] = $dbHost;
        $opts['database_password'] = $dbPass;
        $opts['database_table_prefix'] = $dbPrefix;
        $opts['database_name'] = $dbName;
        $opts['source_folder'] = $source_folder;
        $opts['public_html_folder'] = $installPath;
        $opts['extra_config'] = $extra_config;

        $opts['config_only'] = true;

        $opts['default_template'] = 'dream'; //@todo get from settings
        $opts['is_symliked'] = $is_symlink; //@todo get from settings
        //  $opts['debug_email'] = 'boksiora@gmail.com'; //@todo get from settings


//        $install_opts = array();
//        $opts['options'] = $install_opts;

        $this->log('Running install command');

        $do_install = new MicroweberInstallCommand();
        $do_install->logger = $this->logger;

        $do_install = $do_install->install($opts);


        $result = 1;
        $message = "Install command finished.";   // This string is a reason for $result.
        $this->log($message);

        // Return the hook result and message.
        return array($result, $message);

    }

    public function log($msg)
    {
        if (is_object($this->logger) and method_exists($this->logger, 'log')) {
            $this->logger->log($msg);
        }
    }


    private function getDbTypeForInstall()
    {
        $config = $this->storage->read();
        $db_driver = isset($config['db_driver']) ? $config['db_driver'] : 'mysql';
        return $db_driver;
    }

    private function checkIfAutoInstall()
    {
        $config = $this->storage->read();
        return isset($config['auto_install']) and $config['auto_install'];
    }

    private function checkIfSymlinkInstall()
    {
        $config = $this->storage->read();
        return isset($config['install_type']) and $config['install_type'] == 'symlinked';
    }


}
