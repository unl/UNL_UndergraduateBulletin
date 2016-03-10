<?php

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;

$page = $context->getRawObject()->getOutputPage();
$savvy->addGlobal('page',  $page);

$url = CatalogController::getURL();
$baseURL = Controller::getBaseURL();
$protocolAgnosticBaseURL = str_replace('http://', '//', $baseURL);

$page->navlinks = $savvy->render(null, 'sharedcode/catalogNavigation.tpl.php');
$page->contactinfo = $savvy->render(null, 'sharedcode/bulletinsLocalFooter.html');

$page->addStylesheet($protocolAgnosticBaseURL. 'css/all.css');
$page->addStyleSheet($protocolAgnosticBaseURL . 'css/print.css', 'print');
$page->head .= '<link rel="home" href="'.$url.'" />';

$page->maincontentarea = $savvy->render($context->output);
$page->maincontentarea .= $savvy->render(null, 'sharedcode/entry-script.tpl.php');

if (!is_string($page->breadcrumbs)) {
    $page->breadcrumbs = $savvy->render($page->breadcrumbs);
}

echo $page;
