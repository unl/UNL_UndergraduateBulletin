<?php
echo '<h2 class="sec_main"> Courses of Instruction ('.$context->subject.')</h2>';
echo '<a href="#" id="toggleAllCourseDescriptions">Hide all course descriptions</a>';
 ?>
 <div class="col left">
	<div class="zenbox energetic" id="wdn_filterset">
	    <h3>Filter these Courses</h3>
	    <form method="post" action="#" id="filters">
	        <?php if (count($context->groups)) : ?>
	        <fieldset class="groups">
	            <legend><span>Groups</span></legend>
	            <ol>
	                <?php foreach ($context->groups as $group) : ?>
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
	        <fieldset class="formats">
	            <legend><span>Course Formats</span></legend>
	            <ol>
	               <li><input type="checkbox" checked="checked" id="filterAll" name="all" value="all" /><label for="filterAll">All formats</label></li>
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
	                        <input type="checkbox" value="<?php echo $key; ?>" />
	                    </div><label><?php echo $type; ?></label>
	                </li>
	                <?php endforeach; ?>
	            </ol>
	        </fieldset>
	        <fieldset class="ace_outcomes">
	            <legend><span>ACE Outcomes</span></legend>
	            <ol>
	                <li><input type="checkbox" checked="checked" id="filterAllACE" name="allace" value="all" /><label for="filterAllACE">All ACE</label></li>
	                <?php for ($i=1;$i<=10;$i++) : ?>
	                <li>
	                    <div class="element">
	                        <input type="checkbox" value="ace_<?php echo $i; ?>" />
	                    </div>
	                    <label><?php echo $i.' '.UNL_UndergraduateBulletin_ACE::$descriptions[$i]; ?></label>
	                </li>
	                <?php endfor; ?>
	            </ol>
	        </fieldset>
	    </form>
	</div>
</div>
<?php

echo  '<div class="three_col right">
    <dl>';

foreach ($context->courses as $course) {
    echo $savvy->render($course);
}
echo  '</dl></div>';
?>