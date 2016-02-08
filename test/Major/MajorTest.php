<?php

namespace UNLTest\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\Major\Major;
use UNL\UndergraduateBulletin\Major\SubjectAreas;

class MajorTest extends \PHPUnit_Framework_TestCase
{
	public function testIsseters()
	{
		$major = Major::getByName('Mechanical Engineering');
		$this->assertInstanceOf(Major::class, $major);
		$this->assertEquals('Mechanical Engineering', $major->title, 'correct major title');
		$this->assertTrue(isset($major->colleges), 'College is set');
		$this->assertFalse(isset($major->fakevariable), 'fakevariable is not set');
	}

	public function testGetSubjectAreas()
	{
		$major = Major::getByName('Mechanical Engineering');
		$this->assertInstanceOf(SubjectAreas::class, $major->getSubjectAreas(), 'subject areas are returned');
		$this->assertInstanceOf(SubjectAreas::class, $major->subjectareas, 'subject areas are returned');
	}

	public function testGetURL()
	{
		$major = Major::getByName('Mechanical Engineering');
		$this->assertEquals(Controller::getURL().'major/Mechanical+Engineering', $major->getURL(), 'basic major url');

		$major = Major::getByName('Child Development/Early Childhood Education');
		$this->assertEquals(Controller::getURL().'major/Child+Development/Early+Childhood+Education', $major->getURL(), 'url with slash');
	}

	public function testMinorAvailable()
	{
		$major = Major::getByName('Mechanical Engineering');
		$this->assertFalse($major->minorAvailable(), 'no mechanical engineering minor available');

		$major = Major::getByName('Accounting');
		$this->assertTrue($major->minorAvailable(), 'accounting minor available');

		$major = Major::getByName('Statistics Minor (ASC)');
		$this->assertTrue($major->minorAvailable(), 'statistics (ASC) minor available');
	}

	public function testMinorOnly()
	{
		$major = Major::getByName('Mechanical Engineering');
		$this->assertFalse($major->minorOnly());

		$major = Major::getByName('Accounting');
		$this->assertFalse($major->minorOnly());

		$major = Major::getByName('Statistics Minor (ASC)');
		$this->assertTrue($major->minorOnly());
	}
}
