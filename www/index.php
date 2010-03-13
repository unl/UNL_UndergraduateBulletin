<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");

UNL_Services_CourseApproval::setCachingService(new UNL_Services_CourseApproval_CachingService_Null());
UNL_Services_CourseApproval::setXCRIService(new UNL_UndergraduateBulletin_CourseDataDriver());

$controller = new UNL_UndergraduateBulletin_Controller(UNL_UndergraduateBulletin_Router::getRoute() + $_GET);

$savvy = new Savvy();
$savvy->setTemplatePath(dirname(__FILE__).'/templates/html');

switch($controller->options['format']) {
    case 'xml':
        header('Content-type:text/xml');
        $savvy->addTemplatePath(dirname(__FILE__).'/templates/xml');
        break;
}
$savvy->setClassToTemplateMapper(new UNL_UndergraduateBulletin_ClassToTemplateMapper());

$savvy->setEscape('htmlentities');

echo $savvy->render($controller);

