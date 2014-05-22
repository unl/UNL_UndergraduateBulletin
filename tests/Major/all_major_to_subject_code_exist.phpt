--TEST--
UNL_UndergraduateBulletin_Major_SubjectAreas::getMapping()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';
/*
 * This test checks that the major_to_subject_code file is formatted correctly
 * and contains correct major names
 */

$subject_area_mapping = UNL_UndergraduateBulletin_Major_SubjectAreas::getMapping();

foreach ($subject_area_mapping as $major_name=>$subject_areas) {

    $major = UNL_UndergraduateBulletin_Major::getByName($major_name);

    try {
        $major->getDescription();
    } catch (Exception $e) {
        echo $major_name.'=>'.implode(', ', $subject_areas).' has no description file'.PHP_EOL;
    }

}

?>
===DONE===
--EXPECT--
===DONE===