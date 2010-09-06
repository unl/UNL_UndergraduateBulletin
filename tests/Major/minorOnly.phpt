--TEST--
UNL_UndergraduateBulletin_Major::minorOnly
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$major = UNL_UndergraduateBulletin_Major::getByName('Mechanical Engineering');
$test->assertFalse($major->minorOnly(), 'minor available');

$major = UNL_UndergraduateBulletin_Major::getByName('Accounting');
$test->assertFalse($major->minorOnly(), 'minor available');

$major = UNL_UndergraduateBulletin_Major::getByName('Statistics Minor (ASC)');
$test->assertTrue($major->minorOnly(), 'minor available');

?>
===DONE===
--EXPECT--
===DONE===