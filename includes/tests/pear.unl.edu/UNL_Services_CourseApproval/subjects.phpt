--TEST--
Test Subjects
--FILE--
<?php
require_once 'test_framework.php';
$subject = new UNL_Services_CourseApproval_SubjectArea('ACCT');
$test->assertEquals('ACCT', $subject->subject, 'Returns correct subject code');
$test->assertEquals('ACCT', $subject->__toString(), '__tostring() Returns correct subject code');
$test->assertTrue($subject->courses instanceof ArrayAccess, 'Listings is an array');
$test->assertEquals(2, count($subject->courses), 'Count the number of courses.');
?>
===DONE===
--EXPECT--
===DONE===