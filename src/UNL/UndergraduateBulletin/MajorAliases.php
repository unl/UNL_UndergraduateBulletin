<?php
class UNL_UndergraduateBulletin_MajorAliases
{
    function __construct($options = array())
    {

    }

    /**
     * Get all the major aliases for this edition of the bulletin
     * 
     * @return array('alias'=>array('Major1', 'Major2'))
     */
    static function getAliases()
    {
        if ($json = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/major_aliases.json')) {
            $aliases = json_decode($json, true);
            return $aliases;
        }

        return array();
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
