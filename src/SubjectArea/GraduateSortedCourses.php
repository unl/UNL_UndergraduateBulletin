<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

class GraduateSortedCourses extends \ArrayIterator
{
    public function __construct(\Traversable $courses)
    {
        $coursesArray = iterator_to_array($courses);
        uasort($coursesArray, function($a, $b) {
            $aListing = $a->getRenderListing();
            $bListing = $b->getRenderListing();

            $aLastGradListing = $aListing->getCourseNumber();
            $bLastGradListing = $bListing->getCourseNumber();

            foreach ($aListing->getListingsFromSubject() as $listing) {
                if ($listing->getCourseNumber() >= 500) {
                    $aLastGradListing = $listing->getCourseNumber();
                }
            }

            foreach ($bListing->getListingsFromSubject() as $listing) {
                if ($listing->getCourseNumber() >= 500) {
                    $bLastGradListing = $listing->getCourseNumber();
                }
            }

            if ($aLastGradListing == $bLastGradListing) {
                return 0;
            }

            return $aLastGradListing < $bLastGradListing ? -1 : 1;
        });

        parent::__construct($coursesArray);
    }
}
