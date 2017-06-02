<div class="wdn-band course-list">
    <div class="wdn-inner-wrapper">
        <div class="wdn-grid-set">
            <div class="bp2-wdn-col-one-fourth">
                <?php echo $savvy->render($context->getFilters(), 'Course/Filters.tpl.php'); ?>
            </div>
            <div class="bp2-wdn-col-three-fourths wdn-pull-right" id="results<?php echo $context->getSubject() ?>">
            <?php foreach ($context->getCourses() as $course): ?>
                <?php echo $savvy->render($course); ?>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="wdn_notice" data-overlay="maincontent">
    <div class="close">
        <a href="#">Close this notice</a>
    </div>
    <div class="message">
        <p class="title">Attention</p>
        <p>This is the site for old bulletin data. Please head to <a href="http://catalog.unl.edu">UNL's Course Catalog</a> for updated course and program information.</p>
    </div>
</div>
<script>
  WDN.initializePlugin('notice');
</script>