--TEST--
UNL_UndergraduateBulletin_MajorList::__isset()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$majors = new UNL_UndergraduateBulletin_MajorList();

foreach ($majors as $major) {
    $rawDescription = file_get_contents(UNL_UndergraduateBulletin_EPUB_Utilities::getFileByName($major->title, 'majors', 'xhtml'));
    $test->assertTrue(isset($major->description->colleges), 'major '.$major->title.' has colleges');
    $test->assertSame(0, preg_match('#<span[^>]*?></span>#', $rawDescription), 'major '.$major->title.' has no empty spans');
    $test->assertSame(0, preg_match('#<strong[^>]*?></strong>#', $rawDescription), 'major '.$major->title.' has no empty strongs');
    $test->assertSame(0, preg_match('# style="#', $rawDescription), 'major '.$major->title.' has no style overrides');
    try {
        foreach ($major->colleges as $college) {
            isset($college->description->college);
            $success = true;
        }
    } catch(Exception $e) {
        $success = false;
    }
    $test->assertTrue($success, 'major '.$major->title.' has colleges');
}


?>
===DONE===
--EXPECT--
===DONE===