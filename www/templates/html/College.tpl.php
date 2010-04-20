<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.htmlentities($context->name));
?>
<h1><?php echo $context->name; ?></h1>
<div class="three_col left">
    <div id="toc_nav">
        <a href="#" id="tocContent">Contents</a>
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
    $majors = array();
    foreach($context->majors as $major) {
        $majors[] = '<li><a href="'.$url.'major/'.urlencode($major->getRaw('title')).'">'.$major->title.'</a></li>';
    }
    if (count($majors)):
    ?>
    <h3 id="relatedMajors">Majors</h3>
    <ul>
        <?php echo implode(PHP_EOL, $majors); ?>
    </ul>
    <?php
    endif;
    ?>
</div>