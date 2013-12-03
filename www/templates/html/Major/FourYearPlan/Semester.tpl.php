<div class="wdn-col">
	<table class="wdn-courses">
		<caption>Semester <?php echo $semester; ?> <span class="wdn-semester-season">&middot; <?php echo ($semester%2)?'Fall':'Spring'; ?></span></caption>
		<thead>
			<tr>
				<th>Course</th>
				<th>Credit Hours</th>
			</tr>
		</thead>
		<tbody>
		    <?php
		    $total = 0;
		    foreach ($context as $course): ?>
			<tr class="wdn-course-row">
				<td class="wdn-course">
				    <span class="wdn-course-id wdn-block"> <?php echo $course['course']; ?> </span>
				    <span class="wdn-course-title wdn-block"> <?php echo $course['title']; ?> </span>
				</td>
				<td class="wdn-course-credits"><span class="wdn-course-credit-hours wdn-center wdn-block"> <?php echo $course['hours']; ?> </span> <span
					class="wdn-block wdn-center wdn-course-credit-hours-label"
				> cr </span>
				</td>
			</tr>
			<?php
			if (isset($course['hours'])) {
                $total += $course['hours'];
            }
			?>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td class="wdn-total-credits-label">Total Credits</td>
				<td class="wdn-total-credits-number wdn-center"><?php echo $total; ?></td>
			</tr>
		</tfoot>
	</table>
</div>