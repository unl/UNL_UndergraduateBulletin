--TEST--
Search test
--FILE--
<?php
require_once dirname(__DIR__) . '/test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$courses = $search->byAny('ACE 10 AECN');
$test->assertEquals(2, count($courses), 'byAny for AECN and ACE 10');

$courses = $search->byAny('AECN ACE 10');
$test->assertEquals(2, count($courses), 'byAny for ACE 10 and AECN');

$courses = $search->byAny('MATH ACE');
$test->assertEquals(1, count($courses), 'One MATH ACE course');


?>
===DONE===
--EXPECT--
===DONE===