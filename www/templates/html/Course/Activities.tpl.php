<?php
/* @var $context UNL\Services\CourseApproval\Course\Activities */

$activityCount = count($context);
$i = 0;
?>
<?php if ($activityCount): ?>
<tr class="format">
    <td class="label">Course Format:</td>
    <td class="value">
	<?php foreach ($context as $type => $activity): ?>
		<?php echo $context->getRawObject()::getFullDescription($type); ?>
		<?php if (isset($activity->hours)): ?> <?php  echo $activity->hours ?><?php endif; ?><?php if (++$i < $activityCount): ?>, <?php endif; ?>
	<?php endforeach; ?>
	</td>
</tr>
<?php endif; ?>
