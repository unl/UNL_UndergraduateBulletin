<?php
echo '<h1>'.htmlentities($this->subject).'</h1>';

echo  '<div class="three_col left">
    <dl>';

foreach ($this->courses as $course) {
    include dirname(__FILE__).'/Course.tpl.php';
}
echo  '</dl></div>';
?>
<div class="col right">
    <h3>Filter Options</h3>
    <form method="POST" action="#" id="filters">
        <?php if (count($this->groups)) : ?>
        <fieldset>
            <legend>Groups</legend>
            <ol>
                <?php foreach ($this->groups as $group) : ?>
                <li>
                    <label><?php echo $group; ?></label>
                    <div class="element">
                        <input type="checkbox" checked="checked" value="grp_<?php echo md5($group); ?>" />
                    </div>
                </li>
                <?php endforeach; ?>
            </ol>
        </fieldset>
        <?php endif; ?>
        <fieldset>
            <legend>Course Formats</legend>
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
                    <label><?php echo $type; ?></label>
                    <div class="element">
                        <input type="checkbox" checked="checked" value="<?php echo $key; ?>" />
                    </div>
                </li>
                <?php endforeach; ?>
            </ol>
        </fieldset>
        <fieldset>
            <legend>Ace Outcomes</legend>
            <ol>
                <?php for ($i=1;$i<=10;$i++) : ?>
                <li>
                    <label><?php echo $i; ?></label>
                    <div class="element">
                        <input type="checkbox" checked="checked" value="ace_<?php echo $i; ?>" />
                    </div>
                </li>
                <?php endfor; ?>
            </ol>
        </fieldset>
    </form>
</div>