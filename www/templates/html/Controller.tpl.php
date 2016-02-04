<?php

use UNL\Templates\Templates;
use UNL\UndergraduateBulletin\Controller;

$page = Templates::factory('Fixed', Templates::VERSION_4_1);
$webRoot = dirname(dirname(__DIR__));

if (file_exists($webRoot . '/wdn/templates_4.1')) {
    $page->setLocalIncludePath($webRoot);
}

$url = Controller::getURL();
$baseURL = Controller::getBaseURL();
$protocolAgnosticBaseURL = str_replace('http://', '//', $baseURL);

$page->setParam('class', 'page-' . $context->options['view']);
$page->doctitle = '<title>Undergraduate Bulletin | University of Nebraska-Lincoln</title>';
$page->affiliation = '';
$page->titlegraphic = 'Undergraduate Bulletin ' . Controller::getEdition()->getRange();
$page->pagetitle = '<h1>Your Undergraduate Bulletin</h1>';
$page->breadcrumbs  = '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li>Undergraduate Bulletin</li>
</ul>
';

$page->navlinks = $savvy->render(null, 'Navigation.tpl.php');
$page->contactinfo = $savvy->render(null, 'sharedcode/localFooter.html');

$page->addStylesheet($protocolAgnosticBaseURL. 'css/debug.css');
$page->addStyleSheet($protocolAgnosticBaseURL . 'css/print.css', 'print');

// Check if the year of this edition indicates it has not been published
if (mktime(0, 0, 0, 6, 1, $context->getEdition()->getYear()) > time() ) {
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

echo $page;
