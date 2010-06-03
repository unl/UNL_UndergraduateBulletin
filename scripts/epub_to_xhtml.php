<?php

require dirname(__FILE__).'/../config.sample.php';

//$epub_map = array();


foreach (new GlobIterator(UNL_UndergraduateBulletin_Controller::getDataDir().'/*/*.epub') as $file) {
    writeXHTMLFile($file);
}

foreach (new GlobIterator(UNL_UndergraduateBulletin_Controller::getDataDir().'/*.epub') as $file) {
    writeXHTMLFile($file);
}

function writeXHTMLFile($file) {
    foreach (new RecursiveIteratorIterator(new PharData($file)) as $epub_file) {

        if ('xhtml' == pathinfo($epub_file, PATHINFO_EXTENSION)) {
            // Write the .xhtml file alongside the epub with the same filename
            echo $file->getFilename().PHP_EOL;
            file_put_contents(str_replace('.epub', '.xhtml', $file->getPathname()),
                              file_get_contents($epub_file->getPathname()));

            // Remove the epub
            unlink($file->getPathname());
        }

    }
}


