<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");


$controller = new UNL_UndergraduateBulletin_Controller($_GET);

Savvy_ClassToTemplateMapper::$classname_replacement = 'UNL_UndergraduateBulletin_';
$savvy = new Savvy();
$savvy->setTemplatePath(dirname(__FILE__).'/templates/html');

echo $savvy->render($controller);

//UNL_UndergraduateBulletin_OutputController::display($controller);


?>