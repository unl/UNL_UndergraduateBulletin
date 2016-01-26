<?php
$rawController = $controller->getRawObject();
$url = $rawController::getURL();
$rawController::setReplacementData('doctitle', 'College List | Undergraduate Bulletin | University of Nebraska-Lincoln');
$rawController::setReplacementData('pagetitle', '<h1>College List</h1>');
$rawController::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Colleges</li>
</ul>
');
?>
<div class="wdn-band">
	<div class="wdn-inner-wrapper">
		<ul id="collegeListing">
			<?php foreach ($context as $college): ?>
			    <li><a href="<?php echo $url . 'college/' . urlencode($college->getRaw('name')) ?>"><?php echo $college->name ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>