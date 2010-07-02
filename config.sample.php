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

set_include_path(dirname(__FILE__).'/src'.PATH_SEPARATOR.dirname(__FILE__).'/includes/php');
require_once 'UNL/Autoload.php';

// Set this to the web root for the site
UNL_UndergraduateBulletin_Controller::$url = '/workspace/UNL_UndergraduateBulletin/www/';

// Remove this line on production machines so the default UNLCacheLite cache interface is used
UNL_UndergraduateBulletin_OutputController::setCacheInterface(new UNL_UndergraduateBulletin_CacheInterface_Mock());
UNL_UndergraduateBulletin_OutputController::setDefaultExpireTimestamp(strtotime('+1 week'));

//UNL_UndergraduateBulletin_CacheInterface_Mock::$logger = function($key) {
//    $log = ' unlcache_5174748813ed8803e7651fae9d2d077f_'.md5($key);
//    file_put_contents('/tmp/cachedfiles.txt', $log, FILE_APPEND);
//};

UNL_Services_CourseApproval::setCachingService(new UNL_Services_CourseApproval_CachingService_Null());
UNL_Services_CourseApproval::setXCRIService(new UNL_UndergraduateBulletin_CourseDataDriver());
