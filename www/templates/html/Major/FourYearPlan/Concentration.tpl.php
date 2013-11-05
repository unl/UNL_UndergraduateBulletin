<?php
foreach ($context as $count => $semester) {
    $savvy->addGlobal('semester', $count);
    if ($count % 2) { ?>
        <div class="wdn-col">
			<h3 class="wdn-center wdn-course-year-header">Year <?php echo ($count+1)/2; ?></h3>
			<div class="bp2-wdn-grid-set-halves">
			<?php echo $savvy->render($semester); ?>
			</div>
		</div>
        <?php
    } else {
        echo $savvy->render($semester);
    }
}
?>
<div class="wdn-col">
<h3>Concentration Notes</h3>
<?php echo $context->notes; ?>
</div>