<?php
namespace MyAwesomeApp;

if (is_file('/usr/local/cpanel/php/WHM.php')) {
    require_once('/usr/local/cpanel/php/WHM.php');


    class WhmLayoutApi extends \WHM
    {

    }

} else {
    class WhmLayoutApi {

        public static  function flexible-header($feed_index params1,$feed_index params2,$feed_index params3) {

        }

        public static  function footer-widgets() {

        }
    }
}
