--TEST--
UNL_UndergraduateBulletin_EPUB_Utilities::findCourses() basic test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$string = 'AGRO 153';

$linked = UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($string);

$test->assertEquals(array('AGRO'=>array('153')), $linked, 'basic link');


?>
===DONE===
--EXPECT--
===DONE===