--TEST--
UNL_UndergraduateBulletin_SubjectAreas()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$areas = new UNL_UndergraduateBulletin_SubjectAreas();

foreach ($areas as $code => $area) {
    $test->assertTrue(isset($area->courses), 'subjectarea '.$code.' has no courses ');
}


?>
===DONE===
--EXPECT--
===DONE===