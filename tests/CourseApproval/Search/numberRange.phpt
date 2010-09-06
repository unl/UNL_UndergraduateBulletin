--TEST--
Course number search test 
--FILE--
<?php
require_once __DIR__ . '/../test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$results = $search->byAny('2XX');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Count the number of results');

$results = $search->byAny('2xx');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Count the number of results');

$results = $search->byAny('1XX');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(3, count($results), 'Count the number of results');

$results = $search->byAny('3xx');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(0, count($results), 'Count the number of results');

$results = $search->byAny('ACCT 2xx');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Count the number of results');

$results = $search->byAny('ACCT 2XX');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Count the number of results');

?>
===DONE===
--EXPECT--
===DONE===