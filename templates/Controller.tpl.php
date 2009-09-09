<?php
UNL_Templates::$options['version']        = 3;
UNL_Templates::$options['sharedcodepath'] = dirname(__FILE__).'/sharedcode';

$page = UNL_Templates::factory('Fixed');

$page->doctitle     = '<title>UNL | Undergraudate Bulletin</title>';
$page->titlegraphic = '<h1>2010-2011 Undergraduate Bulletin</h1>';

$page->loadSharedCodeFiles();

$page->maincontentarea = UNL_UndergraduateBulletin_OutputController::display($this->output, true);

echo $page;
