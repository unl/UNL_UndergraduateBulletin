<?php
if ($context->options['view'] == 'searchmajors') {
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'Majors Search | Undergraduate Bulletin | University of Nebraska-Lincoln');
    UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>Majors Search</h1>');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li><a href="'.$url.'majors/">Majors/Areas of Study</a></li>
        <li>Search</li>
    </ul>
    ');
}
if ($context->options['format'] != 'partial') {
    echo '<div class="activate_major">';
    echo $savvy->render('', 'SearchForm.tpl.php');
    echo '</div>';
}
?>
<div class="wdn-grid-set">
    <div class="wdn-inner-wrapper">
        <div class="bp1-wdn-col-one-fourth">
            <?php echo $savvy->render(null, 'MajorList/Filters.tpl.php'); ?>
        </div>
        <div class="bp1-wdn-col-three-fourths">
            <?php 
            if (!$context->count()) {
                echo 'Sorry, no matching areas of study';
            } else {
                echo '<h2 class="resultCount">'.$context->count().' result(s)</h2>';
                echo $savvy->render($context, 'MajorList/UnorderedList.tpl.php');
            }
            ?>
        </div>
    </div>
</div>