--TEST--
UNL_UndergraduateBulletin_MajorList::__isset()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$majors = new UNL_UndergraduateBulletin_MajorList();

foreach ($majors as $major) {
    $test->assertTrue(isset($major->description->colleges), 'major '.$major->title.' has colleges');
    try {
        foreach ($major->colleges as $college) {
            isset($college->description->college);
            $success = true;
        }
    } catch(Exception $e) {
        $success = false;
    }
    $test->assertTrue($success, 'major '.$major->title.' has colleges');
}


?>
===DONE===
--EXPECT--
===DONE===