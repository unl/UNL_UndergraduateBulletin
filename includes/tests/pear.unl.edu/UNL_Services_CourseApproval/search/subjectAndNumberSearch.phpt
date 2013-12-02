--TEST--
Course subject and number search test 
--FILE--
<?php
require_once __DIR__ . '/../test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$results = $search->byAny('ACCT 201');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Count the number of results');

$results = $search->byAny('acct 201');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Count the number of results');

$results = $search->byAny('AECN 425');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(1, count($results), 'Count the number of results');

$results = $search->byAny('LLLL 101');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(0, count($results), 'Count the number of results');

?>
===DONE===
--EXPECT--
===DONE===