<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('/usr/local/cpanel/php/cpanel.php');

require_once(__DIR__ . '/lib/MicroweberPluginController.php');
require_once(__DIR__ . '/lib/MicroweberCpanelApi.php');
require_once(__DIR__ . '/lib/MicroweberView.php');
$cpapi = new MicroweberCpanelApi();

$cpanel = new CPANEL();



$controller = new MicroweberPluginController($cpanel);
$username = $controller->getUsername();
echo $cpanel->header();

if ($_POST) {

    $action = $_POST['_action'];
    if (isset($_POST["domain"])) {
        $domainData = htmlspecialchars_decode($_POST["domain"]);
        $domainData = @json_decode($domainData, true);
    }
    switch ($action) {
        case 'install':

            $admin = $controller->install();

            if (isset($admin['error'])) {

                $txt = '';
                foreach ($admin['messages'] as $message) {
                    $txt .= $message . '<br />';
                }

                print '<div class="alert alert-danger" style="margin-top:20px;">
                          <div class="alert-message">
                         ' . $txt . '
                        </div>
                 </div>';

            } else {
                if (isset($domainData['domain'])) {

                    $txt = "<p style=\"margin: 10px 0;\"><a target='_blank' href='https://mediblesapp.com/shop" . $domainData['domain'] . "' style='font-size: 17px; text-decoration: none; font-weight: bold; color: #5d5d5d;'>Click here to setup your website: https://mediblesapp.com/shop " . $domainData['domain'] . "</a></p>";
                    print '<div class="alert alert-success" style="margin-top:20px;">
                          <div class="alert-message">
                          
                         ' . $txt . '
                          
                        </div>
                 </div>';
                }
            }

            break;
        case 'uninstall':
            $controller->uninstall();

            if (isset($domainData['domain'])) {

                $txt = "<p style=\"margin: 10px 0;\">Your domain " . $domainData['domain'] . " has been removed. </p>";
                print '<div class="alert alert-danger">
                          <div class="alert-message">
                          
                         ' . $txt . '
                          
                        </div>
                 </div>';
            }


            break;
    }
}

if (isset($_GET['search']) && !$_GET['search']) {
    unset($_GET['search']);
}


$domaindata = $cpanel->uapi('DomainInfo', 'domains_data', array('format' => 'hash'));
$domaindata = $domaindata['cpanelresult']['result']['data'];
$all_domains = array_merge(array($domaindata['main_domain']), $domaindata['addon_domains'], $domaindata['sub_domains']);
$existing_installs = $controller->findInstalations();


?>

<?php
$view = new MicroweberView(__DIR__ . '/views/header.php');

$view->display();


?>
    <script>
        function advancedRadioChanged() {
            var express = document.forms[document.forms.length - 1].express.value;
            document.getElementById('advanced').style.display = express == '1' ? 'none' : 'block';
        }
        function askDelete() {
            return !confirm('Are you sure you want to delete this website?');
        }
    </script>

    <div class="microweber-plugin">
        <h1 class="page-header">
            <span class="page-icon"> </span>
            <span id="pageHeading">Manager</span>
        </h1>
        <div class="body-content">
            <div id="viewContent">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6">
                        <p><strong>List of installed Microweber websites</strong></p>
                    </div>


                    <div class="col-xs-12">
                        <form>
                            <div id="search-area" class="form-group">
                                <div class="row input-row">
                                    <div class="col-xs-12">
                                        <div class="input-group filter-controls">
                                            <input name="search" class="form-control "
                                                   placeholder="Search" title="Type in your search filter."
                                                   value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                            <span class="input-group-btn">
                                                <button id="search-button" type="submit" class="btn btn-default">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <?php

                $view = new MicroweberView(__DIR__ . '/views/domains.php');
                $view->assign('domains', $existing_installs);
                $view->display();


                ?>


            </div>
        </div>
        <?php

        $view = new MicroweberView(__DIR__ . '/views/add_new.php');
        $view->assign('existing_installs', $existing_installs);
        $view->assign('all_domains', $all_domains);
        $view->display();


        ?>


    </div>


<?php

$view = new MicroweberView(__DIR__ . '/views/footer.php');
$view->display();


?>


<?php
echo $cpanel->footer();
$cpanel->end();
