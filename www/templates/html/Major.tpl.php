<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $context->title.' | Undergraduate Bulletin | University of Nebraska-Lincoln');
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>'.$context->title.'</h1>');


$subhead = '';
foreach ($context->colleges as $college) {
    $subhead .= $college->name.' '; 
}

UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1><span class="subhead">'.$subhead.'</span>'.$context->title.' </h1>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>'.$context->title.'</li>
</ul>
');
?>
<div class="wdn-inner-wrapper">
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
        try {
            $plans = $context->getFourYearPlans();
            ?>
            <li class="<?php echo ($controller->options['view']=='plans')?'selected':''; ?>"><a href="<?php echo $context->getRawObject()->getURL(); ?>/plans">4-Year Plans</a></li>
            <?php
        } catch (Exception $plans) {
            // no plan data could be found, $plans now contains an exception object
        }
        try {
            $outcomes = $context->getLearningOutcomes();
            ?>
            <li class="<?php echo ($controller->options['view']=='outcomes')?'selected':''; ?>"><a href="<?php echo $context->getRawObject()->getURL(); ?>/outcomes">Learning Outcomes</a></li>
            <?php
        } catch (Exception $outcomes) {
            // no outcome data could be found, $outcomes now contains an exception object
        }
        ?>
    </ul>
    <?php
    switch($context->options['view']) {
        case 'major':
            echo $savvy->render($context->description);
            break;
        case 'plans':
            echo $savvy->render($plans);
            break;
        case 'outcomes':
            echo $savvy->render($outcomes);
            break;
        default:
            echo $savvy->render($context->subjectareas);
    }

    ?>
</div>