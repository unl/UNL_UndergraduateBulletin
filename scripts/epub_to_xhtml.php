<?php

if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

foreach (new GlobIterator(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/*/*.epub') as $file) {
    writeXHTMLFile($file);
}

foreach (new GlobIterator(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/*.epub') as $file) {
    writeXHTMLFile($file);
}

function writeXHTMLFile($file) {
    foreach (new RecursiveIteratorIterator(new PharData($file)) as $epub_file) {

        if ('xhtml' == pathinfo($epub_file, PATHINFO_EXTENSION)) {
            // Write the .xhtml file alongside the epub with the same filename
            echo $file->getFilename().PHP_EOL;
            $new_filename = str_replace('.epub', '.xhtml', $file->getPathname());
            file_put_contents($new_filename, str_replace("\r", "\n", file_get_contents($epub_file->getPathname())));

            // Remove the epub
            unlink($file->getPathname());
        }

    }
}

function convertLineEndings($file) {
    $contents = file_get_contents($file);
    $contents = str_replace("\r", "\n", $contents);
    file_put_contents($file, $contents);
}

