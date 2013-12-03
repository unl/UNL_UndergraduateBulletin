<?php
foreach ($context as $count => $semester) {
    $savvy->addGlobal('semester', $count);
    ?>
    <div class="wdn-col">
		<h3 class="wdn-center wdn-course-year-header"><span class="wdn-course-year-header-year">Year</span> <span class="wdn-course-year-header-number"><?php echo ($count+1)/2; ?></span></h3>
		<div class="bp2-wdn-grid-set-halves wdn-grid-clear">
		<?php
        echo $savvy->render($semester);
        $context->next();
        $semester = $context->current();
        $savvy->addGlobal('semester', $count+1);
        echo $savvy->render($semester);
        ?>
		</div>
	</div>
    <?php
}
?>
