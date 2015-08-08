<?php
/* @var $context UNL_Services_CourseApproval_Course */

$url = $controller->getURL();
$renderListing = $context->getRenderListing();
$renderListingProxy = new UNL_UndergraduateBulletin_Listing($renderListing->getRawObject());
?>
    
<div class="<?php echo $savvy->escape($renderListingProxy->getCssClass()) ?>">
	<?php echo $savvy->render($renderListingProxy, 'Course/Preamble.tpl.php') ?>
    <div class="wdn-grid-set">
        <div class="wdn-col-full bp1-wdn-col-four-fifths bp2-wdn-col-five-sixths wdn-pull-right">
        <?php if (!empty($context->prerequisite)): ?>
            <div class='prereqs'>Prereqs: <?php echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('prerequisite'), $url) ?></div>
        <?php endif; ?>
        
        <?php if (!empty($context->notes)): ?>
            <div class='notes'><?php echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('notes'), $url) ?></div>
        <?php endif; ?>
        
            <div class="wdn-grid-set">
                <div class="bp2-wdn-col-two-thirds info-1">
                <?php if (!empty($context->description)): ?>
                    <div class="description"><?php echo UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($context->getRaw('description'), $url) ?></div>
                <?php else: ?>
                    <div class="description">This course has no description.</div>
                <?php endif; ?>
                
                <?php echo $savvy->render($renderListingProxy, 'Course/Subsequent.tpl.php') ?>
                </div>
                <div class="bp2-wdn-col-one-third info-2">
                    <table class="zentable cool details">
                    <?php echo $savvy->render($context, 'Course/Credits.tpl.php'); ?>
                    <?php echo $savvy->render($context->activities) ?>
                        <tr class="deliveryMethods">
                            <td class="label">Course Delivery:</td>
                            <td class="value">
                            <?php $dmCount = count($context->getDeliveryMethods()) ?>
                            <?php foreach ($context->getDeliveryMethods() as $i => $method): ?>
                            	<?php echo $method ?><?php if (++$i < $dmCount): ?>, <?php endif; ?>
                        	<?php endforeach;?>
                        	</td>
                       </tr>
                       <?php if (!empty($context->aceOutcomes)): ?>
                       <?php 
                       $ace = array();
                       foreach($context->aceOutcomes as $outcome) {
                           $ace[] = '<abbr title="'.UNL_UndergraduateBulletin_ACE::$descriptions[$outcome].'">'.$outcome.'</abbr>';
                       }
                       ?>
                       <tr class="aceOutcomes">
                            <td class="label">ACE Outcomes:</td>
                            <td class="value"><?php echo implode(', ', $ace) ?></td>
                       </tr>
                   <?php endif; ?>
                   <?php echo $savvy->render($renderListingProxy, 'Course/Groups.tpl.php') ?>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
