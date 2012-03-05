#!/usr/bin/env php
<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

$latest = UNL_UndergraduateBulletin_Editions::getLatest();

echo 'Updating all course data file'.PHP_EOL;

passthru('wget --no-check-certificate http://creq.unl.edu/courses/public-view/all-courses -O '.$latest->getCourseDataDir().'/all-courses.xml');

echo 'Now retrieving all courses by subject code.'.PHP_EOL;
$handle = fopen($latest->getCourseDataDir().'/subject_codes.csv', 'r');
while (($subject = fgetcsv($handle, 1000, ",", "'")) !== false) {
    if ($data = file_get_contents('http://creq.unl.edu/courses/public-view/all-courses/subject/'.$subject[0])) {
        file_put_contents($latest->getCourseDataDir().'/subjects/'.$subject[0].'.xml', $data);
    } else {
        echo 'Could not retrieve data for '.$subject[0].PHP_EOL;
    }
}
echo 'Done'.PHP_EOL;

echo 'Creating minimized course data file for JSON output.'.PHP_EOL;

$xml = UNL_Services_CourseApproval::getXCRIService()->getAllCourses();
$courses = new SimpleXMLElement($xml);
foreach ($courses as $course) {
    foreach (array(
        'prerequisite',
        'description',
        'effectiveSemester',
        'gradingType',
        'dfRemoval',
        'campuses',
        'deliveryMethods',
        'termsOffered',
        'activities',
        'credits',
        'notes',
    ) as $var) {
        unset($course->$var);
    }
}

$courses->asXML($latest->getCourseDataDir().'/all-courses-min.xml');


$courses = file_get_contents($latest->getCourseDataDir().'/all-courses-min.xml');

$courses = str_replace("    \n", "", $courses);

file_put_contents($latest->getCourseDataDir().'/all-courses-min.xml', $courses);




echo 'Done'.PHP_EOL;

echo 'Updating course search database for speedy searches.'.PHP_EOL;
include dirname(__FILE__).'/build_course_db.php';
echo 'Done'.PHP_EOL;
