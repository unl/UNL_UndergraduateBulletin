<?php

namespace UNLTest\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Major\Majors;

class MajorsTest extends \PHPUnit_Framework_TestCase
{
	public function testIteration()
	{
		$majors = new Majors();

		foreach ($majors as $major) {
	        foreach ($major->getSubjectAreas() as $subject) {
	            $this->assertNotNull($subject->getCourses());
	            $this->assertTrue(isset($major->description->colleges));

	            foreach ($major->colleges as $college) {
		            $this->assertEquals($college, $college->description->college);
		        }
	        }
		}
	}
}
