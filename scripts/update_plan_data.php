#!/usr/bin/env php
<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

$edition = UNL_UndergraduateBulletin_Editions::getLatest();

echo 'Updating four-year-plan data'.PHP_EOL;

$plan_feed = 'https://creq.unl.edu/fouryearplans/view/feed/';

$data = file_get_contents($plan_feed);

if (false === $data) {
    echo 'Could not retrieve data from ' . $plan_feed . PHP_EOL;
    exit(1);
}

$plan_data = json_decode($data);

foreach ($plan_data as $plan) {

    // Try and get the associated major
    $major = UNL_UndergraduateBulletin_Major::getByName($plan->major);
    
    if (false === $major) {
        throw new Exception('Could not find ' . $plan->major);
    }

    // json encode the data and store it for this individual major
    $data = json_encode($plan);

    file_put_contents($edition->getDataDir().'/fouryearplans/'.$plan->major.'.json', $data);
}

