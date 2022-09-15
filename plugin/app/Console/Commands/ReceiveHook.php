<?php

namespace App\Console\Commands;

use App\Cpanel\WhmApi;
use App\Models\AppInstallation;
use App\Models\Option;
use Illuminate\Console\Command;
use MicroweberPackages\SharedServerScripts\MicroweberInstallationsScanner;
use MicroweberPackages\SharedServerScripts\MicroweberInstaller;
use MicroweberPackages\SharedServerScripts\MicroweberWhmcsConnector;

class ReceiveHook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:whm-receive-hook
        {--hook=}
        {--file=}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hook = $this->option('hook');
        if (empty($hook)) {
            return ;
        }
        $file = $this->option('file');
        if (empty($file)) {
            return ;
        }
        if (!is_file($file)) {
            return;
        }

        $decodedFile = json_decode(file_get_contents($file), true);
        if (empty($decodedFile)) {
            return;
        }

        if ($hook == 'add_account') {

            if (!isset($decodedFile['data'])) {
                return;
            }

            $settings = Option::getAll('settings');
            if (empty($settings)) {
                return;
            }

            $data = $decodedFile['data'];
            $whmApi = new WhmApi();
            $hostingAccount = $whmApi->getHostingDetailsByDomainName($data['domain']);
            if (empty($hostingAccount)) {
                return;
            }

            dd($data);


            $dbPrefix = $whmApi->makeDbPrefixFromUsername($hostingAccount['user']);
            $dbPassword = $whmApi->randomPassword(12);
            $dbUsername = $dbName = $dbPrefix . 'mw' . date('mdHis');

            $adminPassword = $whmApi->randomPassword(6);
            $adminUsername = 'mw_' . time() . rand(1111,9999);
            $adminEmail = 'mw@' . $data['domain'];

            if (isset($settings['installation_database_driver'])) {
                if ($settings['installation_database_driver'] == 'mysql') {
                    $createDatabase = $whmApi->createDatabaseWithUser($hostingAccount['user'], $dbName, $dbUsername, $dbPassword);
                    if (!$createDatabase) {
                        // Can't create database
                        return;
                    }
                }
            }

            $install = new MicroweberInstaller();
            $install->setChownUser($hostingAccount['user']);
            $install->enableChownAfterInstall();

            $path = $hostingAccount['documentroot'];

            $install->setPath($path);
            $install->setSourcePath(config('whm-cpanel.sharedPaths.app'));

            $whmcsConnector = new MicroweberWhmcsConnector();
            $whmcsConnector->setUrl(Option::getOption('whmcs_url', 'settings'));
            $whmcsConnector->setDomainName($data['domain']);
            $templateFromWhmcs = $whmcsConnector->getSelectedTemplateFromWhmcsUser();
            $install->setTemplate($templateFromWhmcs);

          //  $install->setLanguage($this->installationLanguage);

            $install->setStandaloneInstallation();
            if (isset($settings['installation_type'])) {
                if ($settings['installation_type'] == 'symlinked') {
                    $install->setSymlinkInstallation();
                }
            }

            if (isset($settings['installation_database_driver'])) {
                if ($settings['installation_database_driver'] == 'mysql') {
                    $install->setDatabaseUsername($dbUsername);
                    $install->setDatabasePassword($dbPassword);
                    $install->setDatabaseName($dbName);
                    $install->setDatabaseDriver('mysql');
                }
            }

            $install->setAdminEmail($adminEmail);
            $install->setAdminUsername($adminUsername);
            $install->setAdminPassword($adminPassword);

            $run = $install->run();

            $scanner = new MicroweberInstallationsScanner();
            $installation = $scanner->scanPath($path);

            if (!empty($installation)) {
                return AppInstallation::saveOrUpdateInstallation($hostingAccount, $installation);
            }
        }

        return 0;
    }
}
