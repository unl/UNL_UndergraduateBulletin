--TEST--
Course details returned as arrays
--FILE--
<?php
require_once 'test_framework.php';
$listing = new UNL_Services_CourseApproval_Listing('ACCT', 201);

$test->assertTrue(is_array($listing->campuses), 'Campuses');
$test->assertTrue(is_array($listing->deliveryMethods), 'Delivery methods');
$test->assertTrue(is_array($listing->termsOffered), 'Terms offered');
?>
===DONE===
--EXPECT--
===DONE===