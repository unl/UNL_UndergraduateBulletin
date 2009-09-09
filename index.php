<?php
require_once 'UNL/Autoload.php';

$controller = new UNL_UndergraduateBulletin_Controller();

UNL_UndergraduateBulletin_OutputController::display($controller);


?>