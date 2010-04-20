<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'UNL | Undergraduate Bulletin | Majors/Areas of Study');
    UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Majors/Areas of Study</li>
</ul>
');
?>
<div class="col left">
    <div class="zenbox energetic" id="wdn_filterset">
        <h3>Filter these Areas of Study</h3>
        <form method="post" action="#" id="filters">
        <fieldset class="formats">
            <legend><span>College</span></legend>
            <ol>
               <li><input type="checkbox" checked="checked" id="filterAll" name="all" value="all" /><label for="filterAll">All colleges</label></li>
                <?php foreach(new UNL_UndergraduateBulletin_CollegeList() as $abbreviation=>$college): ?>
                <li><input type="checkbox" id="filter<?php echo $abbreviation; ?>" name="<?php echo $abbreviation; ?>" value="<?php echo $abbreviation; ?>" /><?php echo $college->name; ?></li>
                <?php endforeach; ?>
            </ol>
        </fieldset>
        <fieldset class="formats">
            <legend><span>Minor Available</span></legend>
            <ol>
               <li><input type="checkbox" checked="checked" id="filterAll" name="all" value="all" /><label for="filterAll">All</label></li>
               <li><input type="checkbox" id="filterMinorAvailable" name="minorAvailable" value="minorAvailable" /><label for="filterMinorAvailable">Yes</label></li>
            </ol>
        </fieldset>
        </form>
    </div>
</div>
<div class="three_col right">
    <h1>Select A Major or Area of Study</h1>
    <ul>
        <?php foreach ($context as $major):
        $class = '';
        if (isset($major->description->quickpoints['Minor Available'])) {
            if (preg_match('/^Yes/', $major->description->quickpoints['Minor Available'])) {
                $class .= 'minorAvailable ';
            }
        }
        
        if (isset($major->college)) {
            $class .= $major->college->abbreviation.' ';
        }
        ?>
        <li class="<?php echo trim($class); ?>"><a href="<?php echo $url; ?>major/<?php echo urlencode($major->getRaw('title')); ?>"><?php echo $major->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>