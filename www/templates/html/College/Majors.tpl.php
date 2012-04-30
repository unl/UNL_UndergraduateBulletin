<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $context->college->name.' Majors | University of Nebraska-Lincoln');
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h2 class="college-name">'.$context->college->name.'</h2>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li><a href="'.$context->college->getURL().'">'.$context->college->name.'</a></li>
    <li>Majors</li>
</ul>
');
if (count($context)) {
    echo $savvy->render($context, 'MajorList/UnorderedList.tpl.php');
}
?>