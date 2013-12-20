#!/usr/bin/env php
<?php
ob_start();
header('Content-type: text/css');
echo '/**
 * This file is part of the UNL Undergraduate Bulletin.
 * http://bulletin.unl.edu/undergraduate/
 * $Id$
 */'.PHP_EOL;
ob_start("compress");
function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    $buffer = str_replace(', ', ',', $buffer);
    return $buffer;
}

/* css files */
$files = array(
'general.css',
'courses.css',
'filters.css',
'majors.css',
'indesign_epub.css',
'search_results.css',
);
foreach ($files as $file) {
    if ($corrected = @file_get_contents(dirname(__FILE__).'/../www/templates/html/css/'.$file)) {
        echo preg_replace('/\@import[\s]+url\(.*\);/', '', $corrected);
    }
}

ob_end_flush();

$contents = ob_get_clean();
file_put_contents(dirname(__FILE__).'/../www/templates/html/css/all.css', $contents);
