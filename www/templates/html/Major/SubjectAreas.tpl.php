<div class="wdn_notice" data-overlay="maincontent">
    <div class="close">
        <a href="#">Close this notice</a>
    </div>
    <div class="message">
        <p class="title">Attention</p>
        <p>This is the site for old bulletin data. Please head to <a href="http://catalog.unl.edu">UNL's Course Catalog</a> for updated course and program information.</p>
    </div>
</div>

<?php foreach ($context->getMajor()->subjectareas as $subject): ?>
	<h2 id="<?php echo $subject->getSubject() ?>"><?php echo $subject->getSubject() ?> Courses</h2>
    <?php echo $savvy->render($subject); ?>
<?php endforeach; ?>

<script>
  WDN.initializePlugin('notice');
</script>