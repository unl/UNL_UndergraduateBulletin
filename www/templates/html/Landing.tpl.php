<?php
use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
?>

<div id="homepage" class="wdn-band">
    <div class="wdn-inner-wrapper">
        <ul>
            <li><a class="wdn-button wdn-button-brand" href="<?php echo Controller::getURL() ?>">Undergraduate Bulletin</a></li>
            <li><a class="wdn-button wdn-button-brand" href="http://www.unl.edu/gradstudies/bulletin">Graduate Bulletin</a></li>
            <li><a class="wdn-button wdn-button-brand" href="<?php echo CatalogController::getURL() ?>courses/">Course Catalog</a></li>
        </ul>
    </div>
</div>
