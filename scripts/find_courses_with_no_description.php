#!/usr/bin/env php -q
<?php

include __DIR__ . '/../test/bootstrap.php';
error_reporting(E_ALL);

$missing_courses = array();

foreach (new UNL\UndergraduateBulletin\SubjectArea\SubjectAreas() as $subject_area) {
    foreach ($subject_area->courses as $course) {
        if (!isset($course->description) || $course->description == '') {
            $missing_courses[] = "$subject_area {$course->getHomeListing()->courseNumber}";
        }
    }
}

foreach ($missing_courses as $missing_course) {
    echo $missing_course.PHP_EOL;
}
