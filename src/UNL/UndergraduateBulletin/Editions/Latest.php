<?php
/**
 * This edition is slightly unique. COURSE data is pulled from the NEXT edition.
 * 
 * For example, during academic year 2010-2011 course data will be pulled from 
 * the (unfinalized) 2011-2012 edition. This allows the latest course data to be
 * displayed, while showing the finalized major requirements.
 * 
 * Also, the URL returned does not have a specific year in it.
 * 
 * @author bbieber
 */
class UNL_UndergraduateBulletin_Editions_Latest extends UNL_UndergraduateBulletin_Edition
{
    function getCourseDataDir()
    {
        return UNL_UndergraduateBulletin_Controller::getDataDir().DIRECTORY_SEPARATOR.((int)$this->year+1).DIRECTORY_SEPARATOR.'creq'; 
    }

    function getURL()
    {
        return UNL_UndergraduateBulletin_Controller::$url;
    }
}