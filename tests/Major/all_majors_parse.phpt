--TEST--
UNL_UndergraduateBulletin_MajorList::__isset()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$majors = new UNL_UndergraduateBulletin_MajorList();

foreach ($majors as $major) {
    $test->assertTrue(isset($major->description->college), 'major '.$major->title.' has college '.$major->college->name);
    try {
        isset($major->college->description->college);
        $success = true;
    } catch(Exception $e) {
        $success = false;
    }
    $test->assertTrue($success, 'major '.$major->title.' has college '.$major->college->name);
}


?>
===DONE===
--EXPECT--
===DONE===