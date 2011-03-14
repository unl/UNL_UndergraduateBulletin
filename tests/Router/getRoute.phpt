--TEST--
UNL_UndergraduateBulletin_Router::getRoute()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$base = UNL_UndergraduateBulletin_Controller::getURL();

$requestURI = $base;
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array(), $route, 'index, no default view');

$requestURI = $base . 'bulletinrules';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'bulletinrules'), $route, 'bulletin rules page');

$requestURI = $base . 'college/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'colleges'), $route, 'colleges');

$requestURI = $base . 'college/Arts+%26+Sciences';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'college', 'name'=>'Arts & Sciences'), $route, 'college');

$requestURI = $base . 'major/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'majors'), $route, 'all majors');

$requestURI = $base . 'major/search';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'searchmajors'), $route, 'major search');

$requestURI = $base . 'major/Aerospace+Studies';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'major', 'name'=>'Aerospace Studies'), $route, 'major with space');

$requestURI = $base . 'major/Aerospace/Studies';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'major', 'name'=>'Aerospace/Studies'), $route, 'major with slash');

$requestURI = $base . 'major/Aerospace+Studies/courses';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'courses', 'name'=>'Aerospace Studies'), $route, 'major courses');

$requestURI = $base . 'courses/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'subjects'), $route, 'subject areas');

$requestURI = $base . 'courses/search';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'searchcourses'), $route, 'course search');

$_SERVER['QUERY_STRING'] = 'q=math%202';
$requestURI = $base . 'courses/search/?q=math%202';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'searchcourses'), $route, 'course search with query string');
$_SERVER['QUERY_STRING'] = '';

$requestURI = $base . 'search';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'search'), $route, 'combined search results page');

$requestURI = $base . 'general';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'general'), $route, 'general bulletin information section');

$requestURI = $base . 'about';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'about'), $route, 'about bulletin information section');

$requestURI = $base . 'courses/CSCE/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'subject', 'id'=>'CSCE'), $route, 'subject code');

$requestURI = $base . 'courses/CSCE/420';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'course', 'subjectArea'=>'CSCE', 'courseNumber'=>'420'), $route, 'direct course');

$requestURI = $base . 'unknownview';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'no-route'), $route, '404 for unknown view');

?>
===DONE===
--EXPECT--
===DONE===