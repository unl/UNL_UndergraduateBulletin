#!/usr/bin/env php
<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

require_once __DIR__ . '/classes/CreqDataShell.php';

error_reporting(E_ALL);
set_time_limit(0);

$cli = new CreqDataShell();
$cli->fetchOutcomes();
