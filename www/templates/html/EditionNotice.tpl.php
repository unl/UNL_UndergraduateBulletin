<?php
$latest  = UNL_UndergraduateBulletin_Editions::getLatest();
$current = UNL_UndergraduateBulletin_Controller::getEdition();
?>
<div id="versioning">
    <div class="content">
        <h5>This content is the <span><?php echo $current->getRange(); ?></span> Undergraduate Bulletin</h5>
        <p>Other versions:</p>
        <ul>
            <li><a href="<?php echo $latest->getURL(); ?>"><?php echo $latest->getRange(); ?> <em>(includes latest course descriptions)</em></a></li>
            <?php foreach (UNL_UndergraduateBulletin_Editions::getPublished() as $edition): ?>
            <li><a href="<?php echo $edition->getURL(); ?>"><?php echo $edition->getRange(); ?> Archive Edition</a></li>
            <?php endforeach; ?>
            <li><a href="<?php echo $current->getURL(); ?>bulletinrules">More info, and other archived bulletins</a></li>
        </ul>
    </div>
    <div class="action opened">
        <a href="#">Hide</a>
    </div>
</div>