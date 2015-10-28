<?php

class Flash {

    /**
     * Escopo das mensagens setadas sem informar o escopo.
     * 
     * @var string
     */
    static $default_scope = 'no_scope';

    /**
     * Define uma mensagem flash.
     * 
     * @param <string> $message
     * @param <string> $element
     * @param <string> $escope
     * 
     * @return <void>
     */
    static function set($message, $element = 'default', $scope = null) {
        # Capturando todas as mensagens flash definidas na sessão, caso 
        # não exista nenhuma, convertemos para array o retorno da sessão.
        $flashs = Session::get('flash') ? : array();

        # Definindo escopo da mensagem;
        $scope = $scope ? : self::$default_scope;

        # Dentro do escopo :flash, criamos o escopo do paramêtro $scope e inserimos a 
        # msg dentro deste. Caso já exista o escopo, será apenas inserido a msg.
        $flashs[$scope][$element][] = $message;

        # Salvamos os novos valores do índice :flash na sessão.
        return Session::set('flash', $flashs);
    }

    /**
     * Obtém o HTML de todas as mensagens flashs escritas.
     * 
     * @param <string> $scope
     * @return <string>
     */
    static function get($scope = null) {
        # definindo escopo da mensagem;
        $scope = $scope ? : self::$default_scope;

        # Capturamos as mensagens salvas na sessão, caso existão.
        if ($flashs = Session::get('flash', true)) {
            foreach ($flashs[$scope] as $element => $msgs) {
                foreach ($msgs as $msg) {
                    echo view("@elements/flash/$element", array(
                        'message' => $msg
                    ));
                }
            }
        }
    }

}
