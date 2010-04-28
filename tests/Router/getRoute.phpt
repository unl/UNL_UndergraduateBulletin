--TEST--
UNL_UndergraduateBulletin_Router::getRoute()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/college/Arts+%26+Sciences';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'college', 'name'=>'Arts & Sciences'), $route, 'college');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/major/Aerospace+Studies';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'major', 'name'=>'Aerospace Studies'), $route, 'major with space');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/major/Aerospace/Studies';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'major', 'name'=>'Aerospace/Studies'), $route, 'major with slash');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/major/Aerospace+Studies/courses';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'courses', 'name'=>'Aerospace Studies'), $route, 'major courses');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/courses/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'subjects'), $route, 'subject areas');

?>
===DONE===
--EXPECT--
===DONE===