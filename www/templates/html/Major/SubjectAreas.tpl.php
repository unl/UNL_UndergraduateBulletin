<?php foreach ($context->getMajor()->subjectareas as $subject): ?>
	<h2 id="<?php echo $subject->getSubject() ?>"><?php echo $subject->getSubject() ?> Courses</h2>
    <?php echo $savvy->render($subject); ?>
<?php endforeach; ?>
