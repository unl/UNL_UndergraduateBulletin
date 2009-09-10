<?php
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | '.htmlentities($this->title));
UNL_UndergraduateBulletin_Controller::setReplacementData('head', '<script type="text/javascript">
WDN.jQuery(document).ready(function() {
    WDN.jQuery("#major_nav").hover(function() {
        WDN.jQuery("#major_nav ul").show();
    },
    function() {
        WDN.jQuery("#major_nav ul").hide();
    });
    WDN.jQuery("#major_nav ul").hide();
});</script>');
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
        <a href="#">Contents</a>
        <ul style="display:none;">
            <?php
            foreach ($regions as $id=>$title) { 
                if (!empty($this->$id)) {
                    echo '<li><a href="'.$id.'">'.$title.'</a></li>';
                }    
            }
            ?>
        </ul>
    </div>
    <?php
    foreach ($regions as $id=>$title) { 
        if (!empty($this->$id)) {
            echo '<div id="'.$id.'">'.$this->$id.'</div>';
        }    
    }
    ?>
</div>
<div class="col right">
    <table class="zentable cool">
        <tr>
            <td>Degrees Offered</td>
            <td><?php echo implode(', ',$this->degrees_offered); ?></td>
        </tr>
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
</div>