<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $context->title.' | Undergraduate Bulletin | University of Nebraska-Lincoln');
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>'.$context->title.'</h1>');


$subhead = '';
foreach ($context->colleges as $college) {
    $subhead .= $college->name.' '; 
}

UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>'.$context->title.' <span class="subhead">'.$subhead.'</span></h1>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>'.$context->title.'</li>
</ul>
');
?>
<ul class="wdn_tabs disableSwitching">
    <li class="<?php echo ($controller->options['view']=='major')?'selected':''; ?>"><a href="<?php echo $context->getRawObject()->getURL(); ?>"><span>Description</span></a></li>
    <?php if (count($context->subjectareas)): ?>
    <li class="<?php echo ($controller->options['view']=='courses')?'selected':''; ?>"><a href="<?php echo $context->getRawObject()->getURL(); ?>/courses"><span>Courses</span></a>
        <?php if ($controller->options['view']=='courses'): ?>
        <ul>
        <?php foreach ($context->subjectareas as $area): ?>
            <li><a href="#<?php echo $area; ?>"><?php echo $area; ?></a></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </li>
    <?php endif; ?>
    <?php
    $plans = $context->getFourYearPlans();
    if (count($plans) || true):
    ?>
    <li class="<?php echo ($controller->options['view']=='plans')?'selected':''; ?>"><a href="<?php echo $context->getRawObject()->getURL(); ?>/plans">Plans</a></li>
    <?php endif; ?>
</ul>
<?php
if ($context->options['view'] == 'major') {
    echo $savvy->render($context->description);
} else {
    echo $savvy->render($context->subjectareas);
}

?>