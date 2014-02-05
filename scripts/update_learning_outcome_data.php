#!/usr/bin/env php
<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

$edition = UNL_UndergraduateBulletin_Editions::getLatest();

if (isset($_SERVER['argv'], $_SERVER['argv'][1])) {
    $edition = UNL_UndergraduateBulletin_Edition::getByYear($_SERVER['argv'][1]);
}

echo 'Updating four-year-plan data for '.$edition->year.PHP_EOL;

$outcomes_feed = 'https://creq.unl.edu/learningoutcomes/view/feed';

$data = file_get_contents($outcomes_feed);

if (false === $data) {
    echo 'Could not retrieve data from ' . $outcomes_feed . PHP_EOL;
    exit(1);
}

$outcome_data = json_decode($data);

foreach ($outcome_data as $outcome) {

    // Try and get the associated major
    $major = UNL_UndergraduateBulletin_Major::getByName($outcome->major);
    
    if (false === $major) {
        throw new Exception('Could not find ' . $outcome->major);
    }

    // json encode the data and store it for this individual major
    $data = json_encode($outcome);

    file_put_contents($edition->getDataDir().'/outcomes/'.$outcome->major.'.json', $data);
}

