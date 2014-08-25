--TEST--
Tests the caching of the Major view
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$cacheDir = dirname(__FILE__) . '/../tmp/';
@mkdir($cacheDir);

UNL_UndergraduateBulletin_OutputController::setCacheInterface(new UNL_UndergraduateBulletin_CacheInterface_UNLCacheLite(array('cacheDir' => $cacheDir)));

$controller = new UNL_UndergraduateBulletin_Controller(array(
	'view' => 'plans',
	'name' => 'Architecture',
	'format' => 'json',
));
$outputcontroller = new UNL_UndergraduateBulletin_OutputController();
$outputcontroller->setClassToTemplateMapper(new UNL_UndergraduateBulletin_ClassToTemplateMapper());

$templatesDir = realpath(dirname(__FILE__) . '/../../www/templates');

$outputcontroller->setTemplatePath($templatesDir.'/html');
$outputcontroller->addTemplatePath($templatesDir.'/json');

$outputcontroller->addGlobal('controller', $controller);
$output = $outputcontroller->render($controller);

$controller = new UNL_UndergraduateBulletin_Controller(array(
	'view' => 'plans',
	'name' => 'Architecture',
));
$outputcontroller->setEscape('htmlentities');
$outputcontroller->setTemplatePath($templatesDir.'/html');
$outputcontroller->addGlobal('controller', $controller);

// simulate partial render (should cache only the major object)
$controller->run();
$output2 = $outputcontroller->render($controller->output[0]);

$test->assertFalse(strpos($output2, $output), 'There should be no JSON in the HTML output');

// output the entire controller now (should find major from cache)
$output = $outputcontroller->render($controller);

$test->assertTrue(strpos($output, '<h1><span class="subhead">Architecture </span> Architecture</h1>') !== false, 'Pagetitle should include major name')

?>
===DONE===
--EXPECT--
===DONE===
--CLEAN--
<?php
$cacheDir = dirname(__FILE__) . '/../tmp/';
@array_map('unlink', glob($cacheDir . '*'));
@rmdir($cacheDir);
?>