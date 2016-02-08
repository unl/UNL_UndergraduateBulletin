#!/usr/bin/env php
<?php

include __DIR__ . '/../test/bootstrap.php';
error_reporting(E_ALL);

$missing_courses = array();

foreach (new UNL\UndergraduateBulletin\College\Colleges() as $college) {
    echo '****************************************************'.PHP_EOL
         .$college->name.PHP_EOL;

    foreach ($college->majors as $major) {
        $missing_courses = UNL\UndergraduateBulletin\EPUB\Utilities::findUnknownCourses($major->getDescription()->description);
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
