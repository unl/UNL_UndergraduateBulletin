<?php
require dirname(__FILE__).'/../../../config.sample.php';
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

$courses->asXML(dirname(__FILE__).'/all-courses-min.xml');


$courses = file_get_contents(dirname(__FILE__).'/all-courses-min.xml');

$courses = str_replace("    \n", "", $courses);

file_put_contents(dirname(__FILE__).'/all-courses-min.xml', $courses);
