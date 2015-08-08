<?php

if (gettype($context->results) == 'string') {
    echo $context->getRaw('results');
    return;
}

$url = UNL_UndergraduateBulletin_Controller::getURL();
if (isset($context->options['view']) && $context->options['view'] == 'searchcourses') {
    UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'Course Search | Undergraduate Bulletin | University of Nebraska-Lincoln');
    UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>Course Search</h1>');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
        <li><a href="'.$url.'courses/">Courses</a></li>
        <li>Search</li>
    </ul>
    ');
}
if ($context->options['format'] != 'partial') {
    echo $savvy->render('', 'SearchForm.tpl.php');
}
?>
<?php if (!count($context->results)): ?>
<p>Sorry, no matching courses</p>
<?php else: ?>
<div class="wdn-grid-set">
	<div class="wdn-inner-wrapper">';
	<?php if ($context->options['format'] != 'partial'): ?>
   		<div class="bp2-wdn-col-one-fourth">
    		<?php echo $savvy->render($context->getFilters(), 'CourseFilters.tpl.php'); ?>
    	</div>
       	<div class="bp2-wdn-col-three-fourths">
    <?php endif; ?>
    
		<h2 class="resultCount"><?php echo count($context->results) ?> results</h2>
    <?php foreach ($context->results as $course): ?>
        <?php echo $savvy->render($course); ?>
    <?php endforeach; ?>
    <?php if ($context->options['format'] != 'partial'): ?>
    	<?php 
        // add the pagination links if necessary
        if (count($context) > $context->options['limit']) {
            $pager = new stdClass();
            $pager->total  = count($context);
            $pager->limit  = $context->options['limit'];
            $pager->offset = $context->options['offset'];
            $pager->url    = $url.'courses/search?q='.urlencode($context->options['q']);
            echo $savvy->render($pager, 'PaginationLinks.tpl.php');
        }
        ?>
        </div>
    <?php endif; ?>
	</div>
</div>
<?php endif; ?>
