<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | Majors/Areas of Study');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Majors/Areas of Study</li>
</ul>
');
?>
<div class="col left">
    <?php echo $savvy->render(null, 'MajorList/Filters.tpl.php'); ?>
</div>
<div class="three_col right">
    <h1>Select A Major or Area of Study</h1>
    <?php echo $savvy->render($context, 'MajorList/UnorderedList.tpl.php'); ?>
</div>