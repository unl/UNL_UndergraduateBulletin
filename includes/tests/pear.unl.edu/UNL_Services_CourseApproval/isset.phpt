--TEST--
Sample Test
--FILE--
<?php
require_once 'test_framework.php';
$listing = new UNL_Services_CourseApproval_Listing('ACCT', 201);
$test->assertTrue(isset($listing->notes), 'Course has notes.');
$test->assertTrue(isset($listing->description), 'Course has description.');
$test->assertFalse(isset($listing->aceOutcomes), 'Course does NOT have ACE outcomes.');
?>
===DONE===
--EXPECT--
===DONE===