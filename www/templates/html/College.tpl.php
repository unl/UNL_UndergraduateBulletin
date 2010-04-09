<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.htmlentities($context->name));
?>
<h1><?php echo $context->name; ?></h1>
<div class="three_col left">
    <div id="toc_nav">
        <a href="#" id="tocContent">Contents</a>
        <ol id="toc"><li>Intro</li></ol>
    </div>
    <div id="toc_bar">Major Name</div>
    <div id="long_content">
    <?php
    echo UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($context->getRaw('description')); ?>
    </div>
</div>
<div class="col right">
    <h3 id="relatedMajors">Majors</h3>
    <ul>
    <?php
    foreach($context->majors as $major) {
        echo '<li><a href="'.$url.'major/'.urlencode($major->getRaw('title')).'">'.$major->title.'</a></li>';
    }
    ?>
    </ul>
</div>