<?php

$subjectAreas = new UNL_UndergraduateBulletin_SubjectAreas();
$edition = UNL_UndergraduateBulletin_Controller::getEdition();

$fields = array(
    'Edition',
    'Department',
    'DepartmentAbbr',
    'CourseCode',
    'CourseLabel',
    'CourseDescription',
    'Units',
    'LectureHours',
    'LabHours',
    'OtherHours',
    'Prerequisite',
    'Corequisite',
    'Recommended',
    'Offered',
    'GradeBasis',
);

$delimitArray($fields);

$baseCsvCourse = array_fill_keys($fields, '');

foreach ($context->results as $course) {
    $csvCourse = $baseCsvCourse;
    
    $csvCourse['Edition'] = $edition->getYear();
    $csvCourse['CourseLabel'] = $course->title;
    $csvCourse['CourseDescription'] = strip_tags(html_entity_decode($course->description));
    $csvCourse['Units'] = $course->credits['Single Value'];
    $csvCourse['Prerequisite'] = strip_tags(html_entity_decode($course->prerequisite));

    foreach ($course->codes as $listing) {
        $subject = (string)$listing->subjectArea;
        
        if (!isset($subjectAreas[$subject])) {
            //Skip because we do not have a title for the subject code.
            continue;
        }

        $csvCourse['Department']     = $subjectAreas[$subject];
        $csvCourse['DepartmentAbbr'] = $subject;
        $csvCourse['CourseCode']     = $subject . " " . (string)$listing->courseNumber;

        $delimitArray(array_intersect_key($csvCourse, $baseCsvCourse));
    }
}
