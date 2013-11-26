--TEST--
Course subject code search test 
--FILE--
<?php
require_once __DIR__ . '/../test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$results = $search->byAny('Accounting');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Search for "Accounting" should return two results');

$results = $search->byAny('accounting');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(2, count($results), 'Search for "accounting" (lowercase) should return two results');

?>
===DONE===
--EXPECT--
===DONE===