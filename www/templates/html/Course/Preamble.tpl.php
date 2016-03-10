<?php
/* @var $context UNL\UndergraduateBulletin\Course\Listing */

$crosslistings = $context->getCrosslistings();
?>
<div class="wdn-grid-set">
    <div class="wdn-col-one-fourth bp1-wdn-col-one-fifth bp2-wdn-col-one-sixth">
        <div class="courseID">
            <span class="subjectCode"><?php echo $context->getSubject() ?></span>
            <span class="number <?php echo $context->getCourseNumberCssClass() ?>"><?php echo $context->getListingNumbers() ?></span>
        </div>
    </div>
    <div class="wdn-col-three-fourths bp1-wdn-col-four-fifths bp2-wdn-col-five-sixths">
        <a class="coursetitle" href="<?php echo $context->getURL($controller->getRawObject()) ?>"><?php echo $context->getCourseTitle() ?></a>
        <?php if (!empty($crosslistings)): ?>
            <span class="crosslistings">Crosslisted as <?php echo $crosslistings ?></span>
        <?php endif; ?>
    </div>
</div>
