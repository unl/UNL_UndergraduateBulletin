<?php

use UNL\UndergraduateBulletin\Controller;

$page = $context->getRawObject()->getOutputPage();
$savvy->addGlobal('page',  $page);

$url = Controller::getURL();
$baseURL = Controller::getBaseURL();
$protocolAgnosticBaseURL = str_replace('http://', '//', $baseURL);

$page->navlinks = $savvy->render(null, 'Navigation.tpl.php');
$page->contactinfo = $savvy->render(null, 'sharedcode/localFooter.tpl.php');

$page->addStylesheet($protocolAgnosticBaseURL. 'css/all.css');
$page->addStyleSheet($protocolAgnosticBaseURL . 'css/print.css', 'print');
$page->head .= '<link rel="home" href="'.$url.'" />';
$page->head .= $savvy->render(null, 'sharedcode/editionHead.tpl.php');

// Check if the year of this edition indicates it has not been published
if (mktime(0, 0, 0, 6, 1, Controller::getEdition()->getYear()) > time()) {
    $page->head .= <<<'UNPUBLISHED'
<meta name="robots" content="noindex" />
<script>
require(['jquery'], function($) {
    $(function() {
        $('#wdn_wrapper').before('<div id="testIndicator"></div>');
    });
});
</script>
UNPUBLISHED;
}

$page->maincontentarea = $savvy->render($context->output);
$page->maincontentarea .= $savvy->render(null, 'EditionNotice.tpl.php');
$page->maincontentarea .= $savvy->render(null, 'sharedcode/entry-script.tpl.php');

if (!is_string($page->breadcrumbs)) {
    $page->breadcrumbs = $savvy->render($page->breadcrumbs);
}

echo $page;
