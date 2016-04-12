<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;

class Lookup extends \ArrayIterator implements
    ControllerAwareInterface,
    \JsonSerializable
{
    protected $controller;

    protected $options;

    public function __construct($options = [])
    {
        $this->options = $options;
        $mapping = file_get_contents(Controller::getEdition()->getDataDir().'/major_lookup.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new \Exception('Invalid acad plan to major matching file.', 500);
        }

        parent::__construct($mapping);
    }

    public function setController(Controller $controller)
    {
        if (isset($this->options['redirectToSelf']) && true === $this->options['redirectToSelf']) {
            header('Location: ' . $this->getUrl($controller), true, 302);
            exit();
        }

        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }

    public function getUrl(Controller $controller = null)
    {
        $suffixFormats = [
            'json',
            'xml',
            'partial',
        ];
        $format = isset($this->options['format']) ? $this->options['format'] : false;
        $path = 'major/lookup';
        $pathSuffix = '/';

        if ($format && in_array($format, $suffixFormats, true)) {
            $pathSuffix = '.' . $format;
        }

        if ($controller) {
            return $controller::getURL() . $path . $pathSuffix;
        }

        return Controller::getURL() . $path . $pathSuffix;
    }
}
