<?php

class Route {

    static $routes = array();
    static $current;
    static $controller;
    static $action;

    static function init() {
        init('route');
        static::set_current();
    }

    private static function set_current() {
        static::$current = '/' . str_replace(Url::$application, '', URL_CURRENT);

        if (is_int(strpos(static::$current, '?'))) {
            static::$current = explode('?', static::$current);
            unset(static::$current[count(static::$current) - 1]);
            static::$current = implode('/', static::$current);
        }

        if (static::is())
            static::set_controller_and_action();
    }

    private static function set_controller_and_action() {
        # verificando se o config da rota atual é um array com 
        # varias opções, ou apenas a definição básica da rota
        is_array(static::$routes[static::$current]) ?
                        $route = explode(' ', static::$routes[static::$current]['location']) :
                        $route = explode(' ', static::$routes[static::$current]);

        static::$controller = $route[0];
        static::$action = @$route[1] ? : 'index';
    }

    static function is() {
        return array_key_exists(static::$current, static::$routes);
    }

    static function url_call() {
        if (!static::is())
            die('Route: A rota nao existe >> ' . static::$current);

        if (!class_file_exists(static::$controller))
            die('Route: O controller nao existe >> ' . static::$controller);

        # instanciando o controller requisitado.
        $controller = static::$controller;
        $controller::route_call(static::$action);
    }

    static function add($route, $locale) {
        static::$routes[$route] = $locale;
    }

    /**
     * Gerador de URL a partir de uma rota.
     * 
     * @param <string> $route
     * @return <string> url
     */
    static function gen($route) {
        return URL_APPLICATION . substr($route, 1);
    }

    /**
     * Redireciona a aplicação para um determinada rota.
     * 
     * @param <string> $route
     */
    static function go($route) {
        header('Location: ' . URL_APPLICATION . substr($route, 1));
        exit();
    }

    /**
     * Retorna o local atual da rota no formato /:hierarchy/:controller/:action
     * 
     * @return <string>
     */
    static function locale() {
        return strtolower(str_replace('controllers\\', '', Route::$controller) . '/' . Route::$action);
    }

}
