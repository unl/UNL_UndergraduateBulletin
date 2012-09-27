<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");

$controller = new UNL_UndergraduateBulletin_Controller(UNL_UndergraduateBulletin_Router::getRoute($_SERVER['REQUEST_URI']) + $_GET);

$outputcontroller = new UNL_UndergraduateBulletin_OutputController();
$outputcontroller->setTemplatePath(dirname(__FILE__).'/templates/html');

switch($controller->options['format']) {
    case 'partial':
        $outputcontroller->sendCORSHeaders(UNL_UndergraduateBulletin_OutputController::getDefaultExpireTimestamp());
        break;
    case 'xml':
        $outputcontroller->sendCORSHeaders(UNL_UndergraduateBulletin_OutputController::getDefaultExpireTimestamp());
        header('Content-type: text/xml');
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/xml');
        break;
    case 'json':
        $outputcontroller->sendCORSHeaders(UNL_UndergraduateBulletin_OutputController::getDefaultExpireTimestamp());
        header('Content-type: application/json');
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/json');
        break;
    case 'csv':
        $outputcontroller->sendCORSHeaders(UNL_UndergraduateBulletin_OutputController::getDefaultExpireTimestamp());
        header('Content-type: text/plain');
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/csv');
        if (!isset($controller->options['delimiter'])) {
            $controller->options['delimiter'] = ",";
        }
        $outputcontroller->addGlobal('delimiter', $controller->options['delimiter']);

        $outputcontroller->addGlobal('delimitArray', function($delimiter, $array){
            $out = fopen('php://output', 'w');
            fputcsv($out, $array, $delimiter);
        });
        break;
    default:
        header('Expires: '.date('r', strtotime('tomorrow')));
        break;
}


$edition_template_dir = $controller->getEdition()->getDataDir().'/templates/'.$controller->options['format'];

if (is_dir($edition_template_dir)
    && dirname($edition_template_dir) == $controller->getEdition()->getDataDir().'/templates') {
    // Add the local template dir
    $outputcontroller->addTemplatePath($edition_template_dir);
}

$outputcontroller->setClassToTemplateMapper(new UNL_UndergraduateBulletin_ClassToTemplateMapper());

$outputcontroller->setEscape('htmlentities');
$outputcontroller->addFilters(array($controller, 'postRun'));
$outputcontroller->addGlobal('controller', $controller);
$outputcontroller->addGlobal('course_search_driver', new UNL_UndergraduateBulletin_CourseSearch_DBSearcher());
echo $outputcontroller->render($controller);

