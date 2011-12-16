--TEST--
Search test
--FILE--
<?php
require_once 'test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$courses = $search->byNumber('201');
$test->assertEquals(2, count($courses), 'Two results returned');

?>
===DONE===
--EXPECT--
===DONE===