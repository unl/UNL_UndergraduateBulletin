<?php
class UNL_UndergraduateBulletin_Router
{
    public static function getRoute($requestURI)
    {

        if (!empty($_SERVER['QUERY_STRING'])) {
            $requestURI = substr($requestURI, 0, -strlen(urldecode($_SERVER['QUERY_STRING'])) - 1);
        }
        // Trim the base part of the URL
        $requestURI = substr($requestURI, strlen(UNL_UndergraduateBulletin_Controller::getBaseURL()));
        $options = array();

        if (preg_match('/^([\d]{4})$/', $requestURI, $matches)) {
            // No trailing slash, add it in for this lazy visitor
            header('Location: '.UNL_UndergraduateBulletin_Controller::getBaseURL().$matches[0].'/');
            exit();
        }

        if (preg_match('/^([\d]{4})\//', $requestURI, $matches)) {
            // The URL contains an edition number
            $options['year'] = $matches[1];

            // Trim the year off
            $requestURI = substr($requestURI, strlen($matches[0]));
        }

        if (empty($requestURI)) {
            // Default view/homepage
            return $options;
        }

        switch(true) {
            case preg_match('/^developers\/?$/', $requestURI):
                $options['view'] = 'developers';
                break;
            case preg_match('/^courses\/$/', $requestURI, $matches):
                $options['view'] = 'subjects';
                break;
            case preg_match('/^courses\/search\/?$/', $requestURI, $matches):
                $options['view'] = 'searchcourses';
                break;
            // Subject Code: ex CSCE/
            case preg_match('/^courses\/([A-Z]{3,4})\/?$/', $requestURI, $matches):
                $options['view'] = 'subject';
                $options['id']   = $matches[1];
                break;
            // Course rewrites, ex: CSCE/420
            case preg_match('/^courses\/([A-Z]{3,4})\/([\d]?[\d]{2,3}[A-Za-z]?)$/', $requestURI, $matches):
                $options['view']         = 'course';
                $options['subjectArea']  = $matches[1];
                $options['courseNumber'] = $matches[2];
                break;
            // List of all majors
            case preg_match('/^majors?\/?$/', $requestURI, $matches):
                $options['view'] = 'majors';
                break;
            // Search majors
            case preg_match('/^majors?\/search\/?$/', $requestURI, $matches):
                $options['view'] = 'searchmajors';
                break;
            case preg_match('/^major\/(.+)\/courses$/', $requestURI, $matches):
                $options['view'] = 'courses';
                $options['name'] = urldecode($matches[1]);
                break;
            // Individual major major/Architecture
            case preg_match('/^major\/(.+)\/?$/', $requestURI, $matches):
                $options['view'] = 'major';
                $options['name'] = urldecode($matches[1]);
                break;
            case preg_match('/^college\/?$/', $requestURI):
                $options['view'] = 'colleges';
                break;
            case preg_match('/^college\/(.*)/', $requestURI, $matches):
                $options['view'] = 'college';
                $options['name'] = urldecode($matches[1]);
                break;
            case preg_match('/^bulletinrules\/?$/', $requestURI, $matches):
                $options['view'] = 'bulletinrules';
                break;
            case preg_match('/^search\/?$/', $requestURI):
                $options['view'] = 'search';
                break;
            case preg_match('/^about\/?$/', $requestURI):
                $options['view'] = 'about';
                break;
            case preg_match('/^general\/?$/', $requestURI):
                $options['view'] = 'general';
                break;
            case preg_match('/^editions\/?$/', $requestURI):
                $options['view'] = 'editions';
                break;
            default:
                throw new Exception('Unknown route: '.$requestURI, 404);
        }
        return $options;
    }
}