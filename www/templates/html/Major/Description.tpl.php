<?php
    $url = UNL_UndergraduateBulletin_Controller::getURL();
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
    <div id="toc_nav">
        <a href="#" id="tocContent">Contents</a>
        <ol id="toc"><li>Intro</li></ol>
    </div>
    <div id="long_content">
    <?php
    foreach ($regions as $id=>$title) { 
        if (!empty($context->$id)) {
            echo '<div id="'.$id.'"><a href="#header" class="top">Top</a>'.preg_replace('/([A-Z]{3,4})\s+([0-9]{2,3}[A-Z]?)/', '<a class="course" href="'.$url.'$1/$2">$0</a>',$context->$id).'</div>';
        }
    }
    ?>
    </div>
</div>
<div class="col right">
    <table class="major_quick_points zentable cool" summary="Quick points about the <?php echo $context->major->title; ?> major/program.">
        <caption>Quick points about the <?php echo $context->major->title; ?> major/program.</caption>
        <thead>
            <tr>
                <th colspan="2">Quick Points</th>
            </tr>
            <tr>
                <th scope="col">Attribute</th>
                <th scope="col">Value</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td class="attr">Hours Required:</td>
            <td class="value"><?php echo $context->hours_required; ?></td>
        </tr>
        <tr>
            <td class="attr">Minor Available:</td>
            <td class="value"><?php echo ($context->minor_available)?'Yes':'No'; ?></td>
        </tr>
        <tr>
            <td class="attr">Chief Advisor:</td>
            <td class="value"><?php echo $context->chief_advisor; ?></td>
        </tr>
        </tbody>
    </table>
    <?php if (!empty($context->degrees_offered)) { ?>
    <h3>Degrees Offered</h3>
    <ul>
        <?php foreach ($context->degrees_offered as $degree) { ?>
        <li><?php echo $degree; ?></li>
        <?php } ?>
    </ul>
    <?php } ?>
    <h3>Featured Faculty</h3>
    <h3 id="relatedMajors">Related Majors</h3>
</div>