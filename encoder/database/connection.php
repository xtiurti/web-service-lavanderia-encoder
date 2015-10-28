<?php

class Connection {

    /**
     * Configurações pré-definidas para uma conexão.
     * 
     * @var <array>
     */
    static $defaults = array(
        'host' => 'localhost',
//        'path' => '', # for SQLite
        'source' => 'Postgresql',
        'user' => 'postgres',
        'password' => 'postgres',
        'port' => 5432,
    );

    /**
     * Conexões configurados pela aplicação.
     *   name: [source: '', host: '', username: '', password: '', database: '']
     * 
     * @var <array>
     */
    static $connections = array();

    static function init() {
        init('connection');
    }

    /**
     * Obtém uma conexão ativa, ou preenchar os dados da mesma com os padrões.
     * 
     * @param <string> $connection >> Nome da conexão.
     * @return <array>
     */
    static function get($connection = 'default') {
        return array_merge(self::$defaults, self::$connections[$connection]);
    }

    /**
     * Obtém o datasource correspondente. Onde irá gerenciar seus registros.
     * 
     * @param <string> $connection
     * @return <datasource>
     */
    static function datasource($connection = 'default') {
        # capturando configuração da conexão e defindo seus valores padrão.
        $connection = array_merge(self::$defaults, self::$connections[$connection]);

        # obtendo nome do datasource através da conexão definida.
        return $connection['source'];
    }

}
