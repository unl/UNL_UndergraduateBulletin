<?php
class UNL_UndergraduateBulletin_MajorAliases
{
    function __construct($options = array())
    {

    }
    
    static function getAliases()
    {
        $json = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/major_aliases.json');
        $aliases = json_decode($json, true);
        return $aliases;
    }
    
    static function search($query)
    {
        $aliases = self::getAliases();
        
        if (array_key_exists($query, $aliases)) {
            return $aliases[$query];
        }
        return array();
    }
}
