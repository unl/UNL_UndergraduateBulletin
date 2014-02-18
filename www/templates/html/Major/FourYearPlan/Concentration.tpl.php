<?php
foreach ($context as $count => $semester) {
    if ($count > 8) {
        continue;
    }
    $year = ($count+1)/2;
    $savvy->addGlobal('semester', $count);
    ?>
    <div class="wdn-col wdn-course-year">
		<h3 class="wdn-center wdn-course-year-header"><span class="wdn-course-year-header-year">Year</span> <span class="wdn-course-year-header-number"><?php echo $year; ?></span></h3>
		<div class="bp2-wdn-grid-set-halves wdn-grid-clear">
		<?php
        echo $savvy->render($semester);
        $context->next();
        $semester = $context->current();
        $savvy->addGlobal('semester', $count+1);
        echo $savvy->render($semester);

        if (isset($context[10+$year])) {
            // Summer courses!
            echo $savvy->render($context[10+$year]);
        }
        ?>
		</div>
	</div>
    <?php
}
?>
