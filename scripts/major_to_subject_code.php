<?php

require '../config.sample.php';

$file = file(UNL_UndergraduateBulletin_Controller::getDataDir().'/major_to_subject_code.csv');

$majors = array();

foreach ($file as $line) {
    $array = str_getcsv($line);
    
    $major = new UNL_UndergraduateBulletin_Major(array('title'=>$array[0]));
    
//    0 = major
//    1 = college
//    2 = codes
    $codes = array();
    if (isset($array[2])
        && trim($array[2]) != 'NO COURSE TAB') {
        $codes = explode(',', str_replace(' ', '', $array[2]));
    }
    sort($codes);
    $majors[$array[0]] = $codes;
}

file_put_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/major_to_subject_code.php.ser', serialize($majors));