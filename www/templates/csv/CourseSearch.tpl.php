<?php
if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}


//$group by course code
$courses = array();
$i = 0;
foreach ($context->results as $course) {
    $csvCourse                 = array();
    $csvCourse['courseCode']   = ""; //Leave empty for now...
    $csvCourse['title']        = $course->title;
    $csvCourse['description']  = $course->description;
    $csvCourse['prerequisite'] = $course->prerequisite;

    //Credits
    $csvCourse['creditsSingleValue']   = $course->credits['Single Value'];
    $csvCourse['creditsLowerLimit']    = $course->credits['Lower Range Limit'];
    $csvCourse['creditsUpperLimit']    = $course->credits['Upper Range Limit'];
    $csvCourse['creditsSemesterLimit'] = $course->credits['Per Semester Limit'];
    $csvCourse['creditsCareerLimit']   = $course->credits['Per Career Limit'];
    $csvCourse['dfRemoval']            = $course->getDFRemoval();

    //Terms
    $possibleTerms = UNL_Services_CourseApproval_Course::getPossibleTermsOffered();
    $possibleTerms = array_keys($possibleTerms);
        
    foreach ($possibleTerms as $term) {
        $csvCourse['term' . $term] = "";
    }

    if (!empty($course->termsOffered)) {
        foreach ($course->termsOffered as $term) {
            $term = ucfirst($term);
            if (!in_array($term, $possibleTerms)) {
                continue;
            }

            $csvCourse['term' . $term] = true;
        }
    }

    //deliveryMethods
    $possibleDeliveries = UNL_Services_CourseApproval_Course::getPossibleDeliveryMethods();
    $possibleDeliveries = array_keys($possibleDeliveries);
    
    foreach ($possibleDeliveries as $delivery) {
        $csvCourse['delivery' . $delivery] = "";
    }

    if (!empty($course->deliveryMethods)) {
        foreach ($course->deliveryMethods as $method) {
            $method = ucfirst($method);
            if (!in_array($method, $possibleDeliveries)) {
                continue;
            }

            $csvCourse['delivery' . $method] = true;
        }
    }

    //Campuses
    $possibleCampuses = UNL_Services_CourseApproval_Course::getPossibleCampuses();
    $possibleCampuses = array_keys($possibleCampuses);
    
    foreach ($possibleCampuses as $campus) {
        $csvCourse['campus' . $campus] = "";
    }

    if (!empty($course->campuses)) {
        foreach ($course->campuses as $campus) {
            $campus = strtoupper($campus);
            if (!in_array($campus, $possibleCampuses)) {
                continue;
            }

            $csvCourse['campus' . $campus] = true;
        }
    }

    //Ace outcomes
    $possibleACE = UNL_Services_CourseApproval_Course::getPossibleAceOutcomes();
    $possibleACE = array_keys($possibleACE);
    
    foreach ($possibleACE as $ACE) {
        $csvCourse['ace' . $ACE] = "";
    }

    if (!empty($course->aceOutcomes)) {
        foreach ($course->aceOutcomes as $outcome) {
            if (!in_array((int)$outcome, $possibleACE)) {
                continue;
            }
            
            $csvCourse['ace' . $outcome] = true;
        }
    }

    //Activities
    $possibleActivities = UNL_Services_CourseApproval_Course::getPossibleActivities();
    $possibleActivities = array_keys($possibleActivities);
    
    foreach ($possibleActivities as $act) {
        $csvCourse['activity' . ucfirst($act)] = "";
    }

    foreach ($course->activities as $activity) {
        $type = strtolower($activity->type);
        if (!in_array($type, $possibleActivities)) {
            continue;
        }

        $csvCourse['activity' . ucfirst($type)] = true;
    }
    
    foreach ($course->codes as $listing) {
        $csvCourse['courseCode'] = (string)$listing->subjectArea . " " . (string)$listing->courseNumber;

        if ($i == 0) {
            $delimitArray($delimiter, array_keys($csvCourse));
        }

        $delimitArray($delimiter, $csvCourse);
        
        $i++;
    }
}