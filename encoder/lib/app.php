<?php

abstract class App {

    /**
     * Store the application execution time from the first reference to method App::time().
     * 
     * @var float
     */
    private static $time_execution;
    
    /**
     * Are variables defined as globals in application scope.
     * 
     * @var array
     */
    private static $globals = array();

    /**
     * Security application salt.
     * 
     * @var string
     */
    static $code = 'M*(AYCnc&AF!@EasolAS~SD`_!@ás´1ãsd~´qwe[q]Q¬u';

    /**
     * On the first call, starts the application execution time score.
     * On the second call, get percorred time.
     * 
     * @return void or float
     */
    static function timer() {
        if (empty(self::$time_execution))
            return self::$time_execution = microtime(TRUE);

        return substr(number_format(microtime(TRUE) - self::$time_execution, 6), 0, -2);
    }

    /**
     * Required the init Class file. Stored in app/init.
     * 
     * @param string $file or Class name
     */
    static function init_class($file) {
        $file = strtolower($file);

        # verificamos se há um arquivo de inicialização em app/init
        if (file_exists(INIT . $file . '.php'))
            require_once INIT . $file . '.php';
    }

    /**
     * Set a global variable if param $name and $value is passed.
     * Else if param $name not passed, returns all Globals.
     * 
     * If the parameter to $value is not passed, then it will 
     * return the global variable referring to the $name parameter.
     * 
     * @param string $name
     * @param ? $value
     * @return ?
     */
    static function globals($name = null, $value = null) {
        if ($name === null)
            return self::$globals;
        
        if ($value === null)
            return @self::$globals[$name];
        
        self::$globals[$name] = $value;
    }
    
}
