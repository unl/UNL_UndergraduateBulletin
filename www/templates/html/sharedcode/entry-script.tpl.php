<?php
$baseURL = UNL\UndergraduateBulletin\Controller::getBaseUrl();
$protocolAgnosticBaseURL = str_replace('http://', '//', $baseURL);
?>
<script>
require([
	'jquery',
	'<?php echo $protocolAgnosticBaseURL ?>scripts/bulletin.functions.min.js'
], function($, onReady) {
	$(function() {
		onReady('<?php echo UNL\UndergraduateBulletin\Controller::getURL() ?>');
	});
});
</script>
