<?php
abstract class UNL_Services_CourseApproval_SearchInterface
{
    abstract function aceQuery($ace);
    abstract function subjectAndNumberQuery($subject, $number, $letter = null);
    abstract function subjectAndNumberPrefixQuery($subject, $number);
    abstract function numberPrefixQuery($number);
    abstract function honorsQuery();
    abstract function titleQuery($title);
    abstract function subjectAreaQuery($subject);
    abstract function numberQuery($number, $letter = null);
    abstract function creditQuery($credits);
    abstract function prerequisiteQuery($prereq);
    abstract function intersectQuery($query1, $query2);
    abstract function graduateQuery();
    abstract function undergraduateQuery();

    function filterQuery($query)
    {
        return trim($query);
    }

    public function byTitle($query, $offset = 0, $limit = null)
    {
        $query = $this->titleQuery($this->filterQuery($query));

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function byNumber($query, $offset = 0, $limit = null)
    {
        $query = $this->numberQuery($this->filterQuery($query));

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function bySubject($query, $offset = 0, $limit = null)
    {
        $query = $this->subjectAreaQuery($this->filterQuery($query));

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function byPrerequisite($query, $offset = 0, $limit = null)
    {
        $query = $this->prerequisiteQuery($query);

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function graduateCourses($offset = 0, $limit = null)
    {
        $query = $this->graduateQuery();

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function undergraduateCourses($offset = 0, $limit = null)
    {
        $query = $this->undergraduateQuery();

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function byAny($query, $offset = 0, $limit = null)
    {
        $query = $this->filterQuery($query);

        switch (true) {
            case preg_match('/([\d]+)\scredits?/i', $query, $match):
                // Credit search
                $query = $this->creditQuery($match[1]);
                break;
            case preg_match('/^ace\s*:?\s*([0-9])(X+|\*+)/i', $query, $matches):
                // ACE course, and number range, eg: ACE 2XX
                $query = $this->aceAndNumberPrefixQuery($matches[1]);
                break;
            case preg_match('/^ace\s*:?\s*(10|[1-9])$/i', $query, $match):
                // ACE outcome number
                $query = $this->aceQuery($match[1]);
                break;
            case preg_match('/^([A-Z]{3,4})\s+([0-9])(X+|\*+)?$/i', $query, $matches):
                // Course subject and number range, eg: MRKT 3XX
                $subject = strtoupper($matches[1]);

                $query = $this->subjectAndNumberPrefixQuery($subject, $matches[2]);
                break;
            case preg_match('/^([A-Z]{3,4})\s+([\d]?[\d]{2,3})([A-Z])?:?.*$/i', $query, $matches):
                // Course subject code and number
                $subject = strtoupper($matches[1]);
                $letter = null;
                if (isset($matches[3])) {
                    $letter = $matches[3];
                }
                $query = $this->subjectAndNumberQuery($subject, $matches[2], $letter);
                break;
            case preg_match('/^([0-9])(X+|\*+)?$/i', $query, $match):
                // Course number range
                $query = $this->numberPrefixQuery($match[1]);
                break;
            case preg_match('/^([\d]?[\d]{2,3})([A-Z])?(\*+)?$/i', $query, $matches):

                $letter = null;
                if (isset($matches[2])) {
                    $letter = $matches[2];
                }
                $query = $this->numberQuery($matches[1], $letter);
                break;
            case preg_match('/^([A-Z]{3,4})(\s*:\s*.*)?(\s[Xx]+|\s\*+)?$/', $query, $matches):
                // Subject code search
                $query = $this->subjectAreaQuery($matches[1]);
                break;
            case preg_match('/^honors$/i', $query):
                $query = $this->honorsQuery();
                break;
            default:
                // Do a title text search
                $query = $this->titleQuery($query);
        }

        return $this->getQueryResult($query, $offset, $limit);
    }

    abstract function getQueryResult($query, $offset = 0, $limit = null);
}