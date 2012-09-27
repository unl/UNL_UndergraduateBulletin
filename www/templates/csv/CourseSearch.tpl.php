<?php
if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}

$i = 0;
foreach ($context->results as $course) {
    $csvCourse = array();
    $csvCourse['title'] = $course->title;
    $csvCourse['description'] = $course->description;
    $csvCourse['prerequisite'] = $course->prerequisite;
    
    //handle Codes
    $codes = array();
    foreach ($course->codes as $listing) {
        $codes[] = (string)$listing->subjectArea . " " . (string)$listing->courseNumber;
    }

    $csvCourse['courseCodes'] = implode(",", $codes);
    
    if ($i == 0) {
        $delimitArray($delimiter, array_keys($csvCourse));
    }
    
    $delimitArray($delimiter, $csvCourse);
    
    $i++;
}