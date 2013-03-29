--TEST--
Search test
--FILE--
<?php
require_once 'test_framework.php';
$search = new UNL_Services_CourseApproval_Search();

$courses = $search->byNumber('201');
$test->assertEquals(2, count($courses), 'Two results returned');

$courses = $search->byTitle('Accounting');
$test->assertEquals(2, count($courses), 'Two results returned');

foreach ($courses as $course) {
    $test->assertNotFalse(
        strpos($course->title, 'Accounting'),
        'Course title contains the word Accounting'
    );
}

$courses = $search->numberSuffixQuery('04');
$test->assertEquals(1, count($courses), 'One *04 result returned');

$query1 = $search->subjectAreaQuery('NREE');
$courses = $search->driver->getQueryResult($query1);
$test->assertEquals(2, count($courses), 'Two results returned for NREE');

$query2 = $search->subjectAreaQuery('AECN');
$courses = $search->driver->getQueryResult($query2);
$test->assertEquals(2, count($courses), 'Two results returned for AECN');

$query = $search->intersectQuery($query1, $query2);
$courses = $search->driver->getQueryResult($query);
$test->assertEquals(1, count($courses), 'Intersection of two queries');

$courses = $search->graduateCourses();
$test->assertEquals(1, count($courses), 'One graduate course returned');


?>
===DONE===
--EXPECT--
===DONE===