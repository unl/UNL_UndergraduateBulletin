--TEST--
UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders() basic test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';

$string = '<p class="requirement-sec-1">Natural Resources Core 19</p>';

$html = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($string);

$test->assertEquals('<p class="requirement-sec-1"><span class="req_desc">Natural Resources Core</span><span class="leader"></span><span class="req_value">19</span></p>', $html, 'basic leader');

$string = '<p class="requirement-sec-1">Subtotal 97-102</p>';

$html = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($string);

$test->assertEquals('<p class="requirement-sec-1"><span class="req_desc">Subtotal</span><span class="leader"></span><span class="req_value">97-102</span></p>', $html, 'basic leader with span');

$string = '<p class="requirement-sec-2">ACE Elective 3</p>';

$html = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($string);

$test->assertEquals('<p class="requirement-sec-2"><span class="req_desc">ACE Elective</span><span class="leader"></span><span class="req_value">3</span></p>', $html, 'basic leader - second level');

$string = '<p class="requirement-sec-3-ledr">ASCI 250 Animal Management 3</p>';

$html = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($string);

$test->assertEquals('<p class="requirement-sec-3-ledr"><span class="req_desc">ASCI 250 Animal Management</span><span class="leader"></span><span class="req_value">3</span></p>', $html, 'basic leader - third level');

$string = '<p class="requirement-sec-3-ledr">ASCI 250 Animal Management 3</p>';

$html = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($string);

$test->assertEquals('<p class="requirement-sec-3-ledr"><span class="req_desc">ASCI 250 Animal Management</span><span class="leader"></span><span class="req_value">3</span></p>', $html, 'basic leader - third level');

$string = '<p class="requirement-sec-3-ledr">ACE 6. EDPS 251 <span class="requirement-ital">(Pre-Professional Education Requirement)</span> 3</p>';

$html = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($string);

$test->assertEquals('<p class="requirement-sec-3-ledr"><span class="req_desc">ACE 6. EDPS 251 <span class="requirement-ital">(Pre-Professional Education Requirement)</span></span><span class="leader"></span><span class="req_value">3</span></p>', $html, 'leader with html - third level');

?>
===DONE===
--EXPECT--
===DONE===