<?php
$course_search = 'active';
$major_search  = '';

if ($controller->options['view'] == 'searchmajors') {
    $course_search = '';
    $major_search  = 'active';
}

$isCourseCatalog = false;
if ($controller->getRawObject() instanceof UNL\UndergraduateBulletin\CatalogController) {
    $isCourseCatalog = true;
}
?>
<div class="wdn-band" id="search_forms">
    <div class="wdn-inner-wrapper">
        <?php if (!$isCourseCatalog): ?>
            <h2 class="clear-top" id="search_label">Find a <span class="option <?php echo $course_search; ?>" id="course" tabindex="0">Course</span> or find a <span class="option <?php echo $major_search; ?>" id="major" tabindex="0">Major/Degree</span></h2>
            <?php echo $savvy->render(null, 'Course/SearchForm.tpl.php') ?>
            <?php echo $savvy->render(null, 'Major/SearchForm.tpl.php') ?>
        <?php else: ?>
            <h2 class="clear-top" id="search_label">Find a Course</h2>
            <?php echo $savvy->render(null, 'Course/SearchForm.tpl.php') ?>
        <?php endif; ?>
    </div>
</div>
