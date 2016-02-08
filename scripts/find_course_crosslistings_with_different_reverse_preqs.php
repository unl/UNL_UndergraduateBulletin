#!/usr/bin/env php -q
<?php

include __DIR__ . '/../test/bootstrap.php';
error_reporting(E_ALL);

$diffsFound = 0;
$start = microtime(true);

foreach (new UNL\UndergraduateBulletin\SubjectArea\SubjectAreas() as $subject_area) {
    /* @var $subject_area UNL_UndergraduateBulletin_SubjectArea */
    foreach ($subject_area->courses as $course) {
        /* @var $course UNL_Services_CourseApproval_Course */
        $crosslistings = $course->getListingsByType(UNL\Services\CourseApproval\Course\Course::COURSE_CODE_TYPE_CROSS);
        if (!$crosslistings) {
            continue;
        }

        $homeListing = $course->getHomeListing();
        $homeSubsStatic = [];
        foreach ($homeListing->getSubsequentCourses() as $subCourse) {
            $subListing = $subCourse->getHomeListing();
            $homeSubsStatic[] = $subListing->subjectArea . ' ' . $subListing->courseNumber;
        }

        foreach ($crosslistings as $crosslisting) {
            $subsStatic = [];

            foreach ($crosslisting->getSubsequentCourses() as $subCourse) {
                $subListing = $subCourse->getHomeListing();
                $subsStatic[] = $subListing->subjectArea . ' ' . $subListing->courseNumber;
            }

            $subsDiff = array_diff($homeSubsStatic, $subsStatic);

            if (!$subsDiff) {
                continue;
            }

            echo sprintf(
                "Found different reverse prereqs for course %s and its crosslisting %s:\n",
                $homeListing->subjectArea . ' ' . $homeListing->courseNumber,
                $crosslisting->subjectArea . ' ' . $homeListing->courseNumber
            );
            echo sprintf(
                "%s: %s\n",
                $homeListing->subjectArea . ' ' . $homeListing->courseNumber,
                implode(', ', $homeSubsStatic)
            );
            echo sprintf(
                "%s: %s\n",
                $crosslisting->subjectArea . ' ' . $crosslisting->courseNumber,
                implode(', ', $subsStatic)
            );
            echo sprintf(
                "Difference: %s\n\n",
                implode(', ', $subsDiff)
            );

            ++$diffsFound;
        }
    }
}

$end = microtime(true);
echo sprintf("Found %d crosslistings that do not match their home listing. [%.3f secs]\n", $diffsFound, $end - $start);
