--TEST--
UNL_UndergraduateBulletin_EPUB_Utilities::findCourses() basic test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$string = 'MATH 106/106B/106H';

$linked = UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($string);

$test->assertEquals(array (
  'MATH' => 
  array (
    0 => '106',
    1 => '106B',
    2 => '106H',
  ),
), $linked, 'basic link');

$string = 'HIST 244 19<sup>th</sup>';

$linked = UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($string);

$test->assertEquals(array (
  'HIST' => 
  array (
    0 => '244',
  ),
), $linked, 'No HTML in course number sequence');

?>
===DONE===
--EXPECT--
===DONE===
