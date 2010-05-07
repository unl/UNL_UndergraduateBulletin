<?php
if ($context->options['view'] == 'searchmajors') {
    $url = UNL_UndergraduateBulletin_Controller::getURL();
    UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | Majors | Search');
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
    echo $savvy->render('', 'MajorList/SearchForm.tpl.php');
}
?>
<div class="col left">
    <?php echo $savvy->render(null, 'MajorList/Filters.tpl.php'); ?>
</div>
<div class="three_col right">
    <?php 
    if (!$context->count()) {
        echo 'Sorry, no matching areas of study';
    } else {
        echo '<h2 class="resultCount">'.$context->count().' result(s)</h2>';
        echo $savvy->render($context, 'MajorList/UnorderedList.tpl.php');
    }
    ?>
</div>