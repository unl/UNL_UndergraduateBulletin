<?php
$colleges = new UNL\UndergraduateBulletin\College\Colleges();
?>
<div class="filters-wrapper">
    <nav class="skipnav">
        <a href="#results">Skip filters</a>
    </nav>

    <h2 class="wdn-brand">Filter these Areas of Study</h2>
    <div class="filters" aria-controls="results">
        <div class="college">
            <button aria-controls="filters_college">College <span class="toggle">(Expand)</span></button>
            <div class="filter-options" id="filters_college" role="region" tabindex="-1" aria-expanded="false">
                <ol>
                   <li><input type="checkbox" checked="checked" id="filterAllCollege" class="filterAll" name="all" value="all" /><label for="filterAllCollege">All colleges</label></li>
                    <?php foreach($colleges as $abbreviation => $college): ?>
                    <li><input type="checkbox" id="filter<?php echo $abbreviation; ?>" name="<?php echo $abbreviation; ?>" value="<?php echo $abbreviation; ?>" />
                        <label for="filter<?php echo $abbreviation; ?>"><?php echo $savvy->escape($college->name); ?></label>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <div class="minor">
            <button aria-controls="filters_minor">Minor Available <span class="toggle">(Expand)</span></button>
            <div class="filter-options" id="filters_minor" role="region" tabindex="-1" aria-expanded="false">
                <ol>
                    <li><input type="checkbox" checked="checked" id="filterAllMinor" class="filterAll" name="all" value="all" /><label for="filterAllMinor">All</label></li>
                    <li><input type="checkbox" id="filterMinorAvailable" name="minorAvailable" value="minorAvailable" /><label for="filterMinorAvailable">Yes</label></li>
                    <li><input type="checkbox" id="filterMinorOnly" name="minorOnly" value="minorOnly" /><label for="filterMinorOnly">Minor Only</label></li>
                </ol>
            </div>
        </div>
    </div>
</div>
