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
<h1>Select A Major or Area of Study</h1>
<ul>
    <?php foreach ($context as $major):
    $class = '';
    if (isset($major->description->quickpoints['Minor Available'])) {
        if (preg_match('/^Yes/', $major->description->quickpoints['Minor Available'])) {
            $class .= 'minorAvailable ';
        }
    }
    
    if (isset($major->college)) {
        $class .= $major->college->abbreviation.' ';
    }
    ?>
    <li class="<?php echo trim($class); ?>"><a href="<?php echo $url; ?>major/<?php echo urlencode($major->getRaw('title')); ?>"><?php echo $major->title; ?></a></li>
    <?php endforeach; ?>
</ul>