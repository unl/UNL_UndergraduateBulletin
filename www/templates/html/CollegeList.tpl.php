<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | Colleges');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Colleges</li>
</ul>
');
?>
<h2>Colleges and Other Areas</h2>
<ul id="collegeListing">
<?php
foreach ($context as $college) {
    echo '<li><a href="'.$url.'college/'.urlencode($college->getRaw('name')).'">'.$college->name.'</a></li>';
} ?>
</ul>
