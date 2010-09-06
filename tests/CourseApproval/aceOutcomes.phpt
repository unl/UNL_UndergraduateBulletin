--TEST--
Course ACE outcomes test 
--FILE--
<?php
require_once 'test_framework.php';
$listing = new UNL_Services_CourseApproval_Listing('AECN', 425);
$test->assertTrue(is_array($listing->aceOutcomes), 'Ace outcomes returned is an array');
$test->assertEquals(2, count($listing->aceOutcomes), 'Count the number of activities');
?>
===DONE===
--EXPECT--
===DONE===