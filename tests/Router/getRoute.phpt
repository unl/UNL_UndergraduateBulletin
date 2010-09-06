--TEST--
UNL_UndergraduateBulletin_Router::getRoute()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array(), $route, 'index, no default view');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/bulletinrules';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'bulletinrules'), $route, 'bulletin rules page');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/college/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'colleges'), $route, 'colleges');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/college/Arts+%26+Sciences';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'college', 'name'=>'Arts & Sciences'), $route, 'college');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/major/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'majors'), $route, 'all majors');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/major/search';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'searchmajors'), $route, 'major search');

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

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/courses/search';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'searchcourses'), $route, 'course search');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/search';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'search'), $route, 'combined search results page');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/general';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'general'), $route, 'general bulletin information section');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/about';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'about'), $route, 'about bulletin information section');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/courses/CSCE/';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'subject', 'id'=>'CSCE'), $route, 'subject code');

$requestURI = '/workspace/UNL_UndergraduateBulletin/www/courses/CSCE/420';
$route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
$test->assertEquals(array('view'=>'course', 'subjectArea'=>'CSCE', 'courseNumber'=>'420'), $route, 'direct course');

try {
    $requestURI = '/workspace/UNL_UndergraduateBulletin/www/unknownview';
    $route = UNL_UndergraduateBulletin_Router::getRoute($requestURI);
    throw new Exception('Should have failed');
} catch (\Exception $e) {
    $test->assertEquals(404, $e->getCode(), '404 for unknown view');
}

?>
===DONE===
--EXPECT--
===DONE===