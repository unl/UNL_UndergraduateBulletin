<?php

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\OutputController;
use UNL\UndergraduateBulletin\CourseSearch\DBSearcher;

$configFile = __DIR__ . '/../config.inc.php';

if (!file_exists($configFile)) {
    $configFile = __DIR__ . '/../config.sample.php';
}

require_once $configFile;

if (PHP_VERSION_ID < 50600) {
    iconv_set_encoding('internal_encoding', 'UTF-8');
    iconv_set_encoding("output_encoding", 'UTF-8');
} else {
    ini_set('default_charset', 'UTF-8');
}

$controller = new Controller(Router::getRoute($_SERVER['REQUEST_URI']) + $_GET);
$outputcontroller = new OutputController();
$outputcontroller->setupFromController($controller);
$outputcontroller->addGlobal('course_search_driver', new DBSearcher());

$outputcontroller->sendCORSHeaders();

try {
    echo $outputcontroller->render($controller);
} catch (Exception $e) {
    $controller->outputException($e);
    echo $outputcontroller->render($controller);
}
