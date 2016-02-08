<?php

namespace UNLTest\UndergraduateBulletin;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\Introduction;
use UNL\UndergraduateBulletin\OutputController;
use UNL\UndergraduateBulletin\CachingService\UNLCacheLite;
use UNL\Templates\Templates;
use UNL\Templates\CachingService\NullService;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
	protected function tearDown()
	{
		$this->rrmdir(__DIR__ . '/tmp');
	}

	public function testRun()
	{
		$controller = new Controller();
		$controller->run();

		$this->assertInstanceOf(Introduction::class, $controller->output, 'Default view');
	}

	public function testMajorViewCaching()
	{
		$cacheDir = __DIR__ . '/tmp/';
		@mkdir($cacheDir);

		OutputController::setCacheInterface(new UNLCacheLite(['cacheDir' => $cacheDir]));
		Templates::setCachingService(new NullService());

		$controller = new Controller([
			'view' => 'plans',
			'name' => 'Architecture',
			'format' => 'json',
		]);
		$outputcontroller = new OutputController();
		$outputcontroller->setupFromController($controller, false);
		$output = $outputcontroller->render($controller);

		$controller = new Controller([
			'view' => 'plans',
			'name' => 'Architecture',
		]);
		$outputcontroller = new OutputController();
		$outputcontroller->setupFromController($controller, false);

		// simulate partial render (should cache only the major object)
		$controller->run();
		$output2 = $outputcontroller->render($controller->output);

		$this->assertFalse(strpos($output2, $output), 'There should be no JSON in the HTML output');

		// output the entire controller now (should find major from cache)
		$output = $outputcontroller->render($controller);

		$this->assertTrue(strpos($output, '<h1><span class="subhead">Architecture </span> Architecture</h1>') !== false, 'Pagetitle should include major name');
	}

	protected function rrmdir($src)
	{
		if (!file_exists($src)) {
			return;
		}

		$dir = opendir($src);

	    while (false !== ( $file = readdir($dir)) ) {
	        if (( $file == '.' ) || ( $file == '..' )) {
	        	continue;
	        }

            $full = $src . '/' . $file;

            if ( is_dir($full) ) {
                $this->rrmdir($full);
                continue;
            }

            unlink($full);
	    }

	    closedir($dir);
	    rmdir($src);
	}
}
