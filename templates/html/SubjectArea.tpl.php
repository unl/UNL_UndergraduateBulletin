<?php
echo '<h1>'.htmlentities($this->subject).'</h1>';
 ?>
<div class="col left zenbox energetic" id="displayControl">
    <h3>Filter Options</h3>
    <form method="POST" action="#" id="filters">
        <?php if (count($this->groups)) : ?>
        <fieldset>
            <legend><span>Groups</span></legend>
            <ol>
                <?php foreach ($this->groups as $group) : ?>
                <li>
                    <div class="element">
                        <input type="checkbox" checked="checked" value="grp_<?php echo md5($group); ?>" />
                    </div>
                    <label><?php echo $group; ?></label>
                </li>
                <?php endforeach; ?>
            </ol>
        </fieldset>
        <?php endif; ?>
        <fieldset>
            <legend><span>Course Formats</span></legend>
            <ol>
                <?php foreach (array(
'lec'=>'Lecture',
'lab'=>'Lab',
'quz'=>'Quiz',
'rct'=>'Recitation',
'stu'=>'Studio',
'fld'=>'Field',
'ind'=>'Independent Study',
'psi'=>'Personalized System of Instruction') as $key=>$type) : ?>
                <li>
                    <div class="element">
                        <input type="checkbox" checked="checked" value="<?php echo $key; ?>" />
                    </div><label><?php echo $type; ?></label>
                </li>
                <?php endforeach; ?>
            </ol>
        </fieldset>
        <fieldset>
            <legend><span>Ace Outcomes</span></legend>
            <ol>
                <?php for ($i=1;$i<=10;$i++) : ?>
                <li>
                    <div class="element">
                        <input type="checkbox" checked="checked" value="ace_<?php echo $i; ?>" />
                    </div>
                    <label><?php echo $i; ?></label>
                </li>
                <?php endfor; ?>
            </ol>
        </fieldset>
    </form>
</div>
<?php

echo  '<div class="three_col right">
    <dl>';

foreach ($this->courses as $course) {
    include dirname(__FILE__).'/Course.tpl.php';
}
echo  '</dl></div>';
?>