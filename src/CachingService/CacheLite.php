<?php

namespace UNL\UndergraduateBulletin\CachingService;

use Cache_Lite;

/**
 * A caching service utilizing Cache_Lite
 *
 * @author bbieber
 */
class CacheLite implements CachingServiceInterface
{
    /**
     * Cache_Lite object
     *
     * @var Cache_Lite
     */
    protected $cache;

    public $options = array('lifeTime'=>604800); // One week cache time

    /**
     * Constructor
     */
    public function __construct($options = array())
    {
        $this->options = array_merge($this->options, $options);
        $this->cache = new Cache_Lite($this->options);
    }

    /**
     * Get an item stored in the cache
     */
    public function get($key)
    {
        return $this->cache->get($key, 'UndergraduateBulletin');
    }

    /**
     * Save an element to the cache
     */
    public function save($data, $key)
    {
        return $this->cache->save($data, $key, 'UndergraduateBulletin');
    }
}
