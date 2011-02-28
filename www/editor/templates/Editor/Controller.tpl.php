<?php
UNL_Templates::$options['version']        = 3;
UNL_Templates::$options['sharedcodepath'] = dirname(dirname(__DIR__)).'/sharedcode';

$url     = UNL_UndergraduateBulletin_Controller::getURL();
$baseURL = UNL_UndergraduateBulletin_Controller::getBaseURL();
$page    = UNL_Templates::factory('Document');

$page->doctitle     = '<title>UNL | Undergraduate Bulletin</title>';
$page->titlegraphic = '<h1>Undergraduate Bulletin Editor</h1>';
$page->breadcrumbs  = '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li>Undergraduate Bulletin</li>
</ul>
';

$page->navlinks     = '
<ul>
    
</ul>';
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
<link rel="logout" href="?logout" />
<!-- '.md5($context->getRawObject()->getCacheKey()).' -->
';

$page->maincontentarea = $savvy->render($context->output);

echo $page;
