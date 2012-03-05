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
        foreach (UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($course->prerequisite) as $prereq_subject_code => $prereq_courses) {
            try {
                $prereq_subject = new UNL_Services_CourseApproval_SubjectArea($prereq_subject_code);
                foreach ($prereq_courses as $prereq_course) {
                    // try and get the listing
                    $prereq_subject->courses[$prereq_course];
                }
            } catch (Exception $e) {
                $missing_courses["$prereq_subject_code $prereq_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} prereqs";
            }
            unset($prereq_subject);
        }
        // Find courses within notes
        foreach (UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($course->notes) as $notes_subject_code => $notes_courses) {
            try {
                $notes_subject = new UNL_Services_CourseApproval_SubjectArea($notes_subject_code);
                foreach ($notes_courses as $notes_course) {
                    // try and get the listing
                    $notes_subject->courses[$notes_course];
                }
            } catch (Exception $e) {
                $missing_courses["$notes_subject_code $notes_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} notes";
            }
            unset($notes_subject);
        }
        // Find courses within description
        foreach (UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($course->description) as $desc_subject_code => $desc_courses) {
            try {
                $desc_subject = new UNL_Services_CourseApproval_SubjectArea($desc_subject_code);
                foreach ($desc_courses as $desc_course) {
                    // try and get the listing
                    $desc_subject->courses[$desc_course];
                }
            } catch (Exception $e) {
                $missing_courses["$desc_subject_code $desc_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} description";
            }
            unset($desc_subject);
        }
    }
}

foreach ($missing_courses as $missing_course => $found_in) {
    echo $missing_course.PHP_EOL;
    foreach ($found_in as $found) {
        echo '  - '.$found.PHP_EOL;
    }
}