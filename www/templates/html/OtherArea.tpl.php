<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $context->name.' | Undergraduate Bulletin | University of Nebraska-Lincoln');
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>'.$context->name.'</h1>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>'.$context->name.'</li>
</ul>
');
?>
<div class="wdn-inner-wrapper">
    <div class="wdn-grid-set">
        <div class="bp1-wdn-col-three-fourths">
            <div id="toc_nav">
                <a id="tocToggle" href="#">+</a>
                <ol id="toc"><li>Intro</li></ol>
                <div id="toc_major_name"><?php echo $context->name; ?></div>
            </div>
            <div id="long_content">
            <?php
            echo UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($context->getRaw('description')); ?>
            </div>
        </div>
        <div class="bp1-wdn-col-one-fourth">
            <?php
            //$otherareas = new UNL_UndergraduateBulletin_OtherAreas();
            //echo $savvy->render($otherareas);
            ?>
        </div>
    </div>
</div>