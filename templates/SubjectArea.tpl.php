<?php
echo '<h1>'.htmlentities($this->subject).'</h1>';

echo  '<div class="three_col left">
    <dl>';

foreach ($this->courses as $course) {
    include dirname(__FILE__).'/Course.tpl.php';
}
echo  '</dl></div>';
?>
<div class="col right zenbox">
    <h3>Filter Options</h3>
    <form method="POST">
        <fieldset>
            <legend>Groups</legend>
            <ol>
                <?php foreach ($this->groups as $key=>$group) : ?>
                <li>
                    <label><?php echo $group; ?></label>
                    <div class="element">
                        <input type="checkbox" value="grp_<?php echo $key; ?>" />
                    </div>
                </li>
                <?php endforeach; ?>
            </ol>
        </fieldset>
    </form>
</div>