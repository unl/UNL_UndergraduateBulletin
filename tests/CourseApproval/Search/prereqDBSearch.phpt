--TEST--
Course prereq database search test 
--FILE--
<?php
require_once __DIR__ . '/../test_framework.php';
UNL_UndergraduateBulletin_Controller::setEdition(new UNL_UndergraduateBulletin_Edition(array('year'=>2014)));
$search = new UNL_Services_CourseApproval_Search(new UNL_UndergraduateBulletin_CourseSearch_DBSearcher());

$results = $search->byPrerequisite('MATH 104');
$test->assertIsa('UNL_UndergraduateBulletin_CourseSearch_DBSearchResults', $results, 'Search returns a result object');
$test->assertEquals(17, count($results), 'Count the number of MATH 104 prereq results');

?>
===DONE===
--EXPECT--
===DONE===