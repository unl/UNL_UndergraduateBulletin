<?php

require dirname(__FILE__).'/../config.sample.php';

foreach (new UNL_UndergraduateBulletin_Editions() as $edition) {

    UNL_UndergraduateBulletin_Controller::setEdition($edition);

    $file = file($edition->getDataDir().'/acad_plan_full.csv');

    $majors = array();

    foreach ($file as $line) {
        $array = str_getcsv($line);
        /*
        For example:

        array(2) {
          [0]=>
          string(9) "AACTS-MAJ"
          [1]=>
          string(17) "Actuarial Science"
        }

        */

        $plan = explode('-', $array[0]);
        if (!isset($plan[1]) || in_array($plan[1], array('MIN', 'MAJ', 'GMIN', 'GMAJ', 'NDEG'))) {
            $majors[$plan[0]] = $array[1];
        }
    }

    file_put_contents($edition->getDataDir().'/major_lookup.php.ser', serialize($majors));
}