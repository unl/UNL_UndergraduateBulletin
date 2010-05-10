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
$files = glob(dirname(__FILE__).'/../www/templates/html/css/*.css');
foreach ($files as $file) {
    if (strstr($file, 'debug.css')
        || strstr($file, 'all.css')) {
        continue;
    }
    if ($corrected = @file_get_contents($file)) {
        echo preg_replace('/\@import[\s]+url\(.*\);/', '', $corrected);
    }
}

ob_end_flush();

$contents = ob_get_clean();
file_put_contents(dirname(__FILE__).'/../www/templates/html/css/all.css', $contents);
