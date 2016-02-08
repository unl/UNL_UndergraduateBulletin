<?php

namespace UNLTest\UndergraduateBulletin\EPUB;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\EPUB\Utilities;

class UtilitiesTest extends \PHPUnit_Framework_TestCase
{
    public function tesMappedFilesExist()
    {
        $edition = Controller::getEdition();
        $map = Utilities::getEpubToTitleMap();

        foreach ($map as $file => $title) {
            $filename = $edition->getDataDir().'/majors/'.$file.'.xhtml';
            $foundFile = file_exists($filename);

            if (!$foundFile) {
                // maybe it's not a major, try the other content areas
                $filename = $edition->getDataDir().'/other/'.$file.'.xhtml';
                $foundFile = file_exists($filename);
            }

            $this->aseertTrue($foundFile, $file . ' EPUB file does not exist');
        }
    }

    public function testBasicLink()
    {
        $string = 'AGRO 153';
        $linked = Utilities::addCourseLinks($string);
        $this->assertEquals('<a class="course" href="'.Controller::getURL().'courses/AGRO/153">AGRO 153</a>', $linked, 'basic link');
    }

    /**
     * @dataProvider findCoursesProvider
     */
    public function testFindCourses($input, $output)
    {
        $courses = Utilities::findCourses($input);
        $this->assertEquals($output, $courses);
    }

    public function findCoursesProvider()
    {
        return [
            ['AGRO 153', ['AGRO' => ['153']]],
            ['Prereqs: AECN 141 and ECON 312.', ['AECN' => ['141'], 'ECON' => ['312']]],
            ['MATH 106/106B/106H', [
                'MATH' => [
                    '106',
                    '106B',
                    '106H',
                ],
            ]],
            ['HIST 244 19<sup>th</sup>', [
                'HIST' => [
                    '244',
                ],
            ]],
        ];
    }

    /**
     * @dataProvider leadersProvider
     */
    public function testLeaders($input, $output)
    {
        $html = Utilities::addLeaders($input);
        $this->assertEquals($output, $html);
    }

    public function leadersProvider()
    {
        return [
            [
                '<p class="requirement-sec-1">Natural Resources Core 19</p>',
                '<p class="requirement-sec-1"><span class="req_desc">Natural Resources Core</span><span class="leader"></span><span class="req_value">19</span></p>',
            ],
            [
                '<p class="requirement-sec-1">Subtotal 97-102</p>',
                '<p class="requirement-sec-1"><span class="req_desc">Subtotal</span><span class="leader"></span><span class="req_value">97-102</span></p>',
            ],
            [
                '<p class="requirement-sec-2">ACE Elective 3</p>',
                '<p class="requirement-sec-2"><span class="req_desc">ACE Elective</span><span class="leader"></span><span class="req_value">3</span></p>',
            ],
            [
                '<p class="requirement-sec-3-ledr">ASCI 250 Animal Management 3</p>',
                '<p class="requirement-sec-3-ledr"><span class="req_desc">ASCI 250 Animal Management</span><span class="leader"></span><span class="req_value">3</span></p>',
            ],
            [
                '<p class="requirement-sec-3-ledr">ACE 6. EDPS 251 <span class="requirement-ital">(Pre-Professional Education Requirement)</span> 3</p>',
                '<p class="requirement-sec-3-ledr"><span class="req_desc">ACE 6. EDPS 251 <span class="requirement-ital">(Pre-Professional Education Requirement)</span></span><span class="leader"></span><span class="req_value">3</span></p>',
            ],
            [
                '<p class="requirement-sec-2">6 hours of SPAN 305 and SPAN 317</p>',
                '<p class="requirement-sec-2">6 hours of SPAN 305 and SPAN 317</p>',
            ],
            [
                '<p class="requirement-sec-1">Total Hours 120</p>',
                '<p class="requirement-sec-1"><span class="req_desc">Total Hours</span><span class="leader"></span><span class="req_value">120</span></p>',
            ],
        ];
    }
}
