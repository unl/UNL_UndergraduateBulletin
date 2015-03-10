<?php
    /* @var $context UNL_Services_CourseApproval_Course */
    $url = $controller->getURL();
    $class = 'course';
    
    if (isset($context->subject)) {
        // If the subject has been injected by the SubjectAwareCourseIterator or Listing
        $subject = $context->subject;
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
    ?>
    
    <dt class="<?php echo $class ?>">
        <div class="wdn-grid-set">
            <div class="wdn-col-one-fourth bp1-wdn-col-one-fifth bp2-wdn-col-one-sixth">
                <div class="courseID">
                    <span class="subjectCode"><?php echo $subject ?></span>
                    <span class="number <?php echo $number_class ?>"><?php echo $listings ?></span>
                </div>
            </div>
            <div class="wdn-col-three-fourths bp1-wdn-col-four-fifths bp2-wdn-col-five-sixths">    
                <a class="coursetitle" href="<?php echo $permalink ?>"><?php echo $context->title ?></a>
                <?php if (!empty($crosslistings)): ?>
                    <span class="crosslistings">Crosslisted as <?php echo $crosslistings ?></span>
                <?php endif; ?>
            </div>
        </div>
    </dt>
    <dd class="<?php echo $class ?>">
        <div class="wdn-grid-set">
            <div class="wdn-col-full bp1-wdn-col-four-fifths bp2-wdn-col-five-sixths wdn-pull-right">
            <?php if (!empty($context->prerequisite)): ?>
                <div class='prereqs'>Prereqs: <?php echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('prerequisite'), $url) ?></div>
            <?php endif; ?>
            
            <?php if (!empty($context->notes)): ?>
                <div class='notes'><?php echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('notes'), $url) ?></div>
            <?php endif; ?>
            
                <div class="wdn-grid-set">
                    <div class="bp2-wdn-col-two-thirds info-1">
                    <?php if (!empty($context->description)): ?>
                        <div class="description"><?php echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('description'), $url) ?></div>
                    <?php else: ?>
                        <div class="description">This course has no description.</div>
                    <?php endif; ?>
                    
                    <?php 
                    $subsequent_courses = $context->getSubsequentCourses($course_search_driver->getRawObject());
                    $sub_course_array = array();
                    foreach ($subsequent_courses as $subsequent_course) {
                        $sub_course_array[] = $subsequent_course->getHomeListing()->subjectArea.' '.$subsequent_course->getHomeListing()->courseNumber;
                    }
                    ?>
                    <?php if (count($sub_course_array)): ?>
                        <div class="subsequent">This course is a prerequisite for: 
                            <?php echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks(implode(', ', $sub_course_array), $url) ?>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="bp2-wdn-col-one-third info-2">
                        <table class="zentable cool details">
                        <?php echo $savvy->render($context, 'Course/Credits.tpl.php'); ?>
                        <?php if (!empty($format)): ?>
                            <tr class="format">
                                <td class="label">Course Format:</td>
                                <td class="value"><?php echo $format ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php 
                        $methods = '';
                        foreach ($context->deliveryMethods as $method) {
                            $methods .= $method . ', ';
                        }
                        $methods = trim($methods, ', ');
                        ?>
                            <tr class="deliveryMethods">
                                <td class="label">Course Delivery:</td>
                                <td class="value"><?php echo $methods ?></td>
                           </tr>
                       <?php if (!empty($context->aceOutcomes)): ?>
                           <?php 
                           $ace = array();
                           foreach($context->aceOutcomes as $outcome) {
                               $ace[] = '<abbr title="'.UNL_UndergraduateBulletin_ACE::$descriptions[$outcome].'">'.$outcome.'</abbr>';
                           }
                           ?>
                           <tr class="aceOutcomes">
                                <td class="label">ACE Outcomes:</td>
                                <td class="value"><?php echo implode(', ', $ace) ?></td>
                           </tr>
                       <?php endif; ?>
                
                       <?php if (!empty($groups)): ?>
                           <tr class="groups">
                               <td class="label">Groups:</td>
                               <td class="value"><?php echo $groups ?></td>
                           </tr>
                       <?php endif; ?>
                       
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </dd>
