<?php
if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}

$subjectAreas = new UNL_UndergraduateBulletin_SubjectAreas();

//$group by course code
$courses = array();

$i = 0;
foreach ($context->results as $course) {
    $csvCourse                   = array();
    $csvCourse['Department']     = "";
    $csvCourse['DepartmentAbbr'] = "";
    $csvCourse['CourseCode']     = ""; //Leave empty for now...
    $csvCourse['CourseLabel']    = $course->title;
    $csvCourse['Description']    = strip_tags(html_entity_decode($course->description));
    $csvCourse['Prerequisite']   = strip_tags(html_entity_decode($course->prerequisite));

    //Credits
    $csvCourse['Units'] = $course->credits['Single Value'];
    
    foreach ($course->codes as $listing) {
        $subject = (string)$listing->subjectArea;
        
        if (!isset($subjectAreas[$subject])) {
            //Skip because we do not have a title for the subject code.
            continue;
        }

        $csvCourse['Department']     = $subjectAreas[$subject];
        $csvCourse['DepartmentAbbr'] = $subject;
        $csvCourse['CourseCode']     = $subject . " " . (string)$listing->courseNumber;

        if ($i == 0) {
            $delimitArray(array_keys($csvCourse));
        }

        $delimitArray($csvCourse);
        
        $i++;
    }
}