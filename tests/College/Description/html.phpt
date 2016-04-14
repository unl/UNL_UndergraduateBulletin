--TEST--
UNL_UndergraduateBulletin_College_Description::__get()
--FILE--
<?php
require dirname(__FILE__) . '/../../test_framework.php.inc';

$colleges = new UNL_UndergraduateBulletin_CollegeList();

foreach ($colleges as $college) {
    $rawDescription = file_get_contents(UNL_UndergraduateBulletin_College_Description::getFileByName($college->name));
    $test->assertSame(0, preg_match('#<span[^>]*?>\W*</span>#', $rawDescription), 'college '.$college->name.' has no empty spans');
    $test->assertSame(0, preg_match('#<strong[^>]*?></strong>#', $rawDescription), 'college '.$college->name.' has no empty strongs');
    $test->assertSame(0, preg_match('# style="#', $rawDescription), 'college '.$college->name.' has no style overrides');
    $test->assertSame(0, preg_match('#<br\s*/?>#', $rawDescription), 'college '.$college->name.' has no brs');
}

?>
===DONE===
--EXPECT--
===DONE===