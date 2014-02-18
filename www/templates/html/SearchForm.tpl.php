<?php
$course_search = 'active';
$major_search  = '';

if ($controller->options['view'] == 'searchmajors') {
    $course_search = '';
    $major_search  = 'active';
}
?>
<div class="wdn-inner-wrapper">
    <div id="search_forms">
        <h3 id="search_label">Find a <span class="option <?php echo $course_search; ?>" id="course" tabindex="0">Course</span> or find a <span class="option <?php echo $major_search; ?>" id="major" tabindex="0">Major/Degree</span>
        </h3>
        <?php
        echo $savvy->render('', 'CourseSearchForm.tpl.php');
        echo $savvy->render('', 'MajorList/SearchForm.tpl.php');
        ?>
    </div>
</div>