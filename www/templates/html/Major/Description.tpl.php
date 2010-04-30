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
    $college_regions = array(
    'admissionRequirements'         => 'COLLEGE ADMISSION',
    'degreeRequirements'            => 'COLLEGE DEGREE REQUIREMENTS',
    'aceRequirements'               => 'ACE REQUIREMENTS',
    'bulletinRule'                  => 'BULLETIN RULE',
    'other'                         => 'OTHER INFORMATION',
    );
?>
<div class="three_col left">
    <div id="toc_nav">
        <a href="#toc_nav" id="tocContent">Contents</a>
        <ol id="toc"><li>Intro</li></ol>
        <div id="toc_major_name"><?php echo $context->major->title; ?></div>
    </div>
    <div id="toc_bar"></div>
    <div id="long_content">
        <?php
        foreach ($regions as $id=>$title) {
            if (!empty($context->$id)) {
                echo '<div id="'.$id.'">'.$context->getRaw($id).'</div>';
            }
        }
        ?>
        <h2 id="college_requirements" class="sec_header">COLLEGE REQUIREMENTS</h2>
        <?php
        foreach ($college_regions as $id=>$title) {
            if (isset($context->college->description->$id)) { 
                $college_section = $context->college->description->getRaw($id);
                ?>
                <div id="college_<?php echo $id; ?>">
                    <h3 class="sec_header"><?php echo $title; ?></h3>
                    <?php echo str_replace(array('<h3', '</h3>'),
                                           array('<h4', '</h4>'), $college_section); ?>
                </div>
                <?php
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
            <tr class="table_heading">
                <th scope="col">Attribute</th>
                <th scope="col">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="attr">College:</td>
                <td class="value"><a href="<?php echo $context->college->getURL(); ?>"><?php echo $context->college->name; ?></a></td>
            </tr>
            <?php foreach ($context->quickpoints as $attr=>$value): ?>
            <tr>
                <td class="attr"><?php echo $attr; ?>:</td>
                <td class="value"><?php echo $value; ?></td>
            </tr>
            <?php endforeach; ?>
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
    <!-- 
    <h3>Featured Faculty</h3>
    <h3 id="relatedMajors">Related Majors</h3>
     -->
</div>