<?php
use UNL\UndergraduateBulletin\EPUB\Utilities;

$relatedMajors = $savvy->render($context->majors, 'Major/UnorderedList.tpl.php');
// Check if there are any actual majors in the list
if (false === strpos($relatedMajors, '</li>')) {
    $relatedMajors = '';
}
?>
<div class="wdn-band">
    <div class="wdn-inner-wrapper">
        <div class="wdn-grid-set">
            <div class="bp2-wdn-col-two-thirds">
                <div id="toc_nav">
                    <a id="tocToggle" href="#">+</a>
                    <ol id="toc"><li>Intro</li></ol>
                    <div id="toc_major_name"><?php echo $context->name; ?></div>
                </div>
                <div id="long_content">
                <?php echo Utilities::convertHeadings($context->getRaw('description')); ?>
                </div>
            </div>
            <div class="bp2-wdn-col-one-third">
                <?php if ($relatedMajors): ?>
                    <h3 id="relatedMajors">Majors</h3>
                    <?php echo $relatedMajors ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
