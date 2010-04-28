<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.$context->title);
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h2>'.$context->title.'</h2>');
UNL_UndergraduateBulletin_Controller::setReplacementData('head', '<script type="text/javascript" src="'.$url.'templates/html/scripts/jQuery.toc.js"></script>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>'.$context->title.'</li>
</ul>
');
?>
<h2 class="subhead"><?php echo $context->college->name; ?></h2>
<ul class="wdn_tabs disableSwitching">
    <li class="<?php echo ($parent->context->options['view']=='major')?'selected':''; ?>"><a href="<?php echo $context->getRawObject()->getURL(); ?>"><span>Description</span></a></li>
    <?php if (count($context->getRaw('subjectareas'))): ?>
    <li class="<?php echo ($parent->context->options['view']=='courses')?'selected':''; ?>"><a href="<?php echo $context->getRawObject()->getURL(); ?>/courses"><span>Courses</span></a></li>
    <?php endif; ?>
</ul>
<?php
if ($context->options['view'] == 'major') {
    echo $savvy->render($context->description);
} else {
    echo $savvy->render($context->subjectareas);
}

?>