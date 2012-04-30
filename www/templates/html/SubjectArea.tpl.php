<?php
if (isset($parent->context->options)
    && $parent->context->options['view'] == 'subject') {
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $context->subject.' | Undergraduate Bulletin | University of Nebraska-Lincoln');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li>'.$context->subject.'</li>
    </ul>
    ');
}
?>
<h2 class="sec_main" id="<?php echo $context->subject; ?>"> Courses of Instruction (<?php echo $context->subject; ?>)</h2>
<div class="grid3 first">
    <?php echo $savvy->render($context, 'CourseFilters.tpl.php'); ?>
</div>
<div class="grid9">
    <dl>
    <?php
    foreach ($context->courses as $course) {
        echo $savvy->render($course);
    }
    ?>
    </dl>
</div>
