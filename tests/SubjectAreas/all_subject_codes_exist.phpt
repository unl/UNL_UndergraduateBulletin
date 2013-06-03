--TEST--
Verify we have ALL course subject codes
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$data_dir = UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir();

$new_subs = 'grep -e "<subject>.*</subject>" -o '.$data_dir.'/all-courses.xml  | grep -E "[A-Z]{3,4}" -o | sort | uniq > '.__DIR__.'/newsubs';
exec($new_subs);

$old_subs = 'grep -o -E "^[A-Z]+" '.$data_dir.'/subject_codes.csv > '.__DIR__.'/oldsubs';
exec($old_subs);
passthru('diff -u ' . __DIR__ . '/oldsubs ' . __DIR__ . '/newsubs');

?>
===DONE===
--CLEAN--
<?php
if (file_exists(__DIR__ . '/oldsubs')) {
    unlink(__DIR__ . '/oldsubs');
}
if (file_exists(__DIR__ . '/newsubs')) {
    unlink(__DIR__ . '/newsubs');
}
?>
--EXPECT--
===DONE===
