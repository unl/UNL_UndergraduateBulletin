<?php

namespace UNLTest\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Major\Major;
use UNL\UndergraduateBulletin\Major\SubjectAreas;

class SubjectAreasTest extends \PHPUnit_Framework_TestCase
{
	public function testIteration()
	{
		$subjectAreaMap = SubjectAreas::getMapping();
		$missingDescriptions = [];

		foreach (array_keys($subjectAreaMap) as $majorName) {

		    $major = Major::getByName($majorName);

		    try {
		        $major->getDescription();
		    } catch (\Exception $e) {
		        $missingDescriptions[] = $majorName;
		    }
		}

		$this->assertEquals([], $missingDescriptions, 'no missing major descriptions');
	}
}
