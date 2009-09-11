<?php
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.htmlentities($this->title));
UNL_UndergraduateBulletin_Controller::setReplacementData('head', '<script type="text/javascript" src="templates/scripts/jQuery.toc.js"></script>
                                                                  <script type="text/javascript" src="templates/scripts/majors.js"></script>');
?>
<h1><?php echo $this->title; ?></h1>
<h2 class="subhead">College of <?php echo $this->college; ?></h2>
<ul class="wdn_tabs">
    <li><a href="./?view=major&amp;name=<?php echo urlencode($this->title); ?>"><span>Description</span></a></li>
    <li <?php echo ($_GET['view']=='courses')?'class="selected"':''; ?>><a href="./?view=courses&amp;name=<?php echo urlencode($this->title); ?>"><span>Courses</span></a></li>
</ul>
