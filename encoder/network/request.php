<?php

class Request {

    /**
     * Representa os dados GET enviados para a aplicação.
     * 
     * @var <array>
     */
    static $get = array();
    static $post = array();

    /**
     * Construtor do @encoder
     */
    static function init() {
        init('request');
        self::$post = $_POST;
        self::$get = $_GET;
    }

    /**
     * Obtém o IP do cliente requisitor.
     * 
     * @return <string>
     */
    static function ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        if (!defined('IP'))
            define('IP', $ip);

        if (!defined('IP_NUMBER'))
            define('IP_NUMBER', preg_replace('/[^0-9]/', '', IP));
        
        return $ip;
    }

    /**
     * Verifica se uma requisição é efetuada com AJAX.
     * 
     * @return <boolean>
     */
    static function is_ajax() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;

        return false;
    }

    /**
     * Verifica se uma requisição é efetuada com POST.
     * 
     * @return <boolean>
     */
    static function is_post() {
        return !empty($_POST);
    }

    static function get($key = null) {
        return $key ? @self::$get[$key] : self::$get;
    }

    static function csfr() {
        $csfr = Session::get('csfr');

        # caso já exista uma CSFR não verificada vamos utilizar.
        if ($csfr[ip()])
            return $csfr[ip()];

        # criamos uma nova CSFR.
        Session::set('csfr', array(
            ip() => ($token = random())
        ));

        return $token;
    }

    /**
     * Certifica um código CSFR enviado para a aplicação via GET ou POST.
     * 
     * @return <bool>
     */
    static function csfr_validation($csfr) {
        $session_csfr = Session::get('csfr');

        # verificamos se há algum CSFR definido no IP atual.
        if (!$session_csfr = @$session_csfr[ip()])
            return false;

        # destruimos a CSFR utilizada anteriormente
        Session::destroy('csfr');

        # verificamos se a CSFR obtida é igual da da Requisição.
        return $session_csfr == $csfr ? true : false;
    }

    /**
     * Input para um formulário POST contendo o TOKEN autenticador.
     * 
     * @return <string>
     */
    static function input_csfr() {
        return '<input type="hidden" name="csfr" value="' . self::csfr() . '" />';
    }

    /**
     * Obtém um dado de requisição POST ou GET.
     * 
     *    Na ausência do parâmetro $key, retornamos todo o conteúdo do $method 
     * informado.
     *    Na ausência do parâmetro $method, verificamos se o valor existe tanto 
     * em GET quanto em POST.
     * 
     * @param <string> $key
     * @param <string> $method
     * 
     * @return <?>
     */
    static function data($key = null, $method = 'post') {
        if (!$key)
            return Request::$$method;

        $data = Request::$$method;
        @$data = $data[$key];

        if (empty($data)) {
            return $method == 'post' ?
                    @Request::$get[$key] :
                    @Request::$post[$key];
        }

        return $data;
    }

    static function query_get($key = null, $value = null) {
        $data = self::$get;
        
        if ($key)
            $data[$key] = $value;

        return http_build_query($data);
    }

}
