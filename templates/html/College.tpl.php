<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.htmlentities($this->name));
?>
<h1><?php echo $this->name; ?></h1>
<div class="three_col left">
    <div id="toc_nav">
        <a href="#" id="tocContent">Contents</a>
        <ol id="toc"><li>Intro</li></ol>
    </div>
    <div id="long_content">
    <?php
    echo $this->description; ?>
    </div>
</div>