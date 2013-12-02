--TEST--
ACE Learning Outcome search test
--FILE--
<?php
require_once dirname(__DIR__) . '/test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$courses = $search->byAny('ACE 3');
$test->assertEquals(1, count($courses), 'One ACE 3 result returned');

$courses = $search->byAny('ACE 10');
$test->assertEquals(3, count($courses), 'Three ACE 10 results returned');

$courses = $search->byAny('ACE');
$test->assertEquals(4, count($courses), 'Four ACE results returned');

?>
===DONE===
--EXPECT--
===DONE===