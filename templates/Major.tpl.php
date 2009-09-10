<?php
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.htmlentities($this->title));
UNL_UndergraduateBulletin_Controller::setReplacementData('head', '<script type="text/javascript" src="templates/scripts/jQuery.toc.js"></script>
                                                                  <script type="text/javascript" src="templates/scripts/majors.js"></script>');
?>
<h1><?php echo $this->title; ?></h1>
<h2 class="subhead">College of <?php echo $this->college; ?></h2>
<ul class="wdn_tabs">
    <li><a href="?view=major&amp;name=<?php echo $this->title; ?>"><span>Description</span></a></li>
    <li><a href="?view=courses&amp;name=<?php echo $this->title; ?>"><span>Courses</span></a></li>
</ul>
<?php
    $regions = array(
    'description'=>'Description',
    'admission'=>'Admission',
    'major_requirements'=>'Major Requirements',
    'additional_major_requirements'=>'Additional Major Requirements',
    'college_degree_requirements'=>'College Degree Requirements',
    'ace_requirements'=>'Ace Requirements',
    'other'=>'Other',
    );
?>
<div class="three_col left">
    <div id="major_nav">
        <a href="#" id="majorContent">Contents</a>
        <ol id="toc"></ol>
    </div>
    <div id="long_content">
    <?php
    foreach ($regions as $id=>$title) { 
        if (!empty($this->$id)) {
            echo '<div id="'.$id.'"><a href="#header" class="top">Top</a>'.$this->$id.'</div>';
        }    
    }
    ?>
    </div>
</div>
<div class="col right">
    <table class="zentable cool">
        <tr>
            <td>Hours Required</td>
            <td><?php echo $this->hours_required; ?></td>
        </tr>
        <tr>
            <td>Minor Available</td>
            <td><?php echo ($this->minor_available)?'Yes':'No'; ?></td>
        </tr>
        <tr>
            <td>Chief Advisor</td>
            <td><?php echo $this->chief_advisor; ?></td>
        </tr>
    </table>
    <h3>Degrees Offered</h3>
    <ul>
    <li><?php echo implode(', ',$this->degrees_offered); ?></li>
    </ul>
    <h3>Featured Faculty</h3>
    <h3 id="relatedMajors">Related Majors</h3>
</div>