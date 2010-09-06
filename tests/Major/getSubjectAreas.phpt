--TEST--
UNL_UndergraduateBulletin_Major::getSubjectAreas
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$major = UNL_UndergraduateBulletin_Major::getByName('Mechanical Engineering');
$test->assertTrue($major->getSubjectAreas() instanceof UNL_UndergraduateBulletin_Major_SubjectAreas, 'subject areas are returned');
$test->assertTrue($major->subjectareas instanceof UNL_UndergraduateBulletin_Major_SubjectAreas, 'subject areas are returned');


?>
===DONE===
--EXPECT--
===DONE===