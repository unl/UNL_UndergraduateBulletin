<?php

namespace UNL\UndergraduateBulletin\CachingService;

use UNL_Cache_Lite;

/**
 * A caching service utilizing Cache_Lite
 *
 * @author bbieber
 */
class UNLCacheLite implements CachingServiceInterface
{
    /**
     * UNL_Cache_Lite object
     *
     * @var UNL_Cache_Lite
     */
    protected $cache;

    public $options = array('lifeTime'=>604800); // One week cache time

    /**
     * Constructor
     */
    public function __construct($options = array())
    {
        $this->options = $options + $this->options;
        $this->cache = new UNL_Cache_Lite($this->options);
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
