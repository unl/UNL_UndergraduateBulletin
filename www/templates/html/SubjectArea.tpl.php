<?php
echo '<h2 class="sec_main"> Courses of Instruction ('.$context->subject.')</h2>';
echo '<a href="#" id="toggleAllCourseDescriptions">Hide all course descriptions</a>';
 ?>
 <div class="col left">
    <?php echo $savvy->render($context, 'CourseFilters.tpl.php'); ?>
</div>
<div class="three_col right">
    <dl>
    <?php
    foreach ($context->courses as $course) {
        echo $savvy->render($course);
    }
    ?>
    </dl>
</div>
