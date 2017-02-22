<?php

use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\OutputController;
use UNL\UndergraduateBulletin\Router;
use UNL\UndergraduateBulletin\Course\DBSearcher;

$configFile = __DIR__ . '/../../config.inc.php';

if (!file_exists($configFile)) {
    $configFile = __DIR__ . '/../../config.sample.php';
}

require_once $configFile;

if (PHP_VERSION_ID < 50600) {
    iconv_set_encoding('internal_encoding', 'UTF-8');
    iconv_set_encoding("output_encoding", 'UTF-8');
} else {
    ini_set('default_charset', 'UTF-8');
}

$controller = new CatalogController(Router::getRoute($_SERVER['REQUEST_URI'], CatalogController::getBaseURL()) + $_GET);
$outputcontroller = new OutputController();
$outputcontroller->setupFromController($controller);
$outputcontroller->addGlobal('course_search_driver', new DBSearcher($controller));

$outputcontroller->sendCORSHeaders();

try {
    echo $outputcontroller->render($controller);
} catch (Exception $e) {
	if ($e instanceof Savvy_TemplateException) {
		$e = new Exception('Page does not exist', 404, $e);
	}
    $controller->outputException($e);
    echo $outputcontroller->render($controller);
}
