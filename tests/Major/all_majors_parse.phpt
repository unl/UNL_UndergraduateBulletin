--TEST--
UNL_UndergraduateBulletin_MajorList::__isset()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$majors = new UNL_UndergraduateBulletin_MajorList();

foreach ($majors as $major) {
    $test->assertTrue(isset($major->description->college), 'major '.$major->title.' has college '.$major->college->name);
}


?>
===DONE===
--EXPECT--
===DONE===