<?php

namespace App\Utils;

class MasksUtil {

    static function mask(string $value, string $mask) : string
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++){ if($mask[$i] == '#') { if(isset($value[$k]))
            $maskared .= $value[$k++];
                 }
        else {
            if(isset($mask[$i]))
                 $maskared .= $mask[$i];
        }
     }
     return $maskared;
    }

    static function unmask(string $value) : string
    {
        $value = trim($value);
        $value = str_replace(".", "", $value);
        $value = str_replace(" ", "", $value);
        $value = str_replace("(", "", $value);
        $value = str_replace(")", "", $value);
        $value = str_replace(",", "", $value);
        $value = str_replace("-", "", $value);
        $value = str_replace("/", "", $value);
        return $value;
    }

}
