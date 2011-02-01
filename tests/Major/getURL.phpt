--TEST--
UNL_UndergraduateBulletin_Major::getURL
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$major = UNL_UndergraduateBulletin_Major::getByName('Mechanical Engineering');
$test->assertEquals(UNL_UndergraduateBulletin_Controller::getURL().'major/Mechanical+Engineering', $major->getURL(), 'basic major url');

$major = UNL_UndergraduateBulletin_Major::getByName('Child Development/Early Childhood Education');
$test->assertEquals(UNL_UndergraduateBulletin_Controller::getURL().'major/Child+Development/Early+Childhood+Education', $major->getURL(), 'url with slash');

?>
===DONE===
--EXPECT--
===DONE===