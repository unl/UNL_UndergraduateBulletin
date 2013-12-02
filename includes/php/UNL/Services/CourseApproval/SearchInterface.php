<?php
abstract class UNL_Services_CourseApproval_SearchInterface
{
    abstract function aceQuery($ace = null);
    abstract function subjectAndNumberQuery($subject, $number, $letter = null);
    abstract function subjectAndNumberPrefixQuery($subject, $number);
    abstract function subjectAndNumberSuffixQuery($subject, $number);
    abstract function numberPrefixQuery($number);
    abstract function numberSuffixQuery($number);
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

    public function byTitle($query, $offset = 0, $limit = -1)
    {
        $query = $this->titleQuery($this->filterQuery($query));

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function byNumber($query, $offset = 0, $limit = -1)
    {
        $query = $this->numberQuery($this->filterQuery($query));

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function bySubject($query, $offset = 0, $limit = -1)
    {
        $query = $this->subjectAreaQuery($this->filterQuery($query));

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function byPrerequisite($query, $offset = 0, $limit = -1)
    {
        $query = $this->prerequisiteQuery($query);

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function graduateCourses($offset = 0, $limit = -1)
    {
        $query = $this->graduateQuery();

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function undergraduateCourses($offset = 0, $limit = -1)
    {
        $query = $this->undergraduateQuery();

        return $this->getQueryResult($query, $offset, $limit);
    }

    public function byMany($queries = array(), $offset = 0, $limit = -1)
    {
        $query = $this->determineQuery(array_shift($queries));

        foreach ($queries as $sub_query) {
             $query = $this->intersectQuery($query, $this->determineQuery($sub_query));
        }

        return $this->getQueryResult($query, $offset, $limit);
    }

    /**
     * Helper method to determine the appropriate query based on an input string
     *
     * @return string
     */
    public function determineQuery($query)
    {
        $query = $this->filterQuery($query);

        $driver = $this;

        $facets = array(
                // Credit search
                '/([\d]+)\scredits?/i'                         => 'creditQuery',

                // ACE outcome number
                '/ace\s*:?\s*(10|[1-9])/i'                     => 'aceQuery',

                // ACE course
                '/ace/i'                                       => 'aceQuery',

                // ACE course, and number range, eg: ACE 2XX
                '/ace\s*:?\s*([0-9])(X+|\*+)/i'                => 'aceAndNumberPrefixQuery',

                // Course subject code and number
                '/([A-Z]{3,4})\s+([\d]?[\d]{2,3})([A-Z])?:?/i' => function($matches) use ($driver) {

                        $subject = strtoupper($matches[1]);
                        $letter = null;
                        if (isset($matches[3])) {
                            $letter = $matches[3];
                        }
                        return $driver->subjectAndNumberQuery($subject, $matches[2], $letter);
                    },

                // Course subject and number range, eg: MRKT 3XX
                '/([A-Z]{3,4})\s+([0-9])(X+|\*+)?/i'         => function($matches) use ($driver) {
                        $subject = strtoupper($matches[1]);

                        return $driver->subjectAndNumberPrefixQuery($subject, $matches[2]);
                    },

                // Course subject and number suffix, eg: MUDC *41
                '/([A-Z]{3,4})\s+(X+|\*+)([0-9]+)/i'         => function($matches) use ($driver) {
                        $subject = strtoupper($matches[1]);

                        return $driver->subjectAndNumberSuffixQuery($subject, $matches[3]);
                    },

                '/([\d]?[\d]{2,3})([A-Z])?(\*+)?/i'          => function($matches) use ($driver) {
                        $letter = null;
                        if (isset($matches[2])) {
                            $letter = $matches[2];
                        }
                        return $driver->numberQuery($matches[1], $letter);
                    },

                '/([0-9])(X+|\*+)?/i'                        => 'numberPrefixQuery',
                '/(X+|\*+)([0-9]+)?/i'                       => 'numberSuffixQuery',
                '/([A-Z]{3,4})(\s*:\s*.*)?(\s[Xx]+|\s\*+)?/' => 'subjectAreaQuery',
                '/honors/i'                                  => 'honorsQuery',
                '/(.*)/'                                     => 'titleQuery',
                );

        $queries = array();

        foreach ($facets as $regex => $method) {
            if (preg_match($regex, $query, $matches)) {
                if ($method instanceof Closure) {
                    $queries[] = call_user_func($method, $matches);
                } else {

                    $param = null;
                    if (isset($matches[1])) {
                        $param = $matches[1];
                    }
                    $queries[] = call_user_func(array($this, $method), $param);
                }

                // Pull this search facet off the query and continue
                $query = trim(str_replace($matches[0], '', $query));

                if ($query == '') {
                    break;
                }
            }
        }

        $query = array_shift($queries);

        foreach ($queries as $sub_query) {
             $query = $this->intersectQuery($query, $sub_query);
        }

        return $query;
    }

    public function byAny($query, $offset = 0, $limit = -1)
    {
        $query = $this->determineQuery($query);

        return $this->getQueryResult($query, $offset, $limit);
    }

    abstract function getQueryResult($query, $offset = 0, $limit = -1);
}