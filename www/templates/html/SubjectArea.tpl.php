<?php
if (isset($parent->context->options)
    && $parent->context->options['view'] == 'subject') {
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.$context->subject);
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li>'.$context->subject.'</li>
    </ul>
    ');
}
?>
<h2 class="sec_main"> Courses of Instruction (<?php echo $context->subject; ?>)</h2>
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
