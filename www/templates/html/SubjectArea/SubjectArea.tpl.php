<?php
if (isset($parent->context->options) && $parent->context->options['view'] == 'subject') {
    $url = $controller->getRawObject()::getURL();
    $controller->getRawObject()::setReplacementData('doctitle', $context->getSubject() . ' Courses | Undergraduate Bulletin | University of Nebraska-Lincoln');
    $controller->getRawObject()::setReplacementData('pagetitle', '<h1>'.$context->getSubject().' Courses</h1>');
    $controller->getRawObject()::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li>'.$context->getSubject().'</li>
    </ul>
    ');
}
?>
<div class="wdn-band course-list">
    <div class="wdn-inner-wrapper">
        <div class="wdn-grid-set">
            <div class="bp2-wdn-col-one-fourth">
                <?php echo $savvy->render($context->getFilters(), 'Course/Filters.tpl.php'); ?>
            </div>
            <div class="bp2-wdn-col-three-fourths wdn-pull-right" id="results<?php echo $context->getSubject() ?>">
            <?php foreach ($context->getCourses() as $course): ?>
                <?php echo $savvy->render($course); ?>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
