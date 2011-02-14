<div id="versioning">
    <div class="content">
        <h5>This content is the <span><?php echo UNL_UndergraduateBulletin_Controller::getEdition()->getRange(); ?></span> Undergraduate Bulletin</h5>
        <p>Other versions:</p>
        <ul>
            <?php foreach (UNL_UndergraduateBulletin_Editions::getPublished() as $edition): ?>
            <li><a href="<?php echo $edition->getURL(); ?>"><?php echo $edition->getRange(); ?> Undergraduate Bulletin</a></li>
            <?php endforeach; ?>
            <li><a href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>bulletinrules">More</a></li>
        </ul>
    </div>
    <div class="action opened">
        <a href="#">Hide</a>
    </div>
</div>