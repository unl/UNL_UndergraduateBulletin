<?php
class UNL_UndergraduateBulletin_Router
{
    public static function getRoute()
    {
        $requestURI = $_SERVER['REQUEST_URI'];

        if (!empty($_SERVER['QUERY_STRING'])) {
            $requestURI = substr($requestURI, 0, strlen($_SERVER['QUERY_STRING'])*-1-1);
        }

        $base = preg_quote(UNL_UndergraduateBulletin_Controller::getURL(), '/');

        $options = array();

        switch(true) {
            case preg_match('/'.$base.'courses\/$/', $requestURI, $matches):
                $options['view'] = 'subjects';
                break;
            // Subject Code: ex CSCE/
            case preg_match('/'.$base.'courses\/([A-Z]{3,4})\/$/', $requestURI, $matches):
                $options['view'] = 'subject';
                $options['id']   = $matches[1];
                break;
            // Course rewrites, ex: CSCE/420
            case preg_match('/'.$base.'courses\/([A-Z]{3,4})\/([\d]?[\d]{2,3}[A-Za-z]?)$/', $requestURI, $matches):
                $options['view']       = 'course';
                $options['subject_id'] = $matches[1];
                $options['number']     = $matches[2];
                break;
            // List of all majors
            case preg_match('/'.$base.'majors?\/?$/', $requestURI, $matches):
                $options['view'] = 'majors';
                break;
            // Individual major major/Architecture
            case preg_match('/'.$base.'major\/([^\/]+)$/', $requestURI, $matches):
                $options['view'] = 'major';
                $options['name'] = urldecode($matches[1]);
                break;
            case preg_match('/'.$base.'major\/([^\/]+)\/courses$/', $requestURI, $matches):
                $options['view'] = 'courses';
                $options['name'] = urldecode($matches[1]);
                break;
            case preg_match('/'.$base.'college\/(.*)/', $requestURI, $matches):
                $options['view'] = 'college';
                $options['name'] = urldecode($matches[1]);
                break;
            // Index page
            case preg_match('/'.$base.'$/', $requestURI, $matches):
                break;
            default:
                throw new Exception('Unknown route');
                break;
        }
        return $options;
    }
}