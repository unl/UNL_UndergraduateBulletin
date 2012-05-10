--TEST--
UNL_UndergraduateBulletin_College_Description::__get()
--FILE--
<?php
require dirname(__FILE__) . '/../../test_framework.php.inc';

$college = new UNL_UndergraduateBulletin_College(array('name'=>'Arts & Sciences'));

$test->assertNotNull($college->description->admissionRequirements, 'admissionRequirements get');


$college = new UNL_UndergraduateBulletin_College(array('name'=>'Libraries'));



?>
===DONE===
--EXPECT--
===DONE===