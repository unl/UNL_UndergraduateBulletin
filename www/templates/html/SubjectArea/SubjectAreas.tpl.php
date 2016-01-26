<div class="wdn-band">
<div class="wdn-inner-wrapper">

<h2 class="clear-top">All subject areas</h2>
<ul id="subjectListing">
<?php
$filter = Savvy_ObjectProxy::factory(new UNL\UndergraduateBulletin\SubjectArea\Filter($context->getRawObject()), $savvy);
foreach ($filter as $subject_code => $area) : ?>
    <li><a href="<?php echo $controller->getRawObject()::getURL().'courses/'.$subject_code.'/'; ?>"><span class="subjectCode"><?php echo $subject_code; ?></span> <span class="title"><?php echo $area->title; ?></span></a></li>
<?php endforeach; ?>
</ul>
</div>
</div>
