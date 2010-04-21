<?php

class UNL_UndergraduateBulletin_OutputController extends Savvy
{
    
    static protected $cache;
    
    function __construct($options = array())
    {
        parent::__construct();
    }
    
    static public function setCacheInterface(UNL_UndergraduateBulletin_CacheInterface $cache)
    {
        self::$cache = $cache;
    }
    
    static public function getCacheInterface()
    {
        if (!isset(self::$cache)) {
            self::setCacheInterface(new UNL_UndergraduateBulletin_CacheInterface_CacheLite());
        }
        return self::$cache;
    }
    
    public function renderObject($object, $template = null)
    {
        if ($object instanceof UNL_UndergraduateBulletin_CacheableInterface) {
            $key = $object->getCacheKey();
            
            // We have a valid key to store the output of this object.
            if ($key !== false && $data = self::getCacheInterface()->get($key)) {
                // Tell the object we have cached data and will output that.
                $object->preRun(true);
            } else {
                // Content should be cached, but none could be found.
                //flush();
                ob_start();
                $object->preRun(false);
                $object->run();
                
                $data = parent::renderObject($object, $template);
                
                if ($key !== false) {
                    self::getCacheInterface()->save($data, $key);
                }
                ob_end_clean();
            }
            
            if ($object instanceof UNL_UndergraduateBulletin_PostRunReplacements) {
                $data = $object->postRun($data);
            }
            
            return $data;
        }
        
        return parent::renderObject($object, $template);

    }
}

