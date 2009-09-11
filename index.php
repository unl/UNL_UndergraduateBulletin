<?php

if (file_exists('config.inc.php')) {
    include_once 'config.inc.php';
} else {
    include_once 'config.sample.php';
}
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");
require_once 'UNL/Autoload.php';

$controller = new UNL_UndergraduateBulletin_Controller($_GET);

UNL_UndergraduateBulletin_OutputController::display($controller);


?>