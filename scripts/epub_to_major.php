<?php

require dirname(__FILE__).'/../config.sample.php';

$epub_map = array();

foreach (new GlobIterator(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/*.epub') as $file) {

    foreach (new RecursiveIteratorIterator(new PharData($file)) as $epub_file) {

        if ('xhtml' == pathinfo($epub_file, PATHINFO_EXTENSION)) {
            $epub_map[$file->getFilename()] = $epub_file->getFilename();
        }

    }

}

file_put_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/major_epubs.json', json_encode($epub_map));
