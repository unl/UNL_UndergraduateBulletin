<?php
$course_search = 'active';
$major_search  = '';

if ($controller->options['view'] == 'searchmajors') {
    $course_search = '';
    $major_search  = 'active';
}
?>
<div class="wdn-band" id="search_forms">
    <div class="wdn-inner-wrapper">
            <h2 class="clear-top" id="search_label">Find a <span class="option <?php echo $course_search; ?>" id="course" tabindex="0">Course</span> or find a <span class="option <?php echo $major_search; ?>" id="major" tabindex="0">Major/Degree</span></h2>
            <?php
            echo $savvy->render('', 'Course/SearchForm.tpl.php');
            echo $savvy->render('', 'Major/SearchForm.tpl.php');
            ?>
    </div>
</div>
