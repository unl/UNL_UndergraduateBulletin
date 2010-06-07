<?php
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    $class = 'course';
    if (isset($parent->context->subjectArea)) {
        $subject = $parent->context->subjectArea;
    } elseif (isset($parent->context->subject)) {
        $subject = $parent->context->subject;
    } else {
        $subject = $context->getHomeListing()->subjectArea;
    }
    $listings      = array();
    $crosslistings = array();
    $groups        = array();

    foreach ($context->codes as $listing) {
        if ($listing->subjectArea == $subject) {

            if (!isset($permalink)) {
                $permalink = $url.'courses/'.$subject.'/'.$listing->courseNumber;
            }

            $listings[] = $listing->courseNumber;
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
    $number_class = 'l'.count($listings);
    sort($listings);
    $listings = implode('/', $listings);
    if (!empty($cltext)) {
        $crosslistings = '<span class="crosslisting">'.trim($cltext, ', ').'</span>';
    }
    
    $credits = '';
    if (!isset($context->credits)) {
        $credits = 'N/A';
    } else {
        if (isset($context->credits['Single Value'])) {
            $credits = $context->credits['Single Value'];
        } elseif (isset($context->credits['Lower Range Limit'])) {
            if (isset($context->credits['Lower Range Limit'])) {
                $credits = $context->credits['Lower Range Limit'].'-';
            }
            if (isset($context->credits['Upper Range Limit'])) {
                $credits .= $context->credits['Upper Range Limit'].',';
            }
            if (isset($context->credits['Per Career Limit'])) {
                $credits .= ' max '.$context->credits['Per Career Limit'];
            }
            $credits = trim($credits, ', ');
        }
    }
    
    $format = '';
    foreach ($context->activities as $type=>$activity) {
        $class .= ' '.$type;
        $format .= UNL_Services_CourseApproval_Course_Activities::getFullDescription($type);
        if (isset($activity->hours)) {
            $format .= ' '.$activity->hours;
        }
        $format .= ', ';
    }
    $format = trim($format, ', ');
    
    if (!empty($context->aceOutcomes)) {
        $class .= ' ace ace_'.implode(' ace_', $context->aceOutcomes);
    }

    if (isset($parent->parent->context->options)
        && $parent->parent->context->options['view'] == 'course') {
        UNL_UndergraduateBulletin_Controller::setReplacementData('head', '
        <link rel="alternate" type="text/xml" href="'.$permalink.'?format=xml" />
        <link rel="alternate" type="text/javascript" href="'.$permalink.'?format=json" />
        <link rel="alternate" type="text/html" href="'.$permalink.'?format=partial" />');
        UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.$subject.' '.$listings.': '.$context->title);
        UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li>'.$subject.' '.$listings.': '.$context->title.'</li>
    </ul>
    ');
        echo '<dl>';
    }
    
    echo "
        <dt class='$class'>
            <span class='subjectCode'>".$subject."</span>
            <span class='number $number_class'>$listings</span>
            <span class='title'>".$context->title."<a href='$permalink'>Hide desc.</a></span>";
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
        if (count($context->campuses)
            && (count($context->campuses) > 1
            || $context->campuses[0] != 'UNL')) {
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
            $ace = '';
            foreach($context->aceOutcomes as $outcome) {
                $ace .= '<abbr title="'.UNL_UndergraduateBulletin_ACE::$descriptions[$outcome].'">'.$outcome.'</abbr>, ';
            }
            $ace = trim($ace, ', ');
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
            echo  "<div class='prereqs'>Prereqs: ".UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('prerequisite'))."</div>";
        }
        if (!empty($context->notes)) {
            echo  "<div class='notes'>".UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('notes'))."</div>";
        }
        if (!empty($context->description)) {
            echo  "<div class='description'>".$context->getRaw('description')."</div>";
        }
        
    echo  "</dd>";
    if (isset($parent->parent->context->options)
        && $parent->parent->context->options['view'] == 'course') {
        echo '</dl>';
    }
