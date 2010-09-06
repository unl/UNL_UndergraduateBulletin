--TEST--
Course honors search test 
--FILE--
<?php
require_once __DIR__ . '/../test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$results = $search->byAny('honors');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(1, count($results), 'Count the number of results');

$results = $search->byAny('201H');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(1, count($results), 'Count the number of results');

$results = $search->byAny('201h');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(1, count($results), 'Count the number of results');

$results = $search->byAny('ACCT 201H');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(1, count($results), 'Count the number of results');

$results = $search->byAny('ACCT 201h');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(1, count($results), 'Count the number of results');

?>
===DONE===
--EXPECT--
===DONE===