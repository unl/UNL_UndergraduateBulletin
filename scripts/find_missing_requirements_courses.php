#!/usr/bin/env php -q
<?php
if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

error_reporting(E_ALL);

$missing_courses = array();

// Set edition
UNL_UndergraduateBulletin_Controller::setEdition(UNL_UndergraduateBulletin_Editions::getLatest());

foreach (new UNL_UndergraduateBulletin_CollegeList() as $college) {


    /* @var $college UNL_UndergraduateBulletin_College */
    foreach ($college->majors as $major) {
        /* @var $major UNL_UndergraduateBulletin_Major */

        echo $major->title.' unknown courses:'.PHP_EOL;

        foreach (UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($major->getDescription()->description)  as $description_subject_code=>$description_courses) {
            try {
                $description_subject = new UNL_Services_CourseApproval_SubjectArea($description_subject_code);
                foreach ($description_courses as $description_course) {
                    // try and get the listing
                    $check_course = $description_subject->courses[$description_course];
                    unset($check_course);
                }
            } catch (Exception $e) {
                echo "  - $description_subject_code $description_course\n";
                $missing_courses["$description_subject_code $description_course"][] = "Found in $major->title description";
            }
            unset($description_subject);
        }
    }
}

var_dump($missing_courses);