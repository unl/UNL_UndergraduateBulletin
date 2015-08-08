--TEST--
Get course home listing test 
--FILE--
<?php
require_once 'test_framework.php';
$listing = UNL_Services_CourseApproval_Listing::createFromSubjectAndNumber('NREE', 845);
$test->assertTrue($listing->course->getHomeListing() instanceof UNL_Services_CourseApproval_Listing, 'Home listing is a listing object');
$test->assertEquals('445', $listing->course->getHomeListing()->courseNumber, 'Home listing course number');
?>
===DONE===
--EXPECT--
===DONE===