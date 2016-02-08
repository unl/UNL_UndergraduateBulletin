#!/usr/bin/env php
<?php

include __DIR__ . '/../test/bootstrap.php';
require_once __DIR__ . '/classes/CreqDataShell.php';

error_reporting(E_ALL);
set_time_limit(0);

$baseCmd = array_shift($_SERVER['argv']);
if (empty($baseCmd)) {
	exit(1);
}

$command = array_shift($_SERVER['argv']);
array_unshift($_SERVER['argv'], $baseCmd);
$cli = new CreqDataShell();

switch ($command) {
	case 'update':
		$cli->fetchUpdates();
		break;
	case 'rebuild-subjects':
		$cli->rebuildSubjectMap();
		break;
	case 'rebuild-major-map':
		$cli->rebuildMajorSubjectMap();
		break;
	case 'rebuild-plan-map':
		$cli->rebuildPlanMajorMap();
		break;
	case 'build-db':
		$cli->buildDb();
		break;
	case 'update-plans':
		$cli->fetchPlans();
		break;
	case 'update-outcomes':
		$cli->fetchOutcomes();
		break;
	case 'full-update':
		$cli->fetchUpdates();
		$cli->fetchOutcomes();
		$cli->fetchPlans();
		break;
	default:
		echo "Unknown command: $command\n";
		echo "Usage: creq-shell.php update [edition]\n";
		echo "       creq-shell.php full-update [edition]\n";
		echo "       creq-shell.php rebuild-subjects [edition]\n";
		echo "       creq-shell.php rebuild-major-map [edition]\n";
		echo "       creq-shell.php build-db [edition]\n";
		echo "       creq-shell.php update-plans [edition]\n";
		echo "       creq-shell.php update-outcomes [edition]\n";
		exit(1);
}
