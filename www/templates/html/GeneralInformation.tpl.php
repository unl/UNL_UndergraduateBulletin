<?php
$rawController = $controller->getRawObject();
$url = $rawController::getURL();
$rawController::setReplacementData('doctitle', 'Academic Policies &amp; General Information | Undergraduate Bulletin | University of Nebraska-Lincoln');
$rawController::setReplacementData('pagetitle', '<h1>Academic Policies &amp; General Information</h1>');
$rawController::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Academic Policies &amp; General Information</li>
</ul>');
?>

<div class="wdn-band">
    <div class="wdn-inner-wrapper wdn-inner-padding-none">
        <div class="wdn-grid-set">
            <div class="bp1-wdn-col-three-fourths centered">
        		<div id="toc_nav">
        		    <a id="tocToggle" href="#">+</a>
        		    <ol id="toc"><li>Intro</li></ol>
        		</div>
        	</div>
        </div>
    </div>
</div>

<div id="long_content" class="wdn-band">
    <div class="wdn-inner-wrapper">
        <?php echo $context->getRawObject()->getBody(); ?>
    </div>
</div>
