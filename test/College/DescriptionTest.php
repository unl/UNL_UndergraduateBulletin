<?php

namespace UNLTest\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\College\College;
use UNL\UndergraduateBulletin\College\Colleges;
use UNL\UndergraduateBulletin\College\Description;

class DescriptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetters()
    {
        $college = new College(['name' => 'Arts & Sciences']);
        $this->assertNotNull($college->description->admissionRequirements, 'admissionRequirements get');
    }

    public function testIsseters()
    {
        $college = new College(['name' => 'Arts & Sciences']);

        $this->assertTrue(isset($college->description->admissionRequirements), 'admissionRequirements isset');
        $this->assertTrue(isset($college->description->degreeRequirements), 'degreeRequirements isset');
        $this->assertTrue(isset($college->description->aceRequirements), 'aceRequirements isset');
        $this->assertTrue(isset($college->description->bulletinRule), 'bulletinRule isset');
        $this->assertFalse(isset($college->description->fakeRequirements), 'fakeRequirements isset');

        try {
            $college = new College(['name' => 'Libraries']);
            $this->assertFalse(isset($college->description->other), 'other info isset');
        } catch (\Exception $e) {
            // All OK, this edition might not have a "Libraries" college
        }
    }

    public function testDescriptionHtml()
    {
        $colleges = new Colleges();

        foreach ($colleges as $college) {
            $rawDescription = file_get_contents(Description::getFileByName($college->getName()));
            $this->assertEquals(0, preg_match('#<span[^>]*?>\W*</span>#', $rawDescription), 'college '.$college->getName().' has no empty spans');
            $this->assertEquals(0, preg_match('#<strong[^>]*?></strong>#', $rawDescription), 'college '.$college->getName().' has no empty strongs');
            $this->assertEquals(0, preg_match('# style="#', $rawDescription), 'college '.$college->getName().' has no style overrides');
            $this->assertEquals(0, preg_match('#<br\s*/?>#', $rawDescription), 'college '.$college->getName().' has no brs');
        }
    }
}
