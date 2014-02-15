--TEST--
UNL_UndergraduateBulletin_Major_Description::getEpubToTitleMap()
--FILE--
<?php
require dirname(__FILE__) . '/../../test_framework.php.inc';

$edition = UNL_UndergraduateBulletin_Controller::getEdition();
$map = UNL_UndergraduateBulletin_Major_Description::getEpubToTitleMap();

foreach ($map as $file => $title) {
    $filename = $edition->getDataDir().'/majors/'.$file.'.xhtml';
    if (file_exists($filename)) {
        continue;
    }

    // maybe it's not a major, try the other content areas
    $filename = $edition->getDataDir().'/other/'.$file.'.xhtml';
    if (file_exists($filename)) {
        continue;
    }
    echo $filename.' does not exist';
}


?>
===DONE===
--EXPECT--
===DONE===