<?php
if ($context->options['view'] == 'searchmajors') {
    $url = $controller->getRawObject()::getURL();
    $controller->getRawObject()::setReplacementData('doctitle', 'Majors Search | Undergraduate Bulletin | University of Nebraska-Lincoln');
    $controller->getRawObject()::setReplacementData('pagetitle', '<h1>Majors Search</h1>');
    $controller->getRawObject()::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li><a href="'.$url.'majors/">Majors/Areas of Study</a></li>
        <li>Search</li>
    </ul>
    ');
}
?>

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
