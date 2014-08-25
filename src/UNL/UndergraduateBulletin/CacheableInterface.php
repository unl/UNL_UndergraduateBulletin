<?php
/**
 * Interface cacheable objects must implement.
 * 
 * @author bbieber
 */
interface UNL_UndergraduateBulletin_CacheableInterface
{
    public function getCacheKey();
    public function run();
    public function preRun($fromCache, Savvy $savvy);
}
