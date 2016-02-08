<?php

namespace UNLTest\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\SubjectArea\SubjectAreas;

class SubjectAreasTest extends \PHPUnit_Framework_TestCase
{
	public function testAllSubjectsHaveCourses()
	{
		$areas = new SubjectAreas();
		foreach ($areas as $code => $area) {
		    $this->assertNotNull($area->getCourses(), 'subjectarea '.$code.' has no courses ');
		}
	}

	public function testAllSubjectsFromCreqExist()
	{
		$creqDataDir = Controller::getEdition()->getCourseDataDir();
		$creqData = file_get_contents($creqDataDir . '/all-courses.xml');
		preg_match_all('#<subject>([A-Z]{3,4})</subject>#', $creqData, $matches, PREG_PATTERN_ORDER);
		$subjectCandidates = array_unique($matches[1]);
		$foundSubjects = array_keys(SubjectAreas::getMap());

		$this->assertEquals([], array_diff($subjectCandidates, $foundSubjects));
	}
}
