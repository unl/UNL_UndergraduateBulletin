<?php

use UNL\UndergraduateBulletin\Edition\Editions;

$latest  = Editions::getLatest();
$current = UNL\UndergraduateBulletin\Controller::getEdition();
$count = 0;
$fount = false; // Whether or not we're showing the current edition
$published = Editions::getPublished();
?>

<div class="wdn_notice" data-overlay="maincontent">
    <div class="close">
        <a href="#">Close this notice</a>
    </div>
    <div class="message">
        <p class="title">Attention</p>
        <p>This is the site for old bulletin data. Please head to <a href="http://catalog.unl.edu">UNL's Course Catalog</a> for updated course and program information.</p>
    </div>
</div>

<div id="versioning">
    <ul>
        <li class="close"><span>+</span></li>
        <?php
        $class = '';
        if ($latest->getURL() == $current->getURL()) {
            $fount = true;
            $class = 'selected';
        }
        ?>
        <li class="<?php echo $class; ?>"><a href="<?php echo $latest->getURL(); ?>"><?php echo $latest->getRange(); ?> <em>(Latest Edition)</em></a></li>
        <?php foreach ($published as $edition): ?>
            <?php
            if ($edition->getRange() == $latest->getRange()) {
                continue;
            }

            $count++;
            $class = '';

            if ($edition->getURL() == $current->getURL()) {
                $fount = true;
                $class = 'selected';
            }
            ?>
            <li class="<?php echo $class; ?>"><a href="<?php echo $edition->getURL(); ?>"><?php echo $edition->getRange(); ?></a></li>
            <?php if ($count == 2) break; // Only pull two latest entries ?>
        <?php endforeach; ?>
        <?php if (!$fount) {
                $class = 'selected'; ?>
             <li class="<?php echo $class; ?>"><a href="<?php echo $current->getURL(); ?>"><?php echo $current->getRange(); ?></a></li>
        <?php } ?>

        <li><a href="<?php echo $current->getURL(); ?>bulletinrules">More info, and other archived bulletins</a></li>
    </ul>
</div>

<script>
  WDN.initializePlugin('notice');
</script>