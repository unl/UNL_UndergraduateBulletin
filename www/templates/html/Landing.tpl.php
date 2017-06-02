<?php
use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
?>

<div id="homepage" class="wdn-band">
    <div class="wdn-inner-wrapper">
    <div class="wdn_notice" style="text-align: left;">
		<div class="message">
			<p class="title">Attention</p>
			<p>This is the site for old bulletin data. Please head to <a href="http://catalog.unl.edu">UNL's Course Catalog</a> for updated course and program information.</p>
		</div>
	</div>
        <ul>
            <li><a class="wdn-button wdn-button-brand" href="<?php echo Controller::getURL() ?>">Undergraduate Bulletin</a></li>
            <li><a class="wdn-button wdn-button-brand" href="http://www.unl.edu/gradstudies/bulletin">Graduate Bulletin</a></li>
            <li><a class="wdn-button wdn-button-brand" href="<?php echo CatalogController::getURL() ?>courses/">Course Catalog</a></li>
        </ul>
    </div>
</div>

<script>
  WDN.initializePlugin('notice');
</script>