<?php

if (!function_exists('checkStringIsJsonArray')) {

    function checkStringIsJsonArray(&$string)
    {
        $string = trim($string);
        return (is_string($string) &&
            is_array(json_decode($string, true)) &&
            (json_last_error() == JSON_ERROR_NONE) &&
            $string[0] == '[' &&
            $string[(strlen($string) - 1)] == ']') ? true : false;
    }
}

if (!function_exists('convertStringInJsonArray')) {

    function &convertStringInJsonArray(&$string)
    {
        $string = '[' . $string . ']';
        return $string;
    }
}
