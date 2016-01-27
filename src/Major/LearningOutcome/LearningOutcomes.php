<?php

namespace UNL\UndergraduateBulletin\Major\LearningOutcome;

use UNL\UndergraduateBulletin\EPUB\Utilities;
use UNL\UndergraduateBulletin\Major\JsonLoadedDataTrait;

class LearningOutcomes extends \ArrayIterator
{
    use JsonLoadedDataTrait;

    const CONTENT_TYPE = 'outcomes';

    public $options = [];

    public function __construct($options = [])
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;

        $this->set($this->loadData());

        parent::__construct($this->data['concentrations']);
    }

    public function current()
    {
        return new Concentration(['id' => parent::current()]);
    }

    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}
