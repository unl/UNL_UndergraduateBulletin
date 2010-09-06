--TEST--
UNL_UndergraduateBulletin_Major::getByName
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$major = UNL_UndergraduateBulletin_Major::getByName('Mechanical Engineering');


$test->assertTrue($major instanceof UNL_UndergraduateBulletin_Major, 'get by name');
$test->assertEquals('Mechanical Engineering', $major->title, 'correct major title');


?>
===DONE===
--EXPECT--
===DONE===