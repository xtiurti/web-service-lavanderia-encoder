<?php

class View {
    
    private static $view;
    private static $vars;
    
    /**
     * Renderiza uma visão e finaliza o código.
     * 
     * @param type $view
     * @param type $vars
     * @param type $layout
     * 
     * @return <void>
     */
    static function render($view, $vars = array(), $layout = null) {
//        echo compress(self::get_html($view, $vars, $layout));
        echo self::get_html($view, $vars, $layout);
        exit;
    }
    
    /**
     * Obtém o HTML de uma view e o código continua.
     * 
     * @param type $view
     * @param type $vars
     * @param type $layout
     * 
     * @return <string>
     */
    static function partial($view, $vars = array(), $layout = null) {
        return self::get_html($view, $vars, $layout);
    }
    
    static function element($element, $vars = array(), $layout = null) {
        return self::get_html('@elements' . DS . $element, $vars, $layout);
    }
    
    static function content() {
        return self::partial(self::$view, self::$vars);
    }
    
    
    /**
     * Obtém a string HTML de uma View que será renderizada.
     * 
     * @param type $view
     * @param type $vars
     * @param type $layout
     * 
     * @return <string>
     */
    private static function get_html($view, $vars = array(), $layout = null) {
        # iniciamos uma sessão de buffer para obter o resultado HTML compremido.
        ob_start();
        
        if ($layout !== null) {
            self::$view = $view;
            self::$vars = $vars;

            self::render_if_exists('@elements/layouts/' . $layout);
        } else
            self::render_if_exists($view, $vars);
        
        # obtemos o HTML e finalizamos a sessão de buffer
        $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
    }

    /**
     * Verifica se existe uma visão e à renderiza.
     * 
     * @param string $__view__
     * @param type $vars
     * 
     * @return <void>
     */
    private static function render_if_exists($__view__, $vars = array()) {
        # definindo caminho absoluto da view
        $__view__ = MVC . 'views' . DS . str_replace(array('\\', '/'), array(DS, DS), $__view__) . '.php';

        // Verificando se o arquivo da visão existe.
        if (!file_exists($__view__))
            die('A View nao existe >> ' . $__view__);

        # convertendo valores definidos como variáveis para a View.
        extract($vars, EXTR_PREFIX_SAME, '');

        return require $__view__;
    }

}
