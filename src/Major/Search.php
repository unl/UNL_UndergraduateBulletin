<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\SelfIteratingJsonSerializationTrait;
use UNL\UndergraduateBulletin\EPUB\Utilities;

class Search extends \ArrayIterator implements
    ControllerAwareInterface,
    \JsonSerializable
{
    use SelfIteratingJsonSerializationTrait;

    protected $controller;

    public $options = ['q' => ''];

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;

        $this->options['q'] = str_replace(
            ['..', DIRECTORY_SEPARATOR, '?', '*', '['],
            '',
            trim($this->options['q'])
        );

        // Replace a few special characters with wildcards
        $query = str_replace(array('\'', ' & ', ' and '), '*', $this->options['q']);

        // Now make sure we're case insensitive
        $query = preg_replace_callback('/([a-z])/i', [$this, 'replaceCallback'], $query);

        // Find matches on the filesystem
        $majors = glob(Controller::getEdition()->getDataDir().'/majors/*'.$query.'*.xhtml');

        // Find matching major aliases
        $aliases = Aliases::search($this->options['q']);

        foreach ($aliases as $key => $alias) {
            $aliases[$key] = Controller::getEdition()->getDataDir().'/majors/'.$alias.'.xhtml';
        }

        $majors = array_merge($majors, $aliases);
        usort($majors, function ($a, $b) {
            // trim .xhtml off the filename, then compare
            $a = substr($a, 0, -6);
            $b = substr($b, 0, -6);
            return $a > $b;
        });
        return parent::__construct(array_unique($majors));
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;

        if (count($this) === 1) {
            $major = $this->current();
            header('Location: ' . $major->getURL(), true, 302);
            exit;
        }

        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function current()
    {
        $name = Utilities::getNameByFile(parent::current());
        return new Major(['name'=>$name]);
    }

    protected function replaceCallback($matches)
    {
        return '['.strtolower($matches[0]).strtoupper($matches[0]).']';
    }
}
