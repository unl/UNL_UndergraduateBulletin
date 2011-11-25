--TEST--
Course prereq search test 
--FILE--
<?php
require_once __DIR__ . '/../test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$results = $search->byPrerequisite('MATH 104');
$test->assertIsa('UNL_Services_CourseApproval_Search_Results', $results, 'Search returns a result object');
$test->assertEquals(1, count($results), 'Count the number of MATH 104 prereq results');

?>
===DONE===
--EXPECT--
===DONE===