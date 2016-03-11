<?php

use UNL\UndergraduateBulletin\Controller;

if (!isset($page)) {
	return;
}

$baseURL = Controller::getBaseURL();
$protocolAgnosticBaseURL = str_replace('http://', '//', $baseURL);
$page->addStylesheet($protocolAgnosticBaseURL . 'css/editions/2016.css');
