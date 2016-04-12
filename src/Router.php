<?php

namespace UNL\UndergraduateBulletin;

class Router
{
    public static function getRoute($requestURI, $baseUrl = '')
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            $requestURI = substr($requestURI, 0, -strlen($_SERVER['QUERY_STRING']) - 1);
        }

        if (!$baseUrl) {
            $baseUrl = Controller::getBaseURL();
        }

        // Trim the base part of the URL
        $requestURI = substr($requestURI, strlen(parse_url($baseUrl, PHP_URL_PATH)));
        $options = [];

        if (preg_match('/^([\d]{4})$/', $requestURI, $matches)) {
            // No trailing slash, add it in for this lazy visitor
            header('Location: ' . Controller::getBaseURL() . $matches[0] . '/');
            exit();
        } elseif (preg_match('/^developers\/?$/', $requestURI)) {
            // Developers is not edition specific
            $options['view'] = 'developers';
            return $options;
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

        switch (true) {
            case preg_match('/^book\/?$/', $requestURI):
                $options['view'] = 'book';
                $options['format'] = 'print';
                break;
            case preg_match('/^courses(\.(?P<format>\w+)|\/)?$/', $requestURI, $matches):
                $options['view'] = 'subjects';

                if (empty($matches[1]) || (!empty($matches['format']) && $matches['format'] === 'html')) {
                    $options['redirectToSelf'] = true;
                }

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            case preg_match('/^courses\/search\/?$/', $requestURI, $matches):
                $options['view'] = 'searchcourses';
                break;
            // Subject Code: ex CSCE/
            case preg_match('/^courses\/([A-Z]{3,4})(\.(?P<format>\w+)|\/)?$/', $requestURI, $matches):
                $options['view'] = 'subject';
                $options['id']   = $matches[1];

                if (empty($matches[2]) || (!empty($matches['format']) && $matches['format'] === 'html')) {
                    $options['redirectToSelf'] = true;
                }

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            // Course rewrites, ex: CSCE/420
            case preg_match(
                '/^courses\/([A-Z]{3,4})\/([\d]?[\d]{2,3}[A-Za-z]?)(\.(?P<format>\w+))?$/',
                $requestURI,
                $matches
            ):
                $options['view']         = 'course';
                $options['subjectArea']  = $matches[1];
                $options['courseNumber'] = $matches[2];

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            // List of all majors
            case preg_match('/^majors?(\.(?P<format>\w+)|\/)?$/', $requestURI, $matches):
                $options['view'] = 'majors';

                if (empty($matches[1]) || (!empty($matches['format']) && $matches['format'] === 'html')) {
                    $options['redirectToSelf'] = true;
                }

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            case preg_match('/^majors?\/lookup(\.(?P<format>\w+)|\/)?$/', $requestURI, $matches):
                $options['view'] = 'majorlookup';

                if (empty($matches[1]) || (!empty($matches['format']) && $matches['format'] === 'html')) {
                    $options['redirectToSelf'] = true;
                }

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            // Search majors
            case preg_match('/^majors?\/search\/?$/', $requestURI, $matches):
                $options['view'] = 'searchmajors';
                break;
            case preg_match(
                '/^major\/(.+)\/(courses|plans|outcomes)(\.(?P<format>\w+))?$/',
                $requestURI,
                $matches
            ):
                $options['view'] = $matches[2];
                $options['name'] = urldecode($matches[1]);

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            // Individual major major/Architecture
            case preg_match('/^major\/(.+?)(\.(?P<format>\w+)|\/)?$/', $requestURI, $matches):
                $options['view'] = 'major';
                $options['name'] = urldecode($matches[1]);

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            case preg_match('/^college(\.(?P<format>\w+)|\/)?$/', $requestURI, $matches):
                $options['view'] = 'colleges';

                if (empty($matches[1]) || (!empty($matches['format']) && $matches['format'] === 'html')) {
                    $options['redirectToSelf'] = true;
                }

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            case preg_match('/^college\/(.*)\/majors(\.(?P<format>\w+))?$/', $requestURI, $matches):
                $options['view'] = 'collegemajors';
                $options['name'] = urldecode($matches[1]);

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            case preg_match('/^college\/(.+?)(\.(?P<format>\w+))?$/', $requestURI, $matches):
                $options['view'] = 'college';
                $options['name'] = urldecode($matches[1]);

                if (!empty($matches['format'])) {
                    $options['format'] = $matches['format'];
                }
                break;
            case preg_match('/^other\/(.+)$/', $requestURI, $matches):
                $options['view'] = 'otherarea';
                $options['name'] = urldecode($matches[1]);
                break;
            case preg_match('/^bulletinrules\/?$/', $requestURI, $matches):
                $options['view'] = 'bulletinrules';
                break;
            case preg_match('/^general\/?$/', $requestURI):
                $options['view'] = 'general';
                break;
            case preg_match('/^editions\/?$/', $requestURI):
                $options['view'] = 'editions';
                break;
            default:
                $options['view'] = 'no-route';
        }
        return $options;
    }
}
