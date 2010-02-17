<?php
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    $class = 'course';
    $listings = '';
    $crosslistings = array();
    $groups = array();
    foreach ($course->codes as $listing) {
        if ($listing->subjectArea == $context->subject) {
            $listings .= $listing->courseNumber.'/';
            if ($listing->hasGroups()) {
                $groups = array_merge($groups, $listing->groups);
                foreach ($listing->groups as $group) {
                    $class .= ' grp_'.md5($group);
                }
            }
        } else {
            if (!isset($crosslistings[(string)$listing->subjectArea])) {
                $crosslistings[(string)$listing->subjectArea] = array();
            }
            $crosslistings[(string)$listing->subjectArea][] = $listing->courseNumber;
        }
    }
    $groups = implode(', ', array_unique($groups));
    $cltext = '';
    foreach ($crosslistings as $cl_subject=>$cl_numbers) {
        $cltext .= ', '.$cl_subject.' '.implode('/', $cl_numbers);
    }
    $listings = trim($listings, '/');
    if (!empty($cltext)) {
        $crosslistings = '<span class="crosslisting">'.trim($cltext, ', ').'</span>';
    }
    
    $credits = '';
    if (isset($course->credits['Single Value'])) {
        $credits = $course->credits['Single Value'];
    }
    
    $format = '';
    foreach ($course->activities as $type=>$activity) {
        $class .= ' '.$type;
        switch ($type) {
            case 'lec':
                $format .= 'Lecture';
                break;
            case 'lab':
                $format .= 'Lab';
                break;
            case 'quz':
                $format .= 'Quiz';
                break;
            case 'rct':
                $format .= 'Recitation';
                break;
            case 'stu':
                $format .= 'Studio';
                break;
            case 'fld':
                $format .= 'Field';
                break;
            case 'ind':
                $format .= 'Independent Study';
                break;
            case 'psi':
                $format .= 'Personalized System of Instruction';
                break;
            default:
                throw new Exception('Unknown activity type! '.$type);
                break;
        }
        $format .= ' '.$activity->hours.', ';
    }
    $format = trim($format, ', ');
    
    if (!empty($course->aceOutcomes)) {
        $class .= ' ace_'.implode(' ace_', $course->aceOutcomes);
    }
    
    echo "
        <dt class='$class'>
            <span class='subjectCode'>".htmlentities($context->subject)."</span>
            <span class='number'>$listings</span>
            <span class='title'>".htmlentities($course->title)."<a href='#'>Hide desc.</a></span>";
        if (!empty($crosslistings)) {
            echo  '<span class="crosslistings">Crosslisted as '.$crosslistings.'</span>';
        }
        echo  "</dt>
        <dd class='$class'>";
        echo  '<table class="zentable cool details">';
        echo  '<tr class="credits">
                <td class="label">Credit Hours:</td>
                <td class="value">'.$credits.'</td>
                </tr>';
        if (!empty($format)) {
            echo  '<tr class="format">
                    <td class="label">Course Format:</td>
                    <td class="value">'.$format.'</td>
                   </tr>';
        }
        if (count($course->campuses) == 1
            && $course->campuses[0] != 'UNL') {
            echo  '<tr class="campus">
                    <td class="label">Campus:</td>
                    <td class="value">'.implode(', ', $course->campuses).'</td>
                   </tr>';
        }
        echo  '<tr class="deliveryMethods">
                <td class="label">Course Delivery:</td>
                <td class="value">'.implode(', ', $course->deliveryMethods).'</td>
               </tr>';
        $ace = '';
        if (!empty($course->aceOutcomes)) {
            $ace = implode(', ', $course->aceOutcomes);
            echo  '<tr class="aceOutcomes">
                    <td class="label">ACE Outcomes:</td>
                    <td class="value">'.$ace.'</td>
                   </tr>';
        }
        if (!empty($groups)) {
            echo  '<tr class="groups">
                    <td class="label">Groups:</td>
                    <td class="value">'.$groups.'</td>
                   </tr>';
        }
        echo  '</table>';

        if (!empty($course->prerequisite)) {
            echo  "<p class='prereqs'>Prereqs: ".preg_replace('/([A-Z]{3,4})\s+([0-9]{2,3}[A-Z]?)/', '<a class="course" href="'.$url.'$1/$2">$0</a>', htmlentities($course->prerequisite))."</p>";
        }
        if (!empty($course->notes)) {
            echo  "<p class='notes'>".htmlentities($course->notes)."</p>";
        }
        echo  "<p class='description'>".htmlentities(iconv("UTF-8", "ISO-8859-1//TRANSLIT", $course->description))."</p>";
        
    echo  "</dd>";
?>