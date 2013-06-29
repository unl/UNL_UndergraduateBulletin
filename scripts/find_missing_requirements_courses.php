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


    echo '****************************************************'.PHP_EOL
         .$college->name.PHP_EOL;
    
    /* @var $college UNL_UndergraduateBulletin_College */
    foreach ($college->majors as $major) {

        /* @var $major UNL_UndergraduateBulletin_Major */
        $missing_courses = UNL_UndergraduateBulletin_EPUB_Utilities::findUnknownCourses($major->getDescription()->description);
        if (empty($missing_courses)) {
            continue;
        }

        echo $major->title.' ('.$major->getURL().') unknown courses:'.PHP_EOL;
        foreach ($missing_courses as $missing_subject_code=>$missing_course_numbers) {
            foreach ($missing_course_numbers as $missing_course_number) {
                echo "  - $missing_subject_code $missing_course_number\n";
            }
        }

    }
}

