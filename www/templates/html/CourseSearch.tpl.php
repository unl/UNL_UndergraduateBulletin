<?php
if ($context->options['format'] != 'partial') {
    echo $savvy->render('', 'CourseSearchForm.tpl.php');
}
if (!$context->results->count()) {
    echo 'Sorry, no matching courses';
} else {
    echo '<h2>'.$context->results->count().' results</h2>';
    if ($context->options['format'] != 'partial') {
        echo '<div class="col left">';
        echo $savvy->render($context, 'CourseFilters.tpl.php');
        echo '</div>';
        echo '<div class="three_col right">';
    }
    foreach ($context->results as $course) {
        echo $savvy->render($course);
    }
    if ($context->options['format'] != 'partial') {
        echo '</div>';
    }
}
?>