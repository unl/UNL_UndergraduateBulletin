<?php

class UNL_UndergraduateBulletin_OutputController extends Savvy
{
    
    static protected $cache;
    
    static public $defaultExpireTimestamp = null;
    
    function __construct($options = array())
    {
        parent::__construct();
    }
    
    protected static function basicOutputController($context, $parent, $file, $savvy)
    {
        try {
            return parent::basicOutputController($context, $parent, $file, $savvy);
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }
    }
    
    static public function setCacheInterface(UNL_UndergraduateBulletin_CacheInterface $cache)
    {
        self::$cache = $cache;
    }
    
    /**
     * get the cache interface
     * @return UNL_UndergraduateBulletin_CacheInterface
     */
    static public function getCacheInterface()
    {
        if (!isset(self::$cache)) {
            self::setCacheInterface(new UNL_UndergraduateBulletin_CacheInterface_UNLCacheLite());
        }
        return self::$cache;
    }
    
    static public function setDefaultExpireTimestamp($timestamp)
    {
        self::$defaultExpireTimestamp = $timestamp;
    }
    
    static public function getDefaultExpireTimestamp()
    {
        return self::$defaultExpireTimestamp;
    }
    
    protected function getRawObject($object)
    {
        $rawObject = $object;
        if ($rawObject instanceof Savvy_ObjectProxy) {
            $rawObject = $object->getRawObject();
        }
        
        return $rawObject;
    }
    
    protected function getCacheKey(UNL_UndergraduateBulletin_CacheableInterface $object)
    {
        $key = $object->getCacheKey();
        
        if ($key === false) {
            return false;
        }
        
        $key .= UNL_UndergraduateBulletin_Controller::getEdition()->getCacheKey();
        
        return $key;
    }
    
    protected function loadCache($object)
    {
        $cacheObject = $this->getRawObject($object);
        if (!($cacheObject instanceof UNL_UndergraduateBulletin_CacheableInterface)) {
            return false;
        }
        
        $key = $this->getCacheKey($cacheObject);
        if ($key === false) {
            return false;
        }
        
        $data = self::getCacheInterface()->get($key);
        
        if ($data !== false) {
            $cacheObject->preRun(true);
        } else {
            $cacheObject->preRun(false);
            $cacheObject->run();
        }
        
        return $data;
    }
    
    protected function saveCache($object, $data)
    {
        $cacheObject = $this->getRawObject($object); 
        if (!($cacheObject instanceof UNL_UndergraduateBulletin_CacheableInterface)) {
            return;
        }
        
        $key = $this->getCacheKey($cacheObject);
        if ($key === false) {
            return;
        }
        
        self::getCacheInterface()->save($data, $key);
    }
    
    public function renderObject($object, $template = null)
    {
        $rawObject = $this->getRawObject($object);
        $data = $this->loadCache($object);
        if ($data === false) {
            $data = parent::renderObject($object, $template);
        
            if ($rawObject instanceof UNL_UndergraduateBulletin_PostRunReplacements) {
                $data = $rawObject->postRun($data);
            }
            
            $this->saveCache($object, $data);
        }
        return $data;
    }
    
    protected function fetch($mixed, $template = null)
    {
        try {
            return parent::fetch($mixed, $template);
        } catch (Savvy_Exception $e) {
            throw $e;
        } catch (Exception $e) {
            array_pop($this->templateStack);
            throw $e;
        }
    }
    
    /**
     * 
     * @param timestamp $expires timestamp
     * 
     * @return void
     */
    function sendCORSHeaders($expires = null)
    {
        // Specify domains from which requests are allowed
        header('Access-Control-Allow-Origin: *');

        // Specify which request methods are allowed
        header('Access-Control-Allow-Methods: GET, OPTIONS');

        // Additional headers which may be sent along with the CORS request
        // The X-Requested-With header allows jQuery requests to go through

        header('Access-Control-Allow-Headers: X-Requested-With');

        // Set the ages for the access-control header to 20 days to improve speed/caching.
        header('Access-Control-Max-Age: 1728000');

        if (isset($expires)) {
            // Set expires header for 24 hours to improve speed caching.
            header('Expires: '.date('r', $expires));
        }
    }
}

