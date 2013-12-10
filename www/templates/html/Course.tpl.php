<?php
    $url = $controller->getURL();
    /* example code for isArchvied and getNewestURL();
    if(UNL_UndergraduateBulletin_Controller::isArchived()){
        echo "This version may be out of date.  ".UNL_UndergraduateBulletin_Controller::getNewestURL();
    }
    */
    
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
        if ((string)$listing->subjectArea == (string)$subject) {

            if (!isset($permalink)) {
                $permalink = $url.'courses/'.$subject.'/'.$listing->courseNumber;
            }

            $listings[] = $listing->courseNumber;
            if ($listing->hasGroups()) {
                foreach ($listing->groups as $group) {
                    $groups[] = (string)$group;
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
    foreach ($crosslistings as $cl_subject => $cl_numbers) {
        $cltext .= ', '.$cl_subject.' '.implode('/', $cl_numbers);
    }
    $number_class = 'l'.count($listings);
    sort($listings);
    $listings = implode('/', $listings);
    if (!empty($cltext)) {
        $crosslistings = '<span class="crosslisting">'.trim($cltext, ', ').'</span>';
    }

    $format = '';
    foreach ($context->activities as $type => $activity) {
        $class .= ' '.$type;
        $format .= UNL_Services_CourseApproval_Course_Activities::getFullDescription($type);
        if (isset($activity->hours)) {
            $format .= ' '.$activity->hours;
        }
        $format .= ', ';
    }
    $format = trim($format, ', ');
    
    if (!empty($context->aceOutcomes)) {
        $class .= ' ace';
        foreach ($context->aceOutcomes as $outcome) {
            $class .= ' ace_'.$outcome;
        }
    }

    if (isset($parent->parent->context->options)
        && $parent->parent->context->options['view'] == 'course') {
        UNL_UndergraduateBulletin_Controller::setReplacementData('head', '
        <link rel="alternate" type="text/xml" href="'.$permalink.'?format=xml" />
        <link rel="alternate" type="text/javascript" href="'.$permalink.'?format=json" />
        <link rel="alternate" type="text/html" href="'.$permalink.'?format=partial" />');
        UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $subject.' '.$listings.': '.$context->title.' | Undergraduate Bulletin | University of Nebraska-Lincoln');
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
        	<div class='courseID'>
            	<span class='subjectCode'>".$subject."</span>
            	<span class='number $number_class'>$listings</span>
            </div>
            <a class='title' href='" . $permalink . "' title='A permalink to " . $context->title . "'>" . $context->title . "</a>";
        if (!empty($crosslistings)) {
            echo  '<span class="crosslistings">Crosslisted as '.$crosslistings.'</span>';
        }
        echo  "</dt>
        <dd class='$class'>
            <div class='wdn-grid-set'>
                <div class='bp2-wdn-col-two-thirds'>";

                    if (!empty($context->prerequisite)) {
                        echo  "<div class='prereqs'>Prereqs: ".UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('prerequisite'), $url)."</div>\n";
                    }
                    if (!empty($context->notes)) {
                        echo  "<div class='notes'>".UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('notes'), $url)."</div>\n";
                    }
                    if (!empty($context->description)) {
                        echo  "<div class='description'>".UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('description'), $url)."</div>\n";
                    } else {
                        echo "<div class='description'>This course has no description.</div>";
                    }
                    $subsequent_courses = $context->getSubsequentCourses($course_search_driver->getRawObject());
                    $sub_course_array = array();
                    foreach ($subsequent_courses as $subsequent_course) {
                        $sub_course_array[] = $subsequent_course->getHomeListing()->subjectArea.' '.$subsequent_course->getHomeListing()->courseNumber;
                    }
                    if (count($sub_course_array)) {
                        echo  "<div class='subsequent'>This course is a prerequisite for: ";
                        echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks(implode(', ', $sub_course_array), $url);
                        echo "</div>\n";
                    }
                echo "</div>"; // Close the text content
                echo '<div class="bp2-wdn-col-one-third details">';
                echo  '<table class="zentable cool details">';
                echo $savvy->render($context, 'Course/Credits.tpl.php');
                if (!empty($format)) {
                    echo  '<tr class="format">
                            <td class="label">Course Format:</td>
                            <td class="value">'.$format.'</td>
                           </tr>';
                }
                if (count($context->campuses)
                    && (count($context->campuses) > 1
                    || $context->campuses[0] != 'UNL')) {
                    $campuses = '';
                    foreach ($context->campuses as $campus) {
                        $campuses .= $campus . ',';
                    }
                    $campuses = trim($campuses, ',');
                    echo  '<tr class="campus">
                            <td class="label">Campus:</td>
                            <td class="value">'.$campus.'</td>
                           </tr>';
                }
                $methods = '';
                foreach ($context->deliveryMethods as $method) {
                    $methods .= $method . ', ';
                }
                $methods = trim($methods, ', ');
                echo  '<tr class="deliveryMethods">
                        <td class="label">Course Delivery:</td>
                        <td class="value">'.$methods.'</td>
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
                echo  '</table></div>'.PHP_EOL;
    echo  "</div></dd>";
    if (isset($parent->parent->context->options)
        && $parent->parent->context->options['view'] == 'course') {
        echo '</dl>';
    }
