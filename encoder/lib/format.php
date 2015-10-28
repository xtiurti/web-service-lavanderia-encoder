<?php

class Format {

    static function money_to_float($money) {
        return floatval(str_replace(array('.', ','), array('', '.'), $money));
    }

    static function money($float) {
        return number_format($float, 2, ',', '.');
    }

    static function megabytes($bytes) {
        return number_format($bytes / 1048576, 2, '.', '');
    }
    
    static function first_name($name) {
        $name = explode(' ', $name);
        return ucfirst(strtolower($name[0]));
    }

}
