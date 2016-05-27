<?php

namespace UNLTest\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\SubjectArea\GraduateSortedCourses;
use UNL\Services\CourseApproval\Course\Listing;

class GraduateSortedCoursesTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicSort()
    {
        $unsortedCourses = [
            Listing::createFromSubjectAndNumber('TEAC', '498')->getCourse(),
            Listing::createFromSubjectAndNumber('TEAC', '802')->getCourse(),
            Listing::createFromSubjectAndNumber('TEAC', '806')->getCourse(),
        ];

        $expectedSortedCourses = [
            $unsortedCourses[1],
            $unsortedCourses[2],
            $unsortedCourses[0],
        ];

        $courses = new GraduateSortedCourses(new \ArrayIterator($unsortedCourses));
        $courses = iterator_to_array($courses, false);
        $this->assertEquals($expectedSortedCourses, $courses);
    }
}
