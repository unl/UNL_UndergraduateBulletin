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
        <a href="#toc_nav" id="tocContent">Contents</a>
        <ol id="toc"><li>Intro</li></ol>
        <div id="toc_major_name"><?php echo $context->major->title; ?></div>
    </div>
    <div id="toc_bar"></div>
    <div id="long_content">
        <?php
        foreach ($regions as $id => $title) {
            if (!empty($context->$id)) {
                echo '<div id="'.$id.'">'.$context->getRaw($id).'</div>';
            }
        }
        ?>
        <h2 id="college_requirements" class="sec_header">COLLEGE REQUIREMENTS</h2>
        <?php echo $savvy->render($context->colleges); ?>
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
                <td class="value">
                    <?php foreach ($context->colleges as $college) : ?>
                        <a href="<?php echo $college->getURL(); ?>"><?php echo $college->name; ?></a>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php foreach ($context->quickpoints as $attr => $value): ?>
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