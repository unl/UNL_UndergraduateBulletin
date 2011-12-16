--TEST--
Subsequent course test
--FILE--
<?php
require_once 'test_framework.php';
$listing = new UNL_Services_CourseApproval_Listing('MATH', '104');

$courses = $listing->course->getSubsequentCourses();

$test->assertEquals(1, count($courses), 'One subsequent course returned');
foreach ($courses as $course) {
    $test->assertEquals('Introductory Accounting I', $course->title, 'Course title');
}

?>
===DONE===
--EXPECT--
===DONE===