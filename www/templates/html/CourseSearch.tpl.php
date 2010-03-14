<?php
if ($context->options['format'] != 'partial') {
    echo $savvy->render('', 'CourseSearchForm.tpl.php');
}
if (!$context->results->count()) {
    echo 'Sorry, no matching courses';
} else {
    echo '<h2>'.$context->results->count().' results</h2>';
    foreach ($context->results as $course) {
        echo $savvy->render($course);
    }
}
?>