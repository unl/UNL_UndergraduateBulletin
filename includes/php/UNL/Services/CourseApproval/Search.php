<?php
class UNL_Services_CourseApproval_Search extends UNL_Services_CourseApproval_SearchInterface
{
    /**
     * The driver that performs the searches
     * @var UNL_Services_CourseApproval_SearchInterface
     */
    public $driver;

    function __construct(UNL_Services_CourseApproval_SearchInterface $driver = null)
    {
        if (!isset($driver)) {
            $this->driver = new UNL_Services_CourseApproval_SearchInterface_XPath();
        } else {
            $this->driver = $driver;
        }
    }

    /**
     * Combine two queries into one which will return the intersect
     *
     * @return string
     */
    function intersectQuery($query1, $query2)
    {
        return $this->driver->intersectQuery($query1, $query2);
    }

    function aceQuery($ace)
    {
        return $this->driver->aceQuery($ace);
    }
    function aceAndNumberPrefixQuery($number)
    {
        return $this->driver->aceAndNumberPrefixQuery($number);
    }
    function subjectAndNumberQuery($subject, $number, $letter = null)
    {
        return $this->driver->subjectAndNumberQuery($subject, $number, $letter);
    }
    function subjectAndNumberPrefixQuery($subject, $number)
    {
        return $this->driver->subjectAndNumberPrefixQuery($subject, $number);
    }
    function subjectAndNumberSuffixQuery($subject, $number)
    {
        return $this->driver->subjectAndNumberSuffixQuery($subject, $number);
    }
    function numberPrefixQuery($number)
    {
        return $this->driver->numberPrefixQuery($number);
    }
    function numberSuffixQuery($number)
    {
        return $this->driver->numberSuffixQuery($number);
    }
    function honorsQuery()
    {
        return $this->driver->honorsQuery();
    }
    function titleQuery($title)
    {
        return $this->driver->titleQuery($title);
    }
    function subjectAreaQuery($subject)
    {
        return $this->driver->subjectAreaQuery($subject);
    }
    function getQueryResult($query, $offset = 0, $limit = -1)
    {
        return $this->driver->getQueryResult($query, $offset, $limit);
    }
    function numberQuery($number, $letter = null)
    {
        return $this->driver->numberQuery($number, $letter);
    }
    function creditQuery($credits)
    {
        return $this->driver->creditQuery($credits);
    }
    function prerequisiteQuery($prereq)
    {
        return $this->driver->prerequisiteQuery($prereq);
    }
    function undergraduateQuery()
    {
        return $this->driver->undergraduateQuery();
    }
    function graduateQuery()
    {
        return $this->driver->graduateQuery();
    }
}