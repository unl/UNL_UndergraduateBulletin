<?php

if (file_exists('config.inc.php')) {
    include_once 'config.inc.php';
} else {
    include_once 'config.sample.php';
}

require_once 'UNL/Autoload.php';

$controller = new UNL_UndergraduateBulletin_Controller();

UNL_UndergraduateBulletin_OutputController::display($controller);


?>