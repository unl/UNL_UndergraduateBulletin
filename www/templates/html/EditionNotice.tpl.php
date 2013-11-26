<?php
$latest  = UNL_UndergraduateBulletin_Editions::getLatest();
$current = UNL_UndergraduateBulletin_Controller::getEdition();
$count = 0;
$found_current = false; // Whether or not we're showing the current edition
?>
<div id="versioning">
    <ul>
        <li class="close"><span>+</span></li>
        <?php
        $class = '';
        if ($latest->getURL() == $current->getURL()) {
            $found_current = true;
            $class = 'selected';
        }
        ?>
        <li class="<?php echo $class; ?>"><a href="<?php echo $latest->getURL(); ?>"><?php echo $latest->getRange(); ?> <em>(Latest Edition)</em></a></li>
        <?php foreach (UNL_UndergraduateBulletin_Editions::getPublished() as $edition):
            if ($edition->getRange() == $latest->getRange()) continue;
            $count++;
            $class = '';
            if ($edition->getURL() == $current->getURL()) {
                $found_current = true;
                $class = 'selected';
            }
            ?>
            <li class="<?php echo $class; ?>"><a href="<?php echo $edition->getURL(); ?>"><?php echo $edition->getRange(); ?></a></li>
            <?php if ($count == 2) break; // Only pull two latest entries ?>

        <?php endforeach; ?>
        <?php if (!$found_current) { 
                $class = 'selected'; ?>
             <li class="<?php echo $class; ?>"><a href="<?php echo $current->getURL(); ?>"><?php echo $current->getRange(); ?></a></li>
        <?php } ?>

        <li><a href="<?php echo $current->getURL(); ?>bulletinrules">More info, and other archived bulletins</a></li>
    </ul>
</div>
