<?php

$fields = array(
    'courseCode',
    'title',
    'description',
    'prerequisite',
    'creditsSingleValue',
    'creditsLowerLimit',
    'creditsUpperLimit',
    'creditsSemesterLimit',
    'creditsCareerLimit',
    'dfRemoval',  
);

$possibleTerms = UNL_Services_CourseApproval_Course::getPossibleTermsOffered();
$possibleTerms = array_keys($possibleTerms);

foreach ($possibleTerms as $term) {
    $fields[] = 'term' . $term;
}

$possibleDeliveries = UNL_Services_CourseApproval_Course::getPossibleDeliveryMethods();
$possibleDeliveries = array_keys($possibleDeliveries);

foreach ($possibleDeliveries as $delivery) {
    $fields[] = 'delivery' . $delivery;
}

$possibleCampuses = UNL_Services_CourseApproval_Course::getPossibleCampuses();
$possibleCampuses = array_keys($possibleCampuses);

foreach ($possibleCampuses as $campus) {
    $fields[] = 'campus' . $campus;
}

$possibleACE = UNL_Services_CourseApproval_Course::getPossibleAceOutcomes();
$possibleACE = array_keys($possibleACE);

foreach ($possibleACE as $ACE) {
    $fields[] = 'ace' . $ACE;
}

$possibleActivities = UNL_Services_CourseApproval_Course::getPossibleActivities();
$possibleActivities = array_keys($possibleActivities);

foreach ($possibleActivities as $act) {
    $fields[]= 'activity' . ucfirst($act);
}

$delimitArray($fields);

$baseCsvCourse = array_fill_keys($fields, '');

foreach ($context->results as $course) {
    $csvCourse = $baseCsvCourse;
    
    $csvCourse['title']        = $course->title;
    $csvCourse['description']  = $course->description;
    $csvCourse['prerequisite'] = $course->prerequisite;

    $csvCourse['creditsSingleValue']   = $course->credits['Single Value'];
    $csvCourse['creditsLowerLimit']    = $course->credits['Lower Range Limit'];
    $csvCourse['creditsUpperLimit']    = $course->credits['Upper Range Limit'];
    $csvCourse['creditsSemesterLimit'] = $course->credits['Per Semester Limit'];
    $csvCourse['creditsCareerLimit']   = $course->credits['Per Career Limit'];
    $csvCourse['dfRemoval']            = $course->getDFRemoval();

    //Terms
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
    if (!empty($course->aceOutcomes)) {
        foreach ($course->aceOutcomes as $outcome) {
            if (!in_array((int)$outcome, $possibleACE)) {
                continue;
            }
            
            $csvCourse['ace' . $outcome] = true;
        }
    }

    //Activities
    foreach ($course->activities as $activity) {
        $type = strtolower($activity->type);
        if (!in_array($type, $possibleActivities)) {
            continue;
        }

        $csvCourse['activity' . ucfirst($type)] = true;
    }
    
    foreach ($course->codes as $listing) {
        $csvCourse['courseCode'] = (string)$listing->subjectArea . " " . (string)$listing->courseNumber;

        $delimitArray(array_intersect_key($csvCourse, $baseCsvCourse));
    }
}
