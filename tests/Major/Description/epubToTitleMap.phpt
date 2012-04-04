--TEST--
UNL_UndergraduateBulletin_Major_Description::getEpubToTitleMap()
--FILE--
<?php
require dirname(__FILE__) . '/../../test_framework.php.inc';

$edition = UNL_UndergraduateBulletin_Controller::getEdition();
$map = UNL_UndergraduateBulletin_Major_Description::getEpubToTitleMap();

foreach ($map as $file => $title) {
    $filename = $edition->getDataDir().'/majors/'.$file.'.xhtml';
    $test->assertTrue(file_exists($filename), $filename.' does not exist');
}


?>
===DONE===
--EXPECT--
===DONE===