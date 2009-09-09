<h1><?php echo $this->title; ?></h1>
<h2><?php echo $this->college; ?></h2>
<ul class="wdn_tabs">
    <li><a href="?view=major&amp;name=<?php echo $this->title; ?>"><span>Description</span></a></li>
    <li><a href="?view=courses&amp;name=<?php echo $this->title; ?>"><span>Courses</span></a></li>
</ul>
<div class="three_col left">
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
            <td><?php echo $this->degrees_offered; ?></td>
        </tr>
        <tr>
            <td>Hours Required</td>
            <td><?php echo $this->hours_required; ?></td>
        </tr>
        <tr>
            <td>Minor Available</td>
            <td><?php echo $this->minor_available; ?></td>
        </tr>
        <tr>
            <td>Chief Advisor</td>
            <td><?php echo $this->chief_advisor; ?></td>
        </tr>
    </table>
</div>