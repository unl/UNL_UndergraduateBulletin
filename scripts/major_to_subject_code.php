#!/usr/bin/env php
<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

foreach (new UNL_UndergraduateBulletin_Editions() as $edition) {

    UNL_UndergraduateBulletin_Controller::setEdition($edition);

    $file = file($edition->getDataDir().'/major_to_subject_code.csv');

    $majors = array();

    foreach ($file as $line) {
        $array = str_getcsv(trim($line, ' ,'));
        /*
        For example:
        
        array(3) {
          [0]=>
          string(13) "Water Science"
          [1]=>
          string(3) "ANR"
          [2]=>
          string(4) "WATS"
        }
        
        */
    
        $major = new UNL_UndergraduateBulletin_Major(array('title' => $array[0]));

        $codes = array();
        if (isset($array[2])
            && trim($array[2]) != 'NO COURSE TAB') {
            $codes = explode(',', str_replace(' ', '', $array[2]));
        }
        $codes = array_unique($codes);
        sort($codes);
        foreach ($codes as $key=>$code) {
            if (empty($code)) {
                unset($codes[$key]);
            }
        }
        $majors[trim($array[0])] = $codes;
    }

    file_put_contents($edition->getDataDir().'/major_to_subject_code.php.ser', serialize($majors));
}