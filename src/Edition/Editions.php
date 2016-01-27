<?php

namespace UNL\UndergraduateBulletin\Edition;

class Editions extends \ArrayIterator implements
    \JsonSerializable
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

    public function __construct($options = [])
    {
        return parent::__construct(static::$editions);
    }

    /**
     * Gets an array of all the editions from the latest edition.
     *
     * @return self The list of editions.
     */
    public static function getAll()
    {
        return new self();
    }

    public static function getPublished()
    {
        return new PublishedFilter(new self());
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

    public function jsonSerialize()
    {
        return static::$editions;
    }
}
