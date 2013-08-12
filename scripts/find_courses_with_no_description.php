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
        if (!isset($course->description)
            || $course->description == '') {
            $missing_courses[] = "$subject_area {$course->getHomeListing()->courseNumber}";
        }
    }
}

foreach ($missing_courses as $missing_course) {
    echo $missing_course.PHP_EOL;
}