<?php
echo $savvy->render('', 'CourseSearchForm.tpl.php');
foreach ($context->results as $course) {
    echo $savvy->render($course);
}
?>