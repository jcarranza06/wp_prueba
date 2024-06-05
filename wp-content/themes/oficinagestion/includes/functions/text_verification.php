<?php

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}

function verify_string($string){
    if(gettype($string)=="string"){
        return verify_chars($string);
    }else {
        try {
            $string= strval($string);
            return verify_chars($string);
        } catch (Exception $e) {
            
        }
    }
}

function verify_array($array){
    if(gettype($array)=="array"){
        for($i = 0; $i <count($array); $i++){
            if(!verify_string($array[$i])){
                return false;
            }
        }
        return true;
    }
}

function verify_chars($string) {
    if (str_contains($string, '$')){
        return false;
    }
    if (str_contains($string, '#')){
        return false;
    }
    if (str_contains($string, '{')){
        return false;
    }
    if (str_contains($string, '}')){
        return false;
    }
    if (str_contains($string, '==')){
        return false;
    }
    if (str_contains($string, '[')){
        return false;
    }
    if (str_contains($string, ']')){
        return false;
    }
    return true;
}

?>