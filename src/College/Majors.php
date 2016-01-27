<?php

namespace UNL\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\SelfIteratingJsonSerializationTrait;
use UNL\UndergraduateBulletin\Major\Majors as MajorCollection;

class Majors extends \FilterIterator implements
    \JsonSerializable
{
    use SelfIteratingJsonSerializationTrait;

    /**
     * The college
     *
     * @var College
     */
    protected $college;

    public function __construct($options = [])
    {
        if (!isset($options['college'])) {
            $options['college'] = new College($options);
        }

        $this->college = $options['college'];

        parent::__construct(new MajorCollection());
    }

    public function accept()
    {
        return $this->current()->getColleges()->relationshipExists($this->college->name);
    }

    public function __get($var)
    {
        if ($var == 'college') {
            return $this->getCollege();
        }

        throw new \Exception("There's no var with name: $var");
    }

    public function getCollege()
    {
        return $this->college;
    }
}
