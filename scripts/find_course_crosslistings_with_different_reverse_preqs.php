#!/usr/bin/env php -q
<?php
if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

error_reporting(E_ALL);

$diffsFound = 0;
$start = microtime(true);

foreach (new UNL_UndergraduateBulletin_SubjectAreas() as $subject_area) {
    /* @var $subject_area UNL_UndergraduateBulletin_SubjectArea */
    foreach ($subject_area->courses as $course) {
        /* @var $course UNL_Services_CourseApproval_Course */
        $crosslistings = $course->getListingsByType(UNL_Services_CourseApproval_Course::COURSE_CODE_TYPE_CROSS);
        if (!$crosslistings) {
            continue;
        }
        
        $homeListing = $course->getHomeListing();
        $homeSubsStatic = array();
        foreach ($homeListing->getSubsequentCourses() as $subCourse) {
            $subListing = $subCourse->getHomeListing();
            $homeSubsStatic[] = $subListing->subjectArea . ' ' . $subListing->courseNumber;
        }
        
        foreach ($crosslistings as $crosslisting) {
            $subsStatic = array();            
            
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
