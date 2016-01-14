<?php

namespace UNL\UndergraduateBulletin\CachingService;

/**
 * Interface cacheable objects must implement.
 *
 * @author bbieber
 */
interface CacheableInterface
{
    public function getCacheKey();
    public function run();
    public function preRun($fromCache, \Savvy $savvy);
}
