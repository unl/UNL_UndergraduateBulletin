<?php
    $regions = array(
    'description'                   => 'Description',
    'admission'                     => 'Admission',
    'major_requirements'            => 'Major Requirements',
    'additional_major_requirements' => 'Additional Major Requirements',
    'college_degree_requirements'   => 'College Degree Requirements',
    'ace_requirements'              => 'Ace Requirements',
    'other'                         => 'Other',
    );
?>
<div class="three_col left">
    <div id="major_nav">
        <a href="#" id="majorContent">Contents</a>
        <ol id="toc"><li>Intro</li></ol>
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
    <?php if (!empty($this->degrees_offered)) { ?>
    <h3>Degrees Offered</h3>
    <ul>
        <?php foreach ($this->degrees_offered as $degree) { ?>
        <li><?php echo $degree; ?></li>
        <?php } ?>
    </ul>
    <?php } ?>
    <h3>Featured Faculty</h3>
    <h3 id="relatedMajors">Related Majors</h3>
</div>