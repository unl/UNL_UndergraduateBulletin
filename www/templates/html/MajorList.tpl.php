<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'Majors/Areas of Study | Undergraduate Bulletin | University of Nebraska-Lincoln');
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>Majors/Areas of Study</h1>');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Majors/Areas of Study</li>
</ul>
');
?>
<div class="grid3 first">
    <?php echo $savvy->render(null, 'MajorList/Filters.tpl.php'); ?>
</div>
<div class="grid9 majorlist2col">
    <h2 class="clear-top">Select A Major or Area of Study</h2>
    <?php echo $savvy->render($context, 'MajorList/UnorderedList.tpl.php'); ?>
</div>