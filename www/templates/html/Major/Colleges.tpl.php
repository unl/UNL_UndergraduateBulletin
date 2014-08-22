<?php
$college_regions = array(
    'admissionRequirements'         => 'College Admission',
    'degreeRequirements'            => 'College Degree Requirements',
    'aceRequirements'               => 'ACE Requirements',
    'bulletinRule'                  => 'Bulletin Rule',
    );
foreach ($context as $college) {
    foreach ($college_regions as $id => $title) {
        if (isset($college->description->$id)) { 
            $college_section = $college->description->getRaw($id);
            ?>
            <div id="college_<?php echo $id; ?>">
                <h3><?php echo $title; ?></h3>
                <?php echo str_replace(array('<h3', '</h3>'),
                                       array('<h4', '</h4>'), $college_section); ?>
            </div>
            <?php
        }
    }
}
?>