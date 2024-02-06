<?php

if (!function_exists('check_array_key_exists')) {
    function check_array_key_exists($key, $array)
    {
        return (is_array($array) && $key != '' && (isset($array[$key]) || array_key_exists($key, $array))) ? true : false;
    }
}

if (!function_exists('securestring')) {
    function securestring($param)
    {
        if (is_bool($param) && $param == true) {
            $param = "true";
        } else if (is_bool($param) && $param == false) {
            $param = "false";
        }
        return (!empty($param) && !is_array($param) && !is_bool($param)) ? htmlentities($param, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8') : $param;
    }
}

if (!function_exists('unsecurestring')) {
    function unsecurestring($param)
    {
        $toreturn = (!empty($param) && !is_array($param) && !is_bool($param)) ?  html_entity_decode($param, ENT_QUOTES | ENT_HTML401, 'UTF-8') : $param;
        if (is_bool($param)) {
            return $param;
        } else if (is_array($param)) {
            return $param;
        } else {
            return utf8_ansi2($toreturn);
        }
    }

    function utf8_ansi2($valor = '')
    {
        $utf8_ansi2 = array(
            "\u00c0" => "À",
            "\u00c1" => "Á",
            "\u00c2" => "Â",
            "\u00c3" => "Ã",
            "\u00c4" => "Ä",
            "\u00c5" => "Å",
            "\u00c6" => "Æ",
            "\u00c7" => "Ç",
            "\u00c8" => "È",
            "\u00c9" => "É",
            "\u00ca" => "Ê",
            "\u00cb" => "Ë",
            "\u00cc" => "Ì",
            "\u00cd" => "Í",
            "\u00ce" => "Î",
            "\u00cf" => "Ï",
            "\u00d1" => "Ñ",
            "\u00d2" => "Ò",
            "\u00d3" => "Ó",
            "\u00d4" => "Ô",
            "\u00d5" => "Õ",
            "\u00d6" => "Ö",
            "\u00d8" => "Ø",
            "\u00d9" => "Ù",
            "\u00da" => "Ú",
            "\u00db" => "Û",
            "\u00dc" => "Ü",
            "\u00dd" => "Ý",
            "\u00df" => "ß",
            "\u00e0" => "à",
            "\u00e1" => "á",
            "\u00e2" => "â",
            "\u00e3" => "ã",
            "\u00e4" => "ä",
            "\u00e5" => "å",
            "\u00e6" => "æ",
            "\u00e7" => "ç",
            "\u00e8" => "è",
            "\u00e9" => "é",
            "\u00ea" => "ê",
            "\u00eb" => "ë",
            "\u00ec" => "ì",
            "\u00ed" => "í",
            "\u00ee" => "î",
            "\u00ef" => "ï",
            "\u00f0" => "ð",
            "\u00f1" => "ñ",
            "\u00f2" => "ò",
            "\u00f3" => "ó",
            "\u00f4" => "ô",
            "\u00f5" => "õ",
            "\u00f6" => "ö",
            "\u00f8" => "ø",
            "\u00f9" => "ù",
            "\u00fa" => "ú",
            "\u00fb" => "û",
            "\u00fc" => "ü",
            "\u00fd" => "ý",
            "\u00ff" => "ÿ"
        );

        return strtr($valor, $utf8_ansi2);
    }
}

if (!function_exists('unaccentedstring')) {
    function unaccentedstring($chaine)
    {
        //$chaine = mb_convert_encoding($chaine, "UTF-8", mb_detect_encoding($chaine, "UTF-8, ISO-8859-1, ISO-8859-15", true));
        $table = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ý' => 'y',
            'þ' => 'b', 'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
        );
        if (!empty($chaine) && !is_array($chaine)) {
            return strtr($chaine, $table);
        } else {
            return $chaine;
        }
    }
}

if (!function_exists('isrootadmin')) {
    function isrootadmin($array)
    {
        $result = false;
        if (is_array($array)) {
            $result = (array_key_exists('id_user', $array) && $array['id_user'] == '' && array_key_exists('role', $array) && $array['role'] == 'admin' && array_key_exists('root_user', $array) && $array['root_user'] == 'admin') ? true : false;
        }
        return $result;
    }
}
