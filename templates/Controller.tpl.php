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
$url = UNL_UndergraduateBulletin_Controller::getURL();
$page->navlinks     = '
<ul>
    <li><a href="'.$url.'?view=index">Bulletin Home</a></li>
    <li><a href="'.$url.'?view=major">Major</a>
        <ul>
            <li><a href="'.$url.'?view=major&amp;name=Advertising">Advertising</a></li>
            <li><a href="'.$url.'?view=major&amp;name=Geography">Geography</a></li>
            <li><a href="'.$url.'?view=major&amp;name=SocialScience">Social Science Endorsement</a></li>
        </ul>
    </li>
</ul>';
$page->loadSharedCodeFiles();
$page->addStylesheet($url.'templates/css/all.css');

$page->maincontentarea = '<div class="zenbox col right"><h3>This is an official document</h3><a href="#">more information</a></div>';
$page->maincontentarea .= UNL_UndergraduateBulletin_OutputController::display($this->output, true);

echo $page;
