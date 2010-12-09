<?php 
$aliases = array();
$currentMajor = null;

$handle = @fopen("major_aliases.txt", "r");
if ($handle) {
    //Loop though the file, line by line.
    while (($buffer = fgets($handle)) !== false) {
        if (empty($currentMajor) && $buffer != "\n") {
            //A new major was found.  Set the currentMajor to the new one.
            $currentMajor = $buffer;
        } else if ($buffer == "\n"){
            //A the last group of aliases has ended. chaning major...
            $currentMajor = null;
        } else {
            //add the current aliases to the list for the major.
            $aliases[$currentMajor][] = $buffer;
        }
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail<br>";
    }
    fclose($handle);
}

print_r($aliases);
?>