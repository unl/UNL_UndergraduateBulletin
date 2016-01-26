<?php
$url = $controller->getRawObject()::getURL();
$controller->getRawObject()::setReplacementData('doctitle', $context->college->name.' Majors | University of Nebraska-Lincoln');
$controller->getRawObject()::setReplacementData('pagetitle', '<h1 class="college-name">'.$context->college->name.'</h1>');
$controller->getRawObject()::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li><a href="'.$context->getCollege()->getURL().'">'.$context->getCollege()->name.'</a></li>
    <li>Majors</li>
</ul>
');
?>
<div class="wdn-band">
	<div class="wdn-inner-wrapper">
		<?php if (count($context)): ?>
		    <?php echo $savvy->render($context, 'Major/UnorderedList.tpl.php'); ?>
		<?php endif; ?>
	</div>
</div>
