--TEST--
UNL_UndergraduateBulletin_Controller::run()
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$controller = new UNL_UndergraduateBulletin_Controller();
$controller->run();

$test->assertTrue($controller->output[0] instanceof UNL_UndergraduateBulletin_Introduction, 'Default view');

?>
===DONE===
--EXPECT--
===DONE===