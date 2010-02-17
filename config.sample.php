<?php
function autoload($class)
{
    $class = str_replace('_', '/', $class);
    include $class . '.php';
}
    
spl_autoload_register("autoload");

ini_set('display_errors', true);
error_reporting(E_ALL);

set_include_path(dirname(__FILE__).'/includes/php'.PATH_SEPARATOR.get_include_path());
require_once 'UNL/Autoload.php';
ini_set('display_errors', true);
UNL_UndergraduateBulletin_Controller::$url = '/workspace/UNL_UndergraduateBulletin/';
?>