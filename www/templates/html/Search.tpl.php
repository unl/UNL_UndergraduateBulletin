<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | Search');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Search</li>
</ul>
');
?>
<ul class="wdn_tabs">
    <li><a href="#courseResults">Courses<sup><?php echo count($context->getRaw('courses')); ?></sup></a></li>
    <li><a href="#majorResults">Majors/Areas of Study<sup><?php echo count($context->getRaw('majors')); ?></sup></a></li>
</ul>

<div class="wdn_tabs_content">
    <div id="courseResults">
        <?php echo $savvy->render($context->courses); ?>
    </div>
    <div id="majorResults">
        <?php echo $savvy->render($context->majors); ?>
    </div>
</div>