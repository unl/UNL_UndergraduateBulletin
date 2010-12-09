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
        $aliases = UNL_UndergraduateBulletin_MajorAliases::getAliases();
        $keys = array_keys($aliases);
        $i = 0;
        foreach ($aliases as $sub) {
            foreach ($sub as $value) {
                if ($value == strtolower($query)) {
                    return $keys[$i];
                }
            }
            $i++;
        }
        return false;
    }
}
