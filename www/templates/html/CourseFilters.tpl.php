<?php
$idPrefix = '';
if (isset($context->subject)) {
    $idPrefix = $context->subject;
}
?>
<div class="zenbox energetic wdn_filterset">
    <h3>Filter these Courses</h3>
    <form method="post" action="#" id="<?php echo $idPrefix; ?>_filters" class="filters courseFilters">
        <?php if (isset($context->groups)
                  && count($context->groups)) : ?>
        <fieldset class="groups">
            <legend><span>Groups</span></legend>
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
        </fieldset>
        <?php endif; ?>
        <fieldset class="formats">
            <legend><span>Course Formats</span></legend>
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
        </fieldset>
        <fieldset class="ace_outcomes">
            <legend><span>ACE Outcomes</span></legend>
            <ol>
                <li>
                    <input type="checkbox" id="<?php echo $idPrefix; ?>_filterAllACE" class="filterAll" checked="checked" name="allace" value="all" />
                    <label for="<?php echo $idPrefix; ?>_filterAllACE">All ACE</label></li>
                <?php for ($i=1;$i<=10;$i++) : ?>
                <li>
                        <input type="checkbox" id="<?php echo $idPrefix; ?>_filter_ace_<?php echo $i; ?>" value="ace_<?php echo $i; ?>" />
                    
                    <label for="<?php echo $idPrefix; ?>_filter_ace_<?php echo $i; ?>"><?php echo $i.' '.UNL_UndergraduateBulletin_ACE::$descriptions[$i]; ?></label>
                </li>
                <?php endfor; ?>
            </ol>
        </fieldset>
    </form>
</div>