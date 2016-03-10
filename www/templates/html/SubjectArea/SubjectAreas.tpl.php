<div class="wdn-band">
	<div class="wdn-inner-wrapper">
		<ul id="subjectListing">
			<?php foreach ($context->getFiltered() as $subject_code => $area) : ?>
		    	<li><a href="<?php echo $area->getUrl($controller->getRawObject()) ?>"><span class="subjectCode"><?php echo $area->getSubject() ?></span> <span class="title"><?php echo $area->getTitle() ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
