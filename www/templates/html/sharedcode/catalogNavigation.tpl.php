<?php
use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
?>

<ul>
    <li><a href="<?php echo Controller::getURL() ?>">Undergraduate</a>
        <ul>
            <li><a href="<?php echo Controller::getURL() ?>major/">Majors</a></li>
        </ul>
    </li>
    <li><a href="http://www.unl.edu/gradstudies/bulletin">Graduate</a>
        <ul>
            <li><a href="http://www.unl.edu/gradstudies/prospective/programs">Programs and Areas of Study</a></li>
        </ul>
    </li>
    <li><a href="<?php echo CatalogController::getURL() ?>courses/">Course Catalog</a></li>
</ul>
