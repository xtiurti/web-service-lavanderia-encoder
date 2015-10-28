<?php

class Session {

    /**
     * Método construtor do framework.
     */
    static function init() {
        @session_start();
    }

    /**
     * Setando um valor na sessão.
     * 
     * @param type $key
     * @param type $value
     * 
     * @return void
     */
    static function set($key, $value) {
        return $_SESSION[$key] = $value;
    }

    /**
     * Capturando um valor de sessão e destruindo o mesmo.
     * 
     * @param type $key
     * 
     * @return ? session value key
     */
    static function get($key = null, $destroy = false) {
        # caso não seja específicado um índice, capturamos a sessão completa.
        $session = ($key === null ? $_SESSION : @$_SESSION[$key]);

        # verificando se é para destruir a sessão após recebe-lá.
        if ($destroy)
            self::destroy($key);

        return $session;
    }

    /**
     * Destruir uma sessão sem recebe-lá.
     * 
     * @param type $key
     */
    static function destroy($key = null) {
        # Caso não seja específicado um índice, destruí-mos toda a sessão.
        if ($key == null)
            session_destroy();
        else
            unset($_SESSION[$key]);
    }
    
    /**
     * Obtém ou escreve dados na sessão.
     * 
     * Na ausência do parâmetro $key, obtém toda a sessão.
     * Na ausência do parâmetro $value, obtém a sessão escrita em $key;
     * 
     * @param <string> $key
     * @param <string> $value
     * 
     * @return <bool>
     */
    static function _session($key = null, $value = null) {
        if (!$key)
            return self::get();

        if ($value === null)
            return self::get($key);

        return self::set($key, $value);
    }

}
