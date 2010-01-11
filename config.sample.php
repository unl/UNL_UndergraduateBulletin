<?php
set_include_path(dirname(__FILE__).'/includes/php'.PATH_SEPARATOR.get_include_path());
require_once 'UNL/Autoload.php';
ini_set('display_errors', true);
UNL_UndergraduateBulletin_Controller::$url = '/workspace/UNL_UndergraduateBulletin/';
?>