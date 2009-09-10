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
<div class="three_col left">
    <div id="major_nav">
        <a href="#">Contents</a>
        <ul>
            <li><a href="#description">Description</a></li>
            <li><a href="#admission">Admission</a></li>
            <li><a href="#major_req">Major Requirements</a></li>
            <li><a href="#additional_req">Additional Major Requirements</a></li>
            <li><a href="#college_req">College Degree Requirements</a></li>
            <li><a href="#ace_req">Ace Requirements</a></li>
            <li><a href="#other">Other</a></li>
        </ul>
    </div>
    <?php echo $this->description; ?>
    <?php echo $this->admission; ?>
    <?php echo $this->major_requirements; ?>
    <?php echo $this->additional_major_requirements; ?>
    <?php echo $this->college_degree_requirements; ?>
    <?php echo $this->requirements_for_minor; ?>
    <?php echo $this->ace_requirements; ?>
    <?php echo $this->other; ?>
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