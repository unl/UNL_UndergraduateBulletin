<h2>All subject areas</h2>
<ul id="subjectListing">
<?php
$filter = Savvy_ObjectProxy::factory(new UNL_UndergraduateBulletin_SubjectAreas_Filter($context->getRawObject()), $savvy);
foreach ($filter as $subject_code => $area) : ?>
    <li><a href="<?php echo UNL_UndergraduateBulletin_Controller::getURL().'courses/'.$subject_code.'/'; ?>"><span class="subjectCode"><?php echo $subject_code; ?></span> <span class="title"><?php echo $area->title; ?></span></a></li>
<?php endforeach; ?>
</ul>
