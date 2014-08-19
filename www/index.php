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
        header('Content-type: text/plain; charset=UTF-8');
        //Collegesource is also csv, but they require specific data... so they have a special template.
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/collegesource');


        if (!isset($controller->options['delimiter'])) {
            $controller->options['delimiter'] = ",";
        }

        $outputcontroller->addGlobal('delimiter', $controller->options['delimiter']);

        //Needs its own delimiter Due to the fact that SQL 2005 requires that all field values be quoted.
        $outputcontroller->addGlobal('delimitArray', function($delimiter, $array){
            //sanitize the array values
            foreach ($array as $key=>$value) {
                //remove newlines
                $value = preg_replace("/[\n\r]/", "", $value);
                
                //Can not contain double quotes.
                $value = str_replace('"', "'", $value);
                
                $array[$key] = $value;
            }
            
            echo "\"" . implode("\"" . $delimiter . "\"", $array) . "\"\n";
        });
        
        break;
    case 'csv':
        header('Content-type: text/plain; charset=UTF-8');
        
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
