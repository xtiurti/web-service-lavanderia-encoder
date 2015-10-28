<?php

class Url {

    static $protocol;
    static $host;
    static $current;
    static $application;
    
    static function init() {
        self::$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https' : 'http';
        self::$host = self::$protocol . '://' . $_SERVER['HTTP_HOST'];
        self::$current = urldecode(self::$host . $_SERVER['REQUEST_URI']);
        self::$application = self::$host . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        
        define('URL_PROTOCOL', self::$protocol);
        define('URL_HOST', self::$host);
        define('URL_CURRENT', self::$current);
        define('URL_APPLICATION', self::$application);
    }

    /**
     * Redireciona a aplicação para um determinada rota.
     * 
     * @param <string> $route
     */
    static function go($url) {
        header('Location: ' . $url);
        exit();
    }

}
