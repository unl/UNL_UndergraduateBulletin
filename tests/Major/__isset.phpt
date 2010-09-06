--TEST--
UNL_UndergraduateBulletin_Major::getByName
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$major = UNL_UndergraduateBulletin_Major::getByName('Mechanical Engineering');

$test->assertEquals('Mechanical Engineering', $major->title, 'correct major title');
$test->assertTrue(isset($major->college), 'College is set');
$test->assertFalse(isset($major->fakevariable), 'fakevariable is not set');


?>
===DONE===
--EXPECT--
===DONE===