--TEST--
\pear2\Templates\Savant\Main::render() string with addEscape() test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$string = 'AGRO 153';

$linked = UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($string);

$test->assertEquals('<a class="course" href="/workspace/UNL_UndergraduateBulletin/www/courses/AGRO/153">AGRO 153</a>', $linked, 'basic link');


?>
===DONE===
--EXPECT--
===DONE===