<?php
if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}


//$group by course code
$courses = array();
$i = 0;
foreach ($context->results as $course) {
    foreach ($course->codes as $listing) {
       
        $csvCourse                 = array();
        $csvCourse['courseCode']   = (string)$listing->subjectArea . " " . (string)$listing->courseNumber;
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
        $possibleTerms = array('Fall', 'Spring', 'Summer');
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
        $possibleDeliveries = array('Classroom', 'Web', 'Correspondence');
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
        $possibleCampuses = array("UNL", "UNO", "UNMC", "UNK");
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
        $possibleACE = range(1,10);
        foreach ($possibleACE as $ACE) {
            $csvCourse['ace' . $ACE] = "";
        }
        
        if (!empty($course->aceOutcomes)) {
            foreach ($course->aceOutcomes as $outcome) {
                if (!in_array($outcome, $possibleACE)) {
                    continue;
                }
                
                $csvCourse['ACE' . $outcome] = true;
            }
        }
        
        //Activities
        $possibleActivities = array('Lec', 'Lab', 'Stu', 'Fld', 'Quz', 'Rct', 'Ind', 'Psi');
        foreach ($possibleActivities as $act) {
            $csvCourse['activity' . $act] = "";
        }
        
        foreach ($course->activities as $activity) {
            $type = ucfirst($activity->type);
            if (!in_array($type, $possibleActivities)) {
                continue;
            }

            $csvCourse['activity' . $type] = true;
        }

        if ($i == 0) {
            $delimitArray($delimiter, array_keys($csvCourse));
        }

        $delimitArray($delimiter, $csvCourse);
        
        $i++;
    }
}