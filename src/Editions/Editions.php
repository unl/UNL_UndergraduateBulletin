<?php

namespace UNL\UndergraduateBulletin\Editions;

class Editions extends \ArrayIterator
{
    public static $editions = [
        2016,
        2015,
        2014,
        2013,
        2012,
        2011,
        2010,
    ];

    /**
     * The last bulletin edition that was complete.
     *
     * @var string|int
     */
    public static $latest = 2015;

    public $options = ['format'=>'html'];

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;
        return parent::__construct(static::$editions);
    }

    /**
     * Gets an array of all the editions from the latest edition.
     *
     * @return UNL_UndergraduateBulletin_Editions The list of editions.
     */
    public static function getAll()
    {
        return new static();
    }

    public static function getPublished()
    {
        return new PublishedFilter(new static());
    }

    /**
     * Get the latest edition
     *
     * @return Edition
     */
    public static function getLatest()
    {
        return new Latest(['year' => static::$latest]);
    }

    /**
     * Get the current edition
     *
     * @return Edition
     */
    public function current()
    {
        return new Edition(['year' => parent::current()]);
    }
}
