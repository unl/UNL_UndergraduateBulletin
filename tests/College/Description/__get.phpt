--TEST--
UNL_UndergraduateBulletin_College_Description::__get()
--FILE--
<?php
require dirname(__FILE__) . '/../../test_framework.php.inc';

$college = new UNL_UndergraduateBulletin_College(array('name'=>'Arts & Sciences'));

$test->assertEquals('<h3 class="title-1">College Admission </h3>
<p class="basic-text">The entrance requirements for the College of Arts and Sciences are the same as the UNL General Admission Requirements. Students who are admitted through the Admission by Review process with core course deficiencies will have certain conditions attached to their enrollment at UNL. These conditions are explained under “Removal of Deficiencies.”</p>
<p class="basic-text">In addition to these requirements, the College of Arts and Sciences strongly recommends a third and fourth year of languages. Four years of high school language will exempt students from the College of Arts and Sciences’ language requirement. It will also allow students to continue language study at a more advanced level, and give more opportunity to study abroad.</p>
<h4 class="title-2">Transfer Students</h4>
<p class="basic-text">To be considered for admission a transfer student, Nebraska resident or nonresident, must have an accumulated average of C (2.0 on a 4.0 scale) and a minimum C average in the last semester of attendance at another college. Transfer students who graduated from high school January 1997 and after must also meet the UNL General Admissions Requirements. Those transfer students who graduated before January 1997 must have completed in high school 3 years of English, 2 years of the same foreign language, 2 years of algebra, and 1 year of geometry. Transfer students who have completed less than 12 credit hours of college study must submit either the ACT or SAT scores.</p>
<p class="basic-text">Ordinarily, hours earned at an accredited college are accepted by the University. The College, however, will evaluate all hours submitted on an application for transfer and reserves the right to accept or reject any of them. Sixty-six is the maximum number of hours the University will accept on transfer from a two-year college. Transfer credit in the major must be approved by the major adviser on a Request for Substitution Form to meet specific course requirements, group requirements, or course level requirements in the major. At least half of the hours in the major field must be completed at the University regardless of the number of hours transferred.</p>
<p class="basic-text">The College of Arts and Sciences will accept no more than 15 semester hours of C- and D grades from other schools. The C- and D grades cannot be applied toward requirements for a major or minor. This policy does not apply to the transfer of grades from UNO or UNK to UNL. All D grades may be transferred from UNO or UNK, but they are not applicable to a major or minor.</p>
<h4 class="title-2">Readmitted Students</h4>
<p class="basic-text">Students readmitted to the College of Arts and Sciences will follow the requirements stated in the bulletin for the academic year of readmission and reenrollment as a degree-seeking student in Arts and Sciences. In consultation with advisers, a student may choose to follow a bulletin for any academic year in which they are admitted to and enrolled as a degree-seeking student at UNL in the College of Arts and Sciences. Students must complete all degree requirements from a single bulletin year. Beginning in 1990-1991, the bulletin which a student follows for degree requirements may not be more than 10 years old at the time of graduation.</p>
<h3 class="title-1">Admission Deficiencies/Removal of Deficiencies </h3>
<p class="basic-text">You must remove entrance deficiencies before you can graduate from the College of Arts and Sciences. For students entering August 1997 or later and who graduated from high school January 1997 and after, courses taken to remove a high school core course deficiency may not be counted toward either the major, minor, or college degree requirements. They may be counted in Achievement-Centered Education (ACE) and the “electives” categories in meeting degree requirements. The most common deficiencies are in foreign languages and mathematics.</p>
<h4 class="title-2">Removing Foreign Language Deficiencies</h4>
<p class="basic-text">A student who has had fewer than two years of one foreign language in high school will need 130 semester hours as a minimum for a degree from the College of Arts and Sciences. A student will also need to complete the “102” course in a language to clear the deficiency and the “202” course to complete the college graduation requirement in language.</p>
<h4 class="title-2">Removing Mathematics Deficiencies</h4>
<p class="numbered-list">1. A deficiency of one year of geometry can be removed by taking two high school geometry courses by Independent Study or by completing a geometry course from an accredited community college or a four-year institution. Neither of these options count for college credit.</p>
<p class="numbered-list">2. A deficiency of the first year of algebra can be removed by taking two high school Algebra I courses through Extended Education (not for college credit).</p>
<p class="numbered-list">3. A deficiency of the second year of algebra can be removed by taking <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/MATH/95C">MATH 95C</a> (not for college credit) or <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/MATH/100A">MATH 100A</a> (may be taken for college credit but does not apply toward graduation).</p>
<p class="numbered-list">4. A student whose deficiency is the additional (fourth) year of mathematics that builds on algebra must successfully complete one of the following: <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/MATH/101">MATH 101</a>, <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/MATH/102">MATH 102</a>, <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/MATH/103">MATH 103</a>, <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/STAT/218">STAT 218</a>, <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/ECON/215">ECON 215</a>, <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/EDPS/459">EDPS 459</a>, or <a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/SOCI/206">SOCI 206</a> or an equivalent course at another institution.</p>
<h4 class="title-2">Removing Other Deficiencies</h4>
<p class="basic-text">Contact the Arts and Sciences Advising Center for specific courses to remove other entrance deficiencies.</p>
', $college->description->admissionRequirements, 'admissionRequirements get');


$college = new UNL_UndergraduateBulletin_College(array('name'=>'Libraries'));



?>
===DONE===
--EXPECT--
===DONE===