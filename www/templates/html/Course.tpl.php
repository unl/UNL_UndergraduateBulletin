<?php
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    $class = 'course';
    $subject = (isset($parent->context->subjectArea))? $parent->context->subjectArea:$parent->context->subject;
    $listings = '';
    $crosslistings = array();
    $groups = array();
    foreach ($context->codes as $listing) {
        if ($listing->subjectArea == $subject) {
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
    if (isset($context->credits['Single Value'])) {
        $credits = $context->credits['Single Value'];
    } else {
        // @TODO Handle multi-value credits
    }
    
    $format = '';
    foreach ($context->activities as $type=>$activity) {
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
    
    if (!empty($context->aceOutcomes)) {
        $class .= ' ace_'.implode(' ace_', $context->aceOutcomes);
    }
    
    echo "
        <dt class='$class'>
            <span class='subjectCode'>".$subject."</span>
            <span class='number'>$listings</span>
            <span class='title'>".$context->title."<a href='#'>Hide desc.</a></span>";
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
        if (count($context->campuses) == 1
            && $context->campuses[0] != 'UNL') {
            echo  '<tr class="campus">
                    <td class="label">Campus:</td>
                    <td class="value">'.implode(', ', $context->campuses).'</td>
                   </tr>';
        }
        echo  '<tr class="deliveryMethods">
                <td class="label">Course Delivery:</td>
                <td class="value">'.implode(', ', $context->deliveryMethods).'</td>
               </tr>';
        $ace = '';
        if (!empty($context->aceOutcomes)) {
            $ace = implode(', ', $context->aceOutcomes);
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

        if (!empty($context->prerequisite)) {
            echo  "<p class='prereqs'>Prereqs: ".preg_replace('/([A-Z]{3,4})\s+([0-9]{2,3}[A-Z]?)/', '<a class="course" href="'.$url.'courses/$1/$2">$0</a>', $context->prerequisite)."</p>";
        }
        if (!empty($context->notes)) {
            echo  "<p class='notes'>".$context->notes."</p>";
        }
        echo  "<p class='description'>".iconv("UTF-8", "ISO-8859-1//TRANSLIT", $context->description)."</p>";
        
    echo  "</dd>";
?>