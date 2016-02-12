<?php

namespace UNLTest\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Major\Majors;

class MajorsTest extends \PHPUnit_Framework_TestCase
{
	public function testIteration()
	{
		$majors = new Majors();

		foreach ($majors as $major) {
            $this->assertTrue(isset($major->description->colleges));
            $rawDescription = file_get_contents($major->description::getFileByName($major->title));
		    $this->assertEquals(0, preg_match('#<span[^>]*?>\W*</span>#', $rawDescription), 'major '.$major->title.' has no empty spans');
		    $this->assertEquals(0, preg_match('#<strong[^>]*?></strong>#', $rawDescription), 'major '.$major->title.' has no empty strongs');
		    $this->assertEquals(0, preg_match('# style="#', $rawDescription), 'major '.$major->title.' has no style overrides');
		    $this->assertEquals(0, preg_match('#<br\s*/?>#', $rawDescription), 'major '.$major->title.' has no brs');


            foreach ($major->colleges as $college) {
	            $this->assertEquals($college, $college->description->college);
	        }

	        foreach ($major->getSubjectAreas() as $subject) {
	            $this->assertNotNull($subject->getCourses());

	        }
		}
	}
}
