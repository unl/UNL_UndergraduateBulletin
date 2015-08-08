<?php
if (isset($parent->context->options)
    && $parent->context->options['view'] == 'subject') {
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $context->subject.' | Undergraduate Bulletin | University of Nebraska-Lincoln');
    UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>'.$context->subject.'</h1>');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li>'.$context->subject.'</li>
    </ul>
    ');
}
?>
<h2 id="<?php echo $context->subject; ?>"> Courses of Instruction (<?php echo $context->subject; ?>)</h2>
<div class="wdn-grid-set">
    <div class="bp2-wdn-col-one-fourth">
        <?php echo $savvy->render($context->getFilters(), 'CourseFilters.tpl.php'); ?>
    </div>
    <div class="bp2-wdn-col-three-fourths">
    <?php foreach ($context->courses as $course): ?>
        <?php echo $savvy->render($course); ?>
    <?php endforeach; ?>
    </div>
</div>
