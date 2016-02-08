<?php

namespace UNLTest\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\College\College;

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
}
