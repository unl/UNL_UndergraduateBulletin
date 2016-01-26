<?php

namespace UNL\UndergraduateBulletin\CachingService;

/**
 * A caching service utilizing Cache_Lite
 *
 * @author bbieber
 */
class UNLCacheLite extends CacheLite
{
    public function __construct($options = array())
    {
        $this->options = array_merge($this->options, $options);
        $this->cache = new \UNL_Cache_Lite($this->options);
    }
}
