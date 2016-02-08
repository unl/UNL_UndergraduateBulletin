#!/usr/bin/env php
<?php

use UNL\UndergraduateBulletin\EPUB\Utilities;
use UNL\UndergraduateBulletin\SubjectArea\SubjectAreas;

include __DIR__ . '/../test/bootstrap.php';
error_reporting(E_ALL);

$missing_courses = [];

foreach (new SubjectAreas() as $subject_area) {
    foreach ($subject_area->getCourses() as $course) {
        // Find courses within prereqs
        foreach (Utilities::findUnknownCourses($course->prerequisite) as $prereq_subject_code => $prereq_courses) {
            foreach ($prereq_courses as $prereq_course) {
                $missing_courses["$prereq_subject_code $prereq_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} prereqs";
            }
        }
        // Find courses within notes
        foreach (Utilities::findUnknownCourses($course->notes) as $notes_subject_code => $notes_courses) {
            foreach ($notes_courses as $notes_course) {
                $missing_courses["$notes_subject_code $notes_course"][] = "Found in $subject_area {$course->getHomeListing()->courseNumber} notes";
            }
        }
        // Find courses within description
        foreach (Utilities::findUnknownCourses($course->description) as $desc_subject_code => $desc_courses) {
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
