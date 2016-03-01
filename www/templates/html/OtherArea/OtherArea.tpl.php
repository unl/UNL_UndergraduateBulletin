<?php
use UNL\UndergraduateBulletin\OtherArea\OtherAreas;
use UNL\UndergraduateBulletin\EPUB\Utilities;
?>

<div class="wdn-band">
<div class="wdn-inner-wrapper">
    <div class="wdn-grid-set">
        <div class="bp2-wdn-col-two-thirds">
            <div id="toc_nav">
                <a id="tocToggle" href="#">+</a>
                <ol id="toc"><li>Intro</li></ol>
            </div>
            <div id="long_content">
            <?php
            echo Utilities::convertHeadings($context->getRaw('description')); ?>
            </div>
        </div>
        <div class="bp2-wdn-col-one-third">
            <?php
            $otherareas = new OtherAreas();
            echo $savvy->render($otherareas);
            ?>
        </div>
    </div>
</div>
</div>
