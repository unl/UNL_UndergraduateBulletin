<section class="wdn-band four-year-plans">
	<div class="wdn-inner-wrapper">
    	<?php foreach ($context as $key => $concentration): ?>
            <h2 class="wdn-brand">Majors in <?php echo $key ?> will be able to:</h2>
            <?php echo $savvy->render($concentration) ?>
            <?php if (!empty($concentration->notes)): ?>
                <h3>Notes</h3>
                <p><?php echo $concentration->notes ?></p>z
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>
