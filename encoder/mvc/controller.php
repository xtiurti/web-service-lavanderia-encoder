<?php

namespace core;

class Controller extends \Object {

    /**
     * Propriedade que define se a view será 
     * renderizada automaticamente pelo controlador.
     * 
     * @var boolean
     */
    static $render = true;

    /**
     *
     * @var boolean
     */
    static $only_render = false;

    /**
     * Nome do model que será vinculado diretamente ao controler.
     * 
     * @var <string> 
     */
    static $model;

    /**
     * Métodos que serão referenciados antes da ação.
     * 
     * @var <array>
     */
    static $before_action = array();

    /**
     * Métodos que serão referenciados depois da ação.
     * 
     * @var <array>
     */
    static $after_action = array();

    /**
     * Variáveis definidas para a View, onde o índice representa o nome.
     * 
     * @var <array>
     */
    static $view_vars = array();
    
    static $relative_space;
    
    static function init() {
        static::$relative_space = str_replace(array('controllers\\', '\\' . static::name()), '', static::name_full());
    }

    /**
     * Método auxiar da rota, permitindo que o próprio controle efetue 
     * a referêncição do método que representa a ação, podendo assim tratar 
     * outros detalhes particulares. Para isto basta que a rota chame o método 
     * com prefixo call__{method}
     * 
     * @param <string> $name
     * @throws \core\exceptions\lib\MethodMissing
     * 
     * @return <void>
     */
    static function route_call($action) {
        if (!static::$only_render) { # verificando se é um controller apenas de renderização.
            if (!method_exists(static::name_full(), $action)) # verificando se a ação requisita existe.
                die('Acao nao existe >> ' . static::name_full() . '::' . $action);

            static::before_action();
            static::$action(); # efetuando referênciação da ação.
            static::after_action();
        }

        # verificando se o controller deseja renderizar a View.
        if (static::$render) {
            $controller = static::name_full();
            $layout = property_exists($controller, 'layout') ? $controller::$layout : \Auth::hierarchy();
            echo \View::render(strtolower(str_replace(array('controllers\\', '\\', '/'), array('', DS, DS), static::name_full())) . DS . $action, static::$view_vars, $layout);
        }
        
        # end convencional route;
    }

    /**
     * Método referênciado Antes da ação do controller.
     * 
     * @return <void>
     */
    private static function before_action() {
        foreach (static::$before_action as $method)
            static::$method();
    }

    /**
     * Método referênciado Após da ação do controller, antes da renderização.
     * 
     * @return <void>
     */
    private static function after_action() {
        foreach (static::$after_action as $method)
            static::$method();
    }

}
