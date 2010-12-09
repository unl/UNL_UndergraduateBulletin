<?php
class UNL_UndergraduateBulletin_MajorAliases
{
    function __construct($options = array())
    {

    }
    
    static function getAliases()
    {
        $aliases = array();
        $currentMajor = null;

        $handle = @fopen(UNL_UndergraduateBulletin_Controller::getDataDir()."/major_aliases.txt", "r");
        if ($handle) {
            //Loop though the file, line by line.
            while (($buffer = fgets($handle)) !== false) {
                if (empty($currentMajor) && $buffer != "\n") {
                    //A new major was found.  Set the currentMajor to the new one.
                    $currentMajor = trim($buffer);
                } else if ($buffer == "\n"){
                    //A the last group of aliases has ended. chaning major...
                    $currentMajor = null;
                } else {
                    //add the current aliases to the list for the major.
                    $aliases[$currentMajor][] = strtolower(trim($buffer));
                }
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail<br>";
            }
            fclose($handle);
        }
        return $aliases;
    }
    
    static function search($query)
    {
        $official_major_names = UNL_UndergraduateBulletin_MajorAliases::getAliases();
        foreach ($official_major_names as $official_name=>$aliases) {
            foreach ($aliases as $key=>$alias) {
                if ($alias == strtolower($query)) {
                    return $official_name;
                }
            }
        }
        return false;
    }
}
