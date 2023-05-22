<?php

//read file
$fp = @fopen("translation/en.properties", "r");

$arrBuffer = [];

$values = [];
if ($fp) {
    while (($buffer = fgets($fp)) !== false) {

        $matches = [];
           
        if(stripos($buffer, '#') === 0)
        {
            $values[] = $buffer;
        } else if(preg_match('/(.*)=(.*)/im', $buffer, $matches) === 1)
        {
            if(isset($matches[1]) && isset($matches[2]))
            {
                $values[] = $matches[2];
                $arrBuffer[$matches[1]] = $values;
            }
       
            $values = [];
        }
         
    }
    if (!feof($fp)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($fp);
}

function cmp($a, $b)
{
    $a = $a[count($a) - 1];
    $b = $b[count($b) - 1];
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

//sort A-Z
usort($arrBuffer, 'cmp');


//File output
$lineEnding = PHP_EOL;

$fpS = @fopen("translation/en_sorted.properties", "w");

if ($fpS) {
    foreach($arrBuffer as $translation)
    {
        foreach($translation as $line)
        {
            fwrite($fpS, trim($line, "\n\r").$lineEnding);
        }
            
    }

    if (!feof($fpS)) {
        echo "Error: unexpected fwrite() fail\n";
    }
    fclose($fpS);
}



