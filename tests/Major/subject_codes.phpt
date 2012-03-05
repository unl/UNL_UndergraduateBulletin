--TEST--
Verify all major to subject code mappings are valid
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$majors = new UNL_UndergraduateBulletin_MajorList();

foreach ($majors as $major) {
    /* @var $major UNL_UndergraduateBulletin_Major */
    try {
        foreach ($major->getSubjectAreas() as $subject) {
            $success = true;
        }
    } catch(Exception $e) {
        $success = false;
        echo $e;
    }
    $test->assertTrue($success, 'major '.$major->title.' has valid course subject code mappings');
}


?>
===DONE===
--EXPECT--
===DONE===