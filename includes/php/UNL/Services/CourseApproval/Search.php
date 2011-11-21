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
    function numberPrefixQuery($number)
    {
        return $this->driver->numberPrefixQuery($number);
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
    function getQueryResult($query, $offset = 0, $limit = null)
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
}