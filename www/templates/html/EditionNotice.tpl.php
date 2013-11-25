<?php
$latest  = UNL_UndergraduateBulletin_Editions::getLatest();
$current = UNL_UndergraduateBulletin_Controller::getEdition();
/* $count = 0; */
?>
<div id="versioning">
    <!--
    <div class="action opened">
        <a href="#">Hide</a>
    </div>
    -->
    <ul>
        <?php
        $class = '';
        if ($latest->getURL() == $current->getURL()) {
            $class = 'selected';
        }
        ?>
        <li class="<?php echo $class; ?>"><a href="<?php echo $latest->getURL(); ?>"><?php echo $latest->getRange(); ?> <em>(Latest Edition)</em></a></li>
        <?php foreach (UNL_UndergraduateBulletin_Editions::getPublished() as $edition):
            if ($edition->getRange() == $latest->getRange()) continue;
            $class = '';
            if ($edition->getURL() == $current->getURL()) {
                $class = 'selected';
            }
            ?>
            <li class="<?php echo $class; ?>"><a href="<?php echo $edition->getURL(); ?>"><?php echo $edition->getRange(); ?></a></li>
        <?php endforeach; ?>
        <li><a href="<?php echo $current->getURL(); ?>bulletinrules">More info, and other archived bulletins</a></li>
    </ul>
</div>
