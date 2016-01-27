<?php

namespace UNL\UndergraduateBulletin\Major\FourYearPlan;

use UNL\UndergraduateBulletin\EPUB\Utilities;
use UNL\UndergraduateBulletin\Major;
use UNL\UndergraduateBulletin\Major\JsonLoadedDataTrait;

class FourYearPlans extends \ArrayIterator implements
    \JsonSerializable
{
    use JsonLoadedDataTrait;

    const CONTENT_TYPE = 'fouryearplans';

    public $options = [];

    public function __construct($options = [])
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;

        $this->set($this->loadData());

        // Sort the concentrations alphabetically
        ksort($this->data['concentrations']);

        parent::__construct($this->data['concentrations']);
    }

    /**
     * Get the major associated with this plan
     *
     * @return UNL_UndergraduateBulletin_Major
     */
    public function getMajor()
    {
        return Major::getByName($this->title);
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
