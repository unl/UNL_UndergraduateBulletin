<?php
function autoload($class)
{
    $class = str_replace('_', '/', $class);
    include $class . '.php';
}
    
spl_autoload_register("autoload");

// Set to false on production machines
ini_set('display_errors', true);
error_reporting(E_ALL);

set_include_path(dirname(__FILE__).'/src'.PATH_SEPARATOR.dirname(__FILE__).'/includes/php'.PATH_SEPARATOR.get_include_path());
require_once 'UNL/Autoload.php';

// Set this to the web root for the site
UNL_UndergraduateBulletin_Controller::$url = '/workspace/UNL_UndergraduateBulletin/www/';

// Remove this line on production machines so the default UNLCacheLite cache interface is used
UNL_UndergraduateBulletin_OutputController::setCacheInterface(new UNL_UnderGraduateBulletin_CacheInterface_Mock());
?>