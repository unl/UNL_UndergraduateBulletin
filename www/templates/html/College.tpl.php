<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.$context->name);
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h2>'.$context->name.'</h2>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>'.$context->name.'</li>
</ul>
');
?>
<div class="three_col left">
    <div id="toc_nav">
        <a href="#toc_nav" id="tocContent">Contents</a>
        <ol id="toc"><li>Intro</li></ol>
        <div id="toc_major_name"><?php echo $context->name; ?></div>
    </div>
    <div id="toc_bar"></div>
    <div id="long_content">
    <?php
    echo UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($context->getRaw('description')); ?>
    </div>
</div>
<div class="col right">
    <?php
    if (count($context->majors)):
    ?>
    <h3 id="relatedMajors">Majors</h3>
    <?php echo $savvy->render($context->majors, 'MajorList/UnorderedList.tpl.php');
    endif;
    ?>
</div>