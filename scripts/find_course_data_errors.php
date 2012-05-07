#!/usr/bin/env php -q
<?php
if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

error_reporting(E_ALL);

$missing_courses = array();

foreach (new UNL_UndergraduateBulletin_SubjectAreas() as $subject_area) {
    /* @var $subject_area UNL_UndergraduateBulletin_SubjectArea */
    foreach ($subject_area->courses as $course) {
        /* @var $course UNL_Services_CourseApproval_Course */
        // Find courses within prereqs
        foreach (UNL_UndergraduateBulletin_EPUB_Utilities::findUnknownCourses($course->prerequisite) as $prereq_subject_code => $prereq_courses) {
            foreach ($prereq_courses as $prereq_course) {
                $missing_courses["$prereq_subject_code $prereq_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} prereqs";
            }
        }
        // Find courses within notes
        foreach (UNL_UndergraduateBulletin_EPUB_Utilities::findUnknownCourses($course->notes) as $notes_subject_code => $notes_courses) {
            foreach ($notes_courses as $notes_course) {
                $missing_courses["$notes_subject_code $notes_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} notes";
            }
        }
        // Find courses within description
        foreach (UNL_UndergraduateBulletin_EPUB_Utilities::findUnknownCourses($course->description) as $desc_subject_code => $desc_courses) {
            foreach ($desc_courses as $desc_course) {
                $missing_courses["$desc_subject_code $desc_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} description";
            }
        }
    }
}

foreach ($missing_courses as $missing_course => $found_in) {
    echo $missing_course.PHP_EOL;
    foreach ($found_in as $found) {
        echo '  - '.$found.PHP_EOL;
    }
}