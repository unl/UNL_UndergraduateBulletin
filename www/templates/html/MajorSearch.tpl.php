<?php
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
if ($context->options['format'] != 'partial') {
    echo $savvy->render('', 'MajorSearchForm.tpl.php');
}
if (!$context->count()) {
    echo 'Sorry, no matching areas of study';
} else {
    echo '<h2>'.$context->count().' result(s)</h2>'; ?>
    <ul id="majorListing">
    <?php foreach ($context as $major): ?>
    <li><a href="<?php echo $url; ?>major/<?php echo urlencode($major->getRaw('title')); ?>"><?php echo $major->title; ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php
}
?>