--TEST--
Search test
--FILE--
<?php
require_once dirname(__DIR__) . '/test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$courses = $search->byAny('ACE 10');
$test->assertEquals(3, count($courses), 'Three ACE 10 results returned');

$courses = $search->byAny('AECN');
$test->assertEquals(2, count($courses), 'Two AECN results returned');

$query1 = $search->aceQuery('10');
$query2 = $search->subjectAreaQuery('AECN');
$query = $search->intersectQuery($query1, $query2);

$courses = $search->driver->getQueryResult($query);
$test->assertEquals(2, count($courses), 'Intersection of AECN and ACE 10 queries');

$courses = $search->byMany(array('ACE 10', 'AECN'));
$test->assertEquals(2, count($courses), 'byMany for AECN and ACE 10');

$courses = $search->byMany(array('AECN', 'ACE 10'));
$test->assertEquals(2, count($courses), 'byMany for ACE 10 and AECN');

$courses = $search->byAny('MATH');
$test->assertEquals(1, count($courses), 'One MATH course');

$courses = $search->byMany(array('MATH', 'ACE'));
$test->assertEquals(1, count($courses), 'One MATH ACE course');


?>
===DONE===
--EXPECT--
===DONE===