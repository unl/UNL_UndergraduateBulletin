<?php

namespace UNL\UndergraduateBulletin\Developers;

use UNL\UndergraduateBulletin\Controller;

abstract class AbstractAction
{
    protected $title = '';

    protected $uri = '';

    protected $exampleURI  = '';

    protected $formats = [
        'json',
        'xml',
        'partial'
    ];

    protected $properties = [];

    public function __get($var)
    {
        $legacyPublic = [
            'title',
            'uri',
            'exampleURI',
            'formats',
            'properties',
        ];

        if (in_array($var, $legacyPublic)) {
            $method = 'get' . ucfirst($var);
            return $this->$method();
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUri(Controller $controller = null)
    {
        if ($controller) {
            return $controller::getURL() . $this->uri;
        }

        return Controller::getURL() . $this->uri;
    }

    public function getExampleURI(Controller $controller = null)
    {
        if ($controller) {
            return $controller::getURL() . $this->exampleURI;
        }

        return Controller::getURL() . $this->exampleURI;
    }

    public function getFormats()
    {
        return $this->formats;
    }

    public function getProperties()
    {
        return $this->properties;
    }
}
