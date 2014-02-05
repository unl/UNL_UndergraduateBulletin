--TEST--
UNL_UndergraduateBulletin_College_Description::__isset()
--SKIPIF--
<?php
if (false) {
    echo 'Skip';
}
?>
--FILE--
<?php
require dirname(__FILE__) . '/../../test_framework.php.inc';

$college = new UNL_UndergraduateBulletin_College(array('name'=>'Arts & Sciences'));

$test->assertTrue(isset($college->description->admissionRequirements), 'admissionRequirements isset');
$test->assertTrue(isset($college->description->degreeRequirements),    'degreeRequirements isset');
$test->assertTrue(isset($college->description->aceRequirements),       'aceRequirements isset');
$test->assertTrue(isset($college->description->bulletinRule),       'bulletinRule isset');

$test->assertFalse(isset($college->description->fakeRequirements),     'fakeRequirements isset');

try {
    $college = new UNL_UndergraduateBulletin_College(array('name'=>'Libraries'));

    $test->assertFalse(isset($college->description->other),                 'other info isset');
} catch (Exception $e) {
    // All OK, this edition might not have a "Libraries" college
}

?>
===DONE===
--EXPECT--
===DONE===
