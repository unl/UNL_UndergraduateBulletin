#!/usr/bin/env php
<?php

require dirname(__FILE__).'/../config.sample.php';

foreach (new UNL_UndergraduateBulletin_Editions() as $edition) {

    UNL_UndergraduateBulletin_Controller::setEdition($edition);

    $file = file($edition->getDataDir().'/major_to_subject_code.csv');

    $majors = array();

    foreach ($file as $line) {
        $array = str_getcsv($line);
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
        $majors[trim($array[0])] = $codes;
    }

    file_put_contents($edition->getDataDir().'/major_to_subject_code.php.ser', serialize($majors));
}