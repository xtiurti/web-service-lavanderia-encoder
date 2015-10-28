<?php

class Controller extends core\Controller {

    static $before_action = array('support', 'access_log', 'is_ajax', 'auth');
//    static $before_action = array('support', 'access_log', 'is_ajax', 'auth', 'check_token');

    static function support() {
    }

    /**
     * Efetando log de acesso do sistema, atualizado a cada acesso na página.
     * 
     * @return <void>
     */
    static function access_log() {
        app_log('access', json(array(
            'accessed_in' => date('d/m/Y H:i:s'),
            'ip' => ip(),
            'url' => URL_CURRENT,
            'get' => $_GET,
            'post' => $_POST,
        )));
    }

    /**
     * Requisições ajax nao são aceitas.
     */
    static function is_ajax() {
        if (is_ajax())
            response_ajax('liv responds > that ugly, never pass data in this way.');
    }

    /**
     * Tranferência de usuário autenticado para seu espaço.
     */
    static function auth() {
        # caso usuário esteja fora da sua área redirecionamos.
        if (self::$relative_space != hierarchy())
            go();
    }

    /**
     * Caso exista um POST vamos verificar seu TOKEN.
     */
    static function check_token() {
        if (is_post() && !csfr_validation())
            flash('Requisição não autenticada.', 'warning') & go();
    }

}
