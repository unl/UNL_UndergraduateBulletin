<?php

if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}
$rawController = $controller->getRawObject();
$url = $rawController::getURL();
if ($context->options['format'] != 'partial') {
    echo $savvy->render(null, 'SearchForm.tpl.php');
}
?>
<?php if (!count($context->results)): ?>
    <p>Sorry, no matching courses</p>
<?php else: ?>
<div class="wdn-band course-list">
	<div class="wdn-inner-wrapper">
	<?php if ($context->options['format'] != 'partial'): ?>
        <div class="wdn-grid-set">
   		<div class="bp2-wdn-col-one-fourth">
    		<?php echo $savvy->render($context->getFilters(), 'Course/Filters.tpl.php'); ?>
    	</div>
       	<div class="bp2-wdn-col-three-fourths wdn-pull-right" id="results">
    <?php endif; ?>

    <h2 class="resultCount"><?php echo count($context->results) ?> results</h2>
    <?php foreach ($context->results as $course): ?>
        <?php echo $savvy->render($course); ?>
    <?php endforeach; ?>
    <?php if ($context->options['format'] != 'partial'): ?>
    	<?php
        // add the pagination links if necessary
        if (count($context) > $context->options['limit']) {
            $pager = [
                'total' => count($context),
                'limit' => $context->options['limit'],
                'offset' => $context->options['offset'],
                'url' => $url.'courses/search?q='.urlencode($context->options['q']),
            ];
            echo $savvy->render((object) $pager, 'PaginationLinks.tpl.php');
        }
        ?>
        </div>
    <?php endif; ?>
	</div>
    </div>
</div>
<?php endif; ?>
