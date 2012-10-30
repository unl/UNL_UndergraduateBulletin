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
    case 'collegesource':
        //Collegesource is also csv, but they require specific data... so they have a special template.
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/collegesource');

        header('Content-type: text/plain; charset=UTF-8');

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
        $outputcontroller->addTemplatePath(dirname(__FILE__).'/templates/csv');
        
        $outputcontroller->sendCORSHeaders(UNL_UndergraduateBulletin_OutputController::getDefaultExpireTimestamp());
        
        header('Content-type: text/plain; charset=UTF-8');
        
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

