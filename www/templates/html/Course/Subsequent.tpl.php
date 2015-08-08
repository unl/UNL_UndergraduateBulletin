<?php
/* @var $context UNL_UndergraduateBulletin_Listing */
$baseURL = $controller->getURL();
$subsequent_courses = $context->getSubsequentCourses($course_search_driver->getRawObject());
$courseCount = count($subsequent_courses);
?>
<?php if ($courseCount): ?>
<div class="subsequent">This course is a prerequisite for: 
<?php foreach ($subsequent_courses as $i => $course): ?>
	<?php $listing = $course->getHomeListing() ?>
	<a class="course" href="<?php echo $baseURL . 'courses/' . $listing->subjectArea . '/' . $listing->courseNumber ?>"><?php echo $listing->subjectArea ?> <?php echo $listing->courseNumber ?></a><?php if (($i + 1) < $courseCount): ?>,  <?php endif;?>
<?php endforeach; ?>
</div>
<?php endif ?>
