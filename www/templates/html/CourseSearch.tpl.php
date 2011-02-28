<?php

if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}

$url = UNL_UndergraduateBulletin_Controller::getURL();
if (isset($context->options['view'])
    && $context->options['view'] == 'searchcourses') {
    UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | Courses | Search');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li><a href="'.$url.'courses/">Courses</a></li>
        <li>Search</li>
    </ul>
    ');
}
if ($context->options['format'] != 'partial') {
    echo $savvy->render('', 'CourseSearchForm.tpl.php');
}
if (!count($context->results)) {
    echo 'Sorry, no matching courses';
} else {
    if ($context->options['format'] != 'partial') {
        echo '<div class="col left">';
        echo $savvy->render($context, 'CourseFilters.tpl.php');
        echo '</div>';
        echo '<div class="three_col right">';
    }
    echo '<h2 class="resultCount">'.count($context->results).' results</h2>';
    echo '<dl>';
    foreach ($context->results as $course) {
        echo $savvy->render($course);
    }
    echo '</dl>';
    if ($context->options['format'] != 'partial') {
        // add the pagination links if necessary
        if (count($context) > $context->options['limit']) {
            $pager = new stdClass();
            $pager->total  = count($context);
            $pager->limit  = $context->options['limit'];
            $pager->offset = $context->options['offset'];
            $pager->url    = $url.'courses/search?q='.urlencode($context->options['q']);
            echo $savvy->render($pager, 'PaginationLinks.tpl.php');
        }
        echo '</div>';
    }
}
?>