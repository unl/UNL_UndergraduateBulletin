--TEST--
UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks() basic test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$string = 'AGRO 153';

$linked = UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($string);

$test->assertEquals('<a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/AGRO/153">AGRO 153</a>', $linked, 'basic link');


?>
===DONE===
--EXPECT--
===DONE===