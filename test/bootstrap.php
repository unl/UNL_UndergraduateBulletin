<?php

$configFile = __DIR__ . '/../config.inc.php';
if (!file_exists($configFile)) {
	$configFile = __DIR__ . '/../config.sample.php';
}

require $configFile;
