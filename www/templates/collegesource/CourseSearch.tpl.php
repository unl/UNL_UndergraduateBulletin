<?php
if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}

$majors = new UNL_UndergraduateBulletin_MajorLookup();

//$group by course code
$courses = array();
$i = 0;
foreach ($context->results as $course) {
    $csvCourse                 = array();
    
    $csvCourse['Department']   = "";
    $csvCourse['DepartmentAbbr']   = "";
    
    $csvCourse['CourseCode']   = ""; //Leave empty for now...
    $csvCourse['CourseLabel']  = $course->title;
    $csvCourse['Description']  = strip_tags(html_entity_decode($course->description));
    $csvCourse['Prerequisite'] = strip_tags(html_entity_decode($course->prerequisite));

    //Credits
    $csvCourse['Units']                = $course->credits['Single Value'];
    
    foreach ($course->codes as $listing) {
        $subject = (string)$listing->subjectArea;
        
        $department = $subject;
        if (isset($majors[$subject])) {
            $department = $majors[$subject];
        }
        
        $csvCourse['Department'] = $department;
        $csvCourse['DepartmentAbbr'] = $subject;
        $csvCourse['CourseCode'] = $subject . " " . (string)$listing->courseNumber;

        if ($i == 0) {
            $delimitArray($delimiter, array_keys($csvCourse));
        }

        $delimitArray($delimiter, $csvCourse);
        
        $i++;
    }
}