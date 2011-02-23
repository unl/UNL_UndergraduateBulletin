<?php

if (file_exists(dirname(__FILE__).'/../../config.inc.php')) {
    include_once dirname(__FILE__).'/../../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../../config.sample.php';
}
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");

$controller = new UNL_UndergraduateBulletin_Editor_Controller($_GET);

$outputcontroller = new UNL_UndergraduateBulletin_OutputController();
$outputcontroller->setTemplatePath(dirname(__DIR__).'/templates/html');
$outputcontroller->addTemplatePath(__DIR__.'/templates');

$outputcontroller->setClassToTemplateMapper(new UNL_UndergraduateBulletin_ClassToTemplateMapper());

$outputcontroller->setEscape('htmlentities');
$outputcontroller->addFilters(array($controller, 'postRun'));
echo $outputcontroller->render($controller);

