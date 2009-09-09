<?php
UNL_Templates::$options['version']        = 3;
UNL_Templates::$options['sharedcodepath'] = dirname(__FILE__).'/sharedcode';

$page = UNL_Templates::factory('Fixed');

$page->doctitle     = '<title>UNL | Undergraduate Bulletin</title>';
$page->titlegraphic = '<h1>Undergraduate Bulletin 2010-2011</h1>';
$page->navlinks     = '
<ul>
    <li><a href="?view=index">Bulletin Home</a></li>
    <li><a href="?view=major">Major</a></li>
</ul>';
$page->loadSharedCodeFiles();

$page->maincontentarea = UNL_UndergraduateBulletin_OutputController::display($this->output, true);

echo $page;
