<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

if (PHP_VERSION_ID < 50600) {
    iconv_set_encoding('internal_encoding', 'UTF-8');
    iconv_set_encoding("output_encoding", 'UTF-8');
} else {
    ini_set('default_charset', 'UTF-8');
}

$controller = new UNL_UndergraduateBulletin_Controller(UNL_UndergraduateBulletin_Router::getRoute($_SERVER['REQUEST_URI']) + $_GET);

$outputcontroller = new UNL_UndergraduateBulletin_OutputController();
$outputcontroller->setTemplatePath(dirname(__FILE__).'/templates/html');
$expire = UNL_UndergraduateBulletin_OutputController::getDefaultExpireTimestamp();

switch($controller->options['format']) {
    case 'xml':
        header('Content-type: text/xml');
        $outputcontroller->setEscape('htmlspecialchars');
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/xml');
        break;
    case 'json':
        header('Content-type: application/json');
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/json');
        break;
    case 'collegesource':
    case 'csv':
        header('Content-type: text/plain; charset=UTF-8');
        
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/csv');
        
        if ($controller->options['format'] == 'collegesource') {
            //CollegeSource is also csv, but they require specific data... so they have a special template.
            $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/collegesource');
            
            if (!isset($controller->options['delimiter'])) {
                $controller->options['delimiter'] = "|";
            }
        } else {
            if (!isset($controller->options['delimiter'])) {
                $controller->options['delimiter'] = ",";
            }
        }

        $delimiter = $controller->options['delimiter'];
        $outputcontroller->addGlobal('delimiter', $delimiter);

        $out = fopen('php://output', 'w');
        $outputcontroller->addGlobal('delimitArray', function($array) use ($delimiter, $out) {            
            fputcsv($out, $array, $delimiter);
        });
        break;
    case 'print':
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/print');
        $outputcontroller->setEscape('htmlentities');
        $expire = strtotime('tomorrow');
        break;
    case 'partial':
        UNL_UndergraduateBulletin_ClassToTemplateMapper::$output_template['UNL_UndergraduateBulletin_Controller'] = 'Controller-partial';
        // no break
    default:
        $outputcontroller->addTemplatePath($controller->getEdition()->getDataDir() . '/templates/html');
        $outputcontroller->setEscape('htmlentities');
        $expire = strtotime('tomorrow');
        break;
}

$outputcontroller->setClassToTemplateMapper(new UNL_UndergraduateBulletin_ClassToTemplateMapper());
$outputcontroller->addGlobal('controller', $controller);
$outputcontroller->addGlobal('course_search_driver', new UNL_UndergraduateBulletin_CourseSearch_DBSearcher());
$outputcontroller->sendCORSHeaders($expire);
try {
    echo $outputcontroller->render($controller);
} catch (Exception $e) {
    $controller->outputException($e);
    echo $outputcontroller->render($controller);
}
