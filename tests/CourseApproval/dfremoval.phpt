--TEST--
Sample Test
--FILE--
<?php
require_once 'test_framework.php';
$listing = new UNL_Services_CourseApproval_Listing('ACCT', 201);
$test->assertFalse($listing->dfRemoval, 'D or F removal');

$listing = new UNL_Services_CourseApproval_Listing('ENSC', 110);
$test->assertFalse($listing->dfRemoval, 'D or F removal');

$listing = new UNL_Services_CourseApproval_Listing('CSCE', '150A');
$test->assertTrue($listing->dfRemoval, 'D or F removal');


?>
===DONE===
--EXPECT--
===DONE===