--TEST--
Sample Test
--FILE--
<?php
require_once 'test_framework.php';
$listing = UNL_Services_CourseApproval_Listing::createFromSubjectAndNumber('ACCT', 201);
$test->assertFalse($listing->dfRemoval, 'D or F removal');

$listing = UNL_Services_CourseApproval_Listing::createFromSubjectAndNumber('ENSC', 110);
$test->assertFalse($listing->dfRemoval, 'D or F removal');

$listing = UNL_Services_CourseApproval_Listing::createFromSubjectAndNumber('CSCE', '150A');
$test->assertTrue($listing->dfRemoval, 'D or F removal');


?>
===DONE===
--EXPECT--
===DONE===