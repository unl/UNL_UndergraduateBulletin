#!/usr/bin/env php
<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

foreach (new UNL_UndergraduateBulletin_Editions() as $edition) {

    UNL_UndergraduateBulletin_Controller::setEdition($edition);

    $file = file($edition->getDataDir().'/creq/subject_codes.csv');

    $codes = array();

    foreach ($file as $line) {
        $array = str_getcsv(trim($line, ' ,'));
        //print_r($array);
        /*
        For example:
        
        array(2) {
            [0] => string(4) "ABUS"
            [1] => string(12) "Agribusiness"
        }
        */
        
        $codes[$array[0]] = $array[1];
    }
    
    file_put_contents($edition->getDataDir().'/creq/subject_codes.php.ser', serialize($codes));
}