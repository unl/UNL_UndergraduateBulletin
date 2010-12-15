<?php
class UNL_UndergraduateBulletin_Editions
{
    public static $editions = array(2010 => 'http://bulletin.unl.edu/undergraduate/2010/');
    
    /**
     * Gets an array of all the editions from the latest edition.
     * 
     * @return array.. The list of editions.
     */
    static function getAll()
    {
        static $editions_checked = false;
        //Only try to get the editions array once.
        if (!$editions_checked) {
            if (UNL_UndergraduateBulletin_Controller::isArchived()) {
                //edition is not newest, call the newest for the complete list of editions.
                if ($json = @file_get_contents(UNL_UndergraduateBulletin_Controller::$newest_url.'editions/?format=json')) {
                    self::$editions = json_decode($json, true);
                }
            }
            //edition is the newest, use our own list of editions.
        }
        $editions_checked = true;
        return self::$editions;
    }
}