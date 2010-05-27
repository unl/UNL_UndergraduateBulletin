--TEST--
Test course credit information
--FILE--
<?php
require_once 'test_framework.php';
$listing = new UNL_Services_CourseApproval_Listing('CSCE', 196);
$test->assertTrue($listing->credits instanceof Countable, 'Credits is a countable object.');
$test->assertEquals(3, count($listing->credits), 'Three types of credits for this course.');

$test->assertEquals(1, $listing->credits['Lower Range Limit'], 'Array access by type.');
$test->assertEquals(3, $listing->credits['Upper Range Limit'], 'Array access by type 2.');
$test->assertEquals(6, $listing->credits['Per Semester Limit'], 'Array access by type 3.');
$test->assertFalse(isset($listing->credits['Single Value']), 'Course has no credit of this type.');
$test->assertTrue(isset($listing->credits['Lower Range Limit']), 'Course has credit of this type.');

$listing = new UNL_Services_CourseApproval_Listing('ACCT', 201);
$test->assertTrue($listing->credits instanceof Countable, 'Credits is a countable object.');
$test->assertEquals(1, count($listing->credits), 'Three types of credits for this course.');

$test->assertTrue(isset($listing->credits['Single Value']), 'Course has credit of this type.');
$test->assertEquals(3, $listing->credits['Single Value'], 'Array access by type.');

?>
===DONE===
--EXPECT--
===DONE===