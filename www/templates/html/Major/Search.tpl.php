<?php if ($context->options['format'] != 'partial'): ?>
    <?php echo $savvy->render(null, 'SearchForm.tpl.php'); ?>
<?php endif; ?>

<div class="wdn-band">
    <div class="wdn-inner-wrapper">
        <div class="wdn-grid-set">
            <div class="bp1-wdn-col-one-fourth">
                <?php echo $savvy->render(null, 'Major/Filters.tpl.php'); ?>
            </div>
            <div class="bp1-wdn-col-three-fourths wdn-pull-right" id="results">
                <?php if (!$context->count()): ?>
                    Sorry, no matching areas of study
                <?php else: ?>
                    <h2 class="resultCount"><?php echo $context->count() ?> result(s)</h2>
                    <?php echo $savvy->render($context, 'Major/UnorderedList.tpl.php'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
