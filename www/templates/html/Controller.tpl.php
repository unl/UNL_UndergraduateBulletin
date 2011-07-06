<?php
UNL_Templates::$options['version']        = 3;
UNL_Templates::$options['sharedcodepath'] = dirname(__FILE__).'/sharedcode';

$url     = UNL_UndergraduateBulletin_Controller::getURL();
$baseURL = UNL_UndergraduateBulletin_Controller::getBaseURL();
$page    = UNL_Templates::factory('Fixed');

$page->doctitle     = '<title>UNL | Undergraduate Bulletin</title>';
$page->titlegraphic = '<h1>Undergraduate Bulletin '.UNL_UndergraduateBulletin_Controller::getEdition()->getRange().'</h1>';
$page->breadcrumbs  = '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li>Undergraduate Bulletin</li>
</ul>
';

$page->navlinks = $savvy->render(null, 'Navigation.tpl.php');

$page->loadSharedCodeFiles();
$page->addStylesheet('/wdn/templates_3.0/css/content/notice.css');
$page->addStylesheet('/wdn/templates_3.0/css/content/zenform.css');
if (UNL_UndergraduateBulletin_OutputController::getCacheInterface() instanceof UNL_UndergraduateBulletin_CacheInterface_Mock) {
    $page->addStylesheet($baseURL. 'templates/html/css/debug.css');
} else {
    $page->addStylesheet($baseURL. 'templates/html/css/all.css');
}
$page->addStyleSheet($baseURL . 'templates/html/css/print.css', 'print');

$page->head .= '
<script type="text/javascript">var UNL_UGB_URL = "'.$url.'";</script>
<script type="text/javascript" src="/wdn/templates_3.0/scripts/plugins/ui/jQuery.ui.js"></script>
<script type="text/javascript" src="'.$baseURL.'templates/html/scripts/jQuery.toc.js"></script>
<script type="text/javascript" src="'.$baseURL.'templates/html/scripts/bulletin.functions.js"></script>
<link rel="home" href="'.$url.'" />
<link rel="search" href="'.$url.'search/" />
<!-- '.md5($context->getRawObject()->getCacheKey()).' -->
';

if ($context->getEdition()->year > UNL_UndergraduateBulletin_Editions::getLatest()->year) {
    $page->head .= <<<UNPUBLISHED
    <meta name="robots" content="noindex" />
    <script type="text/javascript">
    WDN.jQuery(document).ready( function() {
        WDN.jQuery('#wdn_wrapper').before('<div id="testIndicator"></div>');
    });
    </script>
UNPUBLISHED;
}

$page->maincontentarea = '';
$page->maincontentarea .= $savvy->render($context->output);

$page->maincontentarea .= $savvy->render($context, 'EditionNotice.tpl.php');

echo $page;
