<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', $context->name.' | Undergraduate Bulletin | University of Nebraska-Lincoln');
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>'.$context->name.'</h1>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>'.$context->name.'</li>
</ul>
');
?>
<div class="grid9 first">
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
<div class="grid3">
    <?php
    $related_majors = $savvy->render($context->majors, 'MajorList/UnorderedList.tpl.php');
    // Check if there are any actual majors in the list
    if (false !== strpos($related_majors, '</li>')):
    ?>
    <h3 id="relatedMajors">Majors</h3>
    <?php 
    echo $related_majors;
    endif;
    ?>
</div>