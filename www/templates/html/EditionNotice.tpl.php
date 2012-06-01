<?php
$latest  = UNL_UndergraduateBulletin_Editions::getLatest();
$current = UNL_UndergraduateBulletin_Controller::getEdition();
?>
<div id="versioning">
    <div class="content">
        <h5>This is the <span><?php echo $current->getRange(); ?></span> Undergraduate Bulletin</h5>
        <p>Other editions:</p>
        <ul>
            <?php
            $class = '';
            if ($latest->getURL() == $current->getURL()) {
                $class = 'selected';
            }
            ?>
            <li class="<?php echo $class; ?>"><a href="<?php echo $latest->getURL(); ?>">Latest Edition <em>(<?php echo $latest->getRange(); ?>)</em></a></li>
            <?php foreach (UNL_UndergraduateBulletin_Editions::getPublished() as $edition):
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
    <div class="action opened">
        <a href="#">Hide</a>
    </div>
</div>
