<?php
$regions = [
    'description' => 'Description',
    'admission' => 'Admission',
    'major_requirements' => 'Major Requirements',
    'additional_major_requirements' => 'Additional Major Requirements',
    'college_degree_requirements' => 'College Degree Requirements',
    'ace_requirements' => 'Ace Requirements',
    'other' => 'Other',
];
?>
<div class="wdn-band">
<div class="wdn-inner-wrapper">
<div class="wdn-grid-set">
    <div class="bp3-wdn-col-one-third wdn-pull-right">
        <table class="major_quick_points zentable cool">
            <caption>Quick points</caption>
            <thead>
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
        <?php if (!empty($context->degrees_offered)): ?>
        <h3>Degrees Offered</h3>
        <ul>
            <?php foreach ($context->degrees_offered as $degree): ?>
            <li><?php echo $degree; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <div class="bp3-wdn-col-two-thirds">
        <div id="toc_nav">
            <a id="tocToggle" href="#">+</a>
            <ol id="toc"><li>Intro</li></ol>
            <div id="toc_major_name"><?php echo $context->major->title; ?></div>
        </div>

        <div id="long_content">
            <?php foreach ($regions as $id => $title): ?>
                <?php if (!empty($context->$id)): ?>
                    <div><?php echo $context->getRaw($id) ?></div>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php $college_requirements = $savvy->render($context->colleges); ?>
            <?php if (!empty($college_requirements)): ?>
                <h2 id="college_requirements">COLLEGE REQUIREMENTS</h2>
                <?php echo $college_requirements; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</div>
