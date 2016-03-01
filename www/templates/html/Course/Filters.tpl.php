<?php
$idPrefix = '';
if (isset($context->subject)) {
    $idPrefix = $context->subject;
}
?>

<div class="filters-wrapper">
    <nav class="skipnav">
        <a href="#results<?php echo $idPrefix ?>">Skip filters</a>
    </nav>

    <h2 class="wdn-brand">Filter these Courses</h2>
    <div class="filters" aria-controls="results<?php echo $idPrefix; ?>">
        <?php if (isset($context->groups) && count($context->groups)): ?>
        <div class="groups">
            <button aria-controls="<?php echo $idPrefix; ?>_filters_group">Groups <span class="toggle">(Expand)</span></button>
            <div class="filter-options" id="<?php echo $idPrefix; ?>_filters_group" role="region" tabindex="-1" aria-expanded="false">
                <ol>
                    <li>
                        <input type="checkbox" checked="checked" class="filterAll" id="<?php echo $idPrefix; ?>_filterAllGroups" name="all" value="all" />
                        <label for="<?php echo $idPrefix; ?>_filterAllGroups">All groups</label></li>
                    <?php foreach ($context->groups as $group) : ?>
                    <li>
                        <input type="checkbox" id="<?php echo $idPrefix; ?>_filter_grp_<?php echo md5($group); ?>" value="grp_<?php echo md5($group); ?>" />
                        <label for="<?php echo $idPrefix; ?>_filter_grp_<?php echo md5($group); ?>"><?php echo $group; ?></label>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <?php endif; ?>
        <div class="formats">
            <button aria-controls="<?php echo $idPrefix; ?>_filters_formats">Course Format <span class="toggle">(Expand)</span></button>
            <div class="filter-options" id="<?php echo $idPrefix; ?>_filters_formats" role="region" tabindex="-1" aria-expanded="false">
                <ol>
                   <li><input type="checkbox" checked="checked" class="filterAll" id="<?php echo $idPrefix; ?>_filterAllFormats" name="all" value="all" />
                   <label for="<?php echo $idPrefix; ?>_filterAllFormats">All formats</label></li>
                    <?php foreach (array(
                        'lec'=>'Lecture',
                        'lab'=>'Lab',
                        'quz'=>'Quiz',
                        'rct'=>'Recitation',
                        'stu'=>'Studio',
                        'fld'=>'Field',
                        'ind'=>'Independent Study',
                        'psi'=>'Personalized System of Instruction') as $key => $type) : ?>
                    <li>
                            <input type="checkbox" id="<?php echo $idPrefix; ?>_filter_format_<?php echo $key; ?>" value="<?php echo $key; ?>" />
                        <label for="<?php echo $idPrefix; ?>_filter_format_<?php echo $key; ?>"><?php echo $type; ?></label>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <div class="ace_outcomes">
            <button aria-controls="<?php echo $idPrefix; ?>_filters_ace_outcomes">ACE Outcomes <span class="toggle">(Expand)</span></button>
            <div class="filter-options" id="<?php echo $idPrefix; ?>_filters_ace_outcomes" role="region" tabindex="-1" aria-expanded="false">
                <ol>
                    <li>
                        <input type="checkbox" id="<?php echo $idPrefix; ?>_filterAllACE" class="filterAll" checked="checked" name="allace" value="all" />
                        <label for="<?php echo $idPrefix; ?>_filterAllACE">All ACE</label></li>
                    <?php for ($i=1;$i<=10;$i++) : ?>
                    <li>
                        <input type="checkbox" id="<?php echo $idPrefix; ?>_filter_ace_<?php echo $i; ?>" value="ace_<?php echo $i; ?>" />
                        <label for="<?php echo $idPrefix; ?>_filter_ace_<?php echo $i; ?>"><?php echo $i.' '.UNL\UndergraduateBulletin\Course\Listing::getACEDescription($i); ?></label>
                    </li>
                    <?php endfor; ?>
                </ol>
            </div>
        </div>
    </div>
</div>
