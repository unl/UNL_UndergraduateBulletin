<?php

namespace UNLTest\UndergraduateBulletin;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\Router;
use UNL\UndergraduateBulletin\Edition\Latest;

class RouterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getRouteProvider
	 */
	public function testGetRoute($requestURI, $expectedRoute, $queryString = '')
	{
		$_SERVER['QUERY_STRING'] = '';
		if ($queryString) {
			$_SERVER['QUERY_STRING'] = $queryString;
		}

		$route = Router::getRoute($requestURI);
		$this->assertEquals($expectedRoute, $route);
	}

	public function getRouteProvider()
	{
		$base = Controller::getURL();

		$specificYear = [];
		if (!Controller::getEdition() instanceof Latest) {
		    $specificYear = ['year' => Controller::getEdition()->getYear()];
		}

		return [
			[
				$base,
				$specificYear,
			],
			[
				Controller::getBaseURL() . 'developers/',
				['view' => 'developers'],
			],
			[
				$base . 'bulletinrules',
				$specificYear + ['view' => 'bulletinrules'],
			],
			[
				$base . 'college/',
				$specificYear + ['view' => 'colleges'],
			],
			[
				$base . 'college/Arts+%26+Sciences',
				$specificYear + ['view' => 'college', 'name' => 'Arts & Sciences'],
			],
			[
				$base . 'college/Arts+%26+Sciences/majors',
				$specificYear + ['view' => 'collegemajors', 'name' => 'Arts & Sciences'],
			],
			[
				$base . 'major/',
				$specificYear + ['view' => 'majors'],
			],
			[
				$base . 'major/search',
				$specificYear + ['view' => 'searchmajors'],
			],
			[
				$base . 'major/lookup',
				$specificYear + ['view' => 'majorlookup'],
			],
			[
				$base . 'major/Aerospace+Studies',
				$specificYear + ['view' => 'major', 'name' => 'Aerospace Studies'],
			],
			[
				$base . 'major/Aerospace/Studies',
				$specificYear + ['view' => 'major', 'name' => 'Aerospace/Studies'],
			],
			[
				$base . 'major/Aerospace+Studies/courses',
				$specificYear + ['view' => 'courses', 'name' => 'Aerospace Studies'],
			],
			[
				$base . 'courses/',
				$specificYear + ['view' => 'subjects'],
			],
			[
				$base . 'courses/search',
				$specificYear + ['view' => 'searchcourses'],
			],
			[
				$base . 'courses/search/?q=math%202',
				$specificYear + ['view' => 'searchcourses'],
				'q=math%202'
			],
			[
				$base . 'general',
				$specificYear + ['view' => 'general'],
			],
			[
				$base . 'editions',
				$specificYear + ['view' => 'editions'],
			],
			[
				$base . 'other/Policies',
				$specificYear + ['view' => 'otherarea', 'name' => 'Policies'],
			],
			[
				$base . 'courses/CSCE/',
				$specificYear + ['view' => 'subject', 'id' => 'CSCE'],
			],
			[
				$base . 'courses/CSCE/420',
				$specificYear + ['view' => 'course', 'subjectArea' => 'CSCE', 'courseNumber' => '420'],
			],
			[
				$base . 'unknownview',
				$specificYear + ['view' => 'no-route'],
			],
			[
				$base . 'book',
				$specificYear + ['view' => 'book', 'format' => 'print'],
			],
		];
	}
}
