<?php
UNL_Templates::$options['version']        = 3;
UNL_Templates::$options['sharedcodepath'] = dirname(__FILE__).'/sharedcode';

$page = UNL_Templates::factory('Fixed');
$page->doctitle     = '<title>UNL | Undergraduate Bulletin</title>';
$page->titlegraphic = '<h1>Undergraduate Bulletin 2010-2011</h1>';
$page->breadcrumbs  = '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li>Undergraduate Bulletin</li>
</ul>
';
$page->navlinks     = '
<ul>
    <li><a href="?view=index">Bulletin Home</a></li>
    <li><a href="?view=major">Major</a>
        <ul>
            <li><a href="?view=major&amp;name=Advertising">Advertising</a></li>
            <li><a href="?view=major&amp;name=Geography">Geography</a></li>
        </ul>
    </li>
</ul>';
$page->loadSharedCodeFiles();
$page->addStylesheet('templates/css/all.css');

$page->maincontentarea = UNL_UndergraduateBulletin_OutputController::display($this->output, true);

echo $page;
