<div class="zenbox energetic wdn_filterset">
    <h3>Filter these Areas of Study</h3>
    <form method="post" action="#" class="filters">
    <fieldset class="formats">
        <legend><span>College</span></legend>
        <ol>
           <li><input type="checkbox" checked="checked" id="filterAllCollege" class="filterAll" name="all" value="all" /><label for="filterAllCollege">All colleges</label></li>
            <?php foreach(new UNL_UndergraduateBulletin_CollegeList() as $abbreviation=>$college): ?>
            <li><input type="checkbox" id="filter<?php echo $abbreviation; ?>" name="<?php echo $abbreviation; ?>" value="<?php echo $abbreviation; ?>" />
                <label for="filter<?php echo $abbreviation; ?>"><?php echo $college->name; ?></label>
            </li>
            <?php endforeach; ?>
        </ol>
    </fieldset>
    <fieldset class="formats">
        <legend><span>Minor Available</span></legend>
        <ol>
           <li><input type="checkbox" checked="checked" id="filterAllMinor" class="filterAll" name="all" value="all" /><label for="filterAllMinor">All</label></li>
           <li><input type="checkbox" id="filterMinorAvailable" name="minorAvailable" value="minorAvailable" /><label for="filterMinorAvailable">Yes</label></li>
           <li><input type="checkbox" id="filterMinorOnly" name="minorOnly" value="minorOnly" /><label for="filterMinorOnly">Minor Only</label></li>
        </ol>
    </fieldset>
    </form>
</div>