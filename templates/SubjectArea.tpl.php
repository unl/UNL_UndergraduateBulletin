<?php
echo '<h1>'.htmlentities($this->subject).'</h1>';

echo  '<dl>';

foreach ($this->courses as $course) {
    $listings = '';
    $crosslistings = '';
    foreach ($course->codes as $listing) {
        if ($listing->subjectArea == $this->subject) {
            $listings .= $listing->courseNumber.'/';
        } else {
            $crosslistings .= '<span class="crosslisting">'.$listing->subjectArea.' '.$listing->courseNumber.'</span>, ';
        }
    }
    $listings = trim($listings, '/');
    $crosslistings = trim($crosslistings, ', ');
    
    $credits = '';
    if (isset($course->credits['Single Value'])) {
        $credits = $course->credits['Single Value'];
    }
    
    $format = '';
    foreach ($course->activities as $type=>$activity) {
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
    
    echo "
        <dt class='course'>
            <span class='subjectCode'>".htmlentities($this->subject)."</span>
            <span class='number'>$listings</span>
            <span class='title'>".htmlentities($course->title)."</span>";
        if (!empty($crosslistings)) {
            echo  '<span class="crosslistings">Crosslisted as '.$crosslistings.'</span>';
        }
        echo  "</dt>
        <dd class='course'>";
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
//        echo  '<tr class="termsOffered alt">
//                                    <td class="label">Terms Offered:</td>
//                                    <td class="value">'.implode(', ', $course->termsOffered).'</td>
//                                    </tr>';
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
        echo  '</table>';

        if (!empty($course->prerequisite)) {
            echo  "<p class='prereqs'>Prereqs: ".htmlentities($course->prerequisite)."</p>";
        }
        if (!empty($course->notes)) {
            echo  "<p class='notes'>".htmlentities($course->notes)."</p>";
        }
        echo  "<p class='description'>".htmlentities($course->description)."</p>";
        
    echo  "</dd>";
}
echo  '</dl>';

?>