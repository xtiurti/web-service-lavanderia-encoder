<?php

class Mysql {

    /**
     * Método que irá abrir uma conexão com servidor.
     * 
     * @param <string> $name >> nome da conexão.
     */
    static function connection($name) {
        $config = Connection::get($name);

        # iniciando conexão, caso isto ainda não tenha sido feito.
        if (!array_key_exists('connection', $config)) {
            $conn = new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['user'], $config['password']);
            Connection::$connections[$name]['connection'] = $conn;
        }

        return Connection::$connections[$name]['connection'];
    }

    /**
     * Efetua a execução de um script SQL.
     * 
     * @param <string> $sql
     * @param <string> $connection_name
     */
    static function query($sql, $connection_name = 'default') {
        $conn = self::connection($connection_name);
        $stm = $conn->prepare($sql);
        
        if (!$stm->execute())
            return false;

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /**
     * Security table record insert
     * 
     * @param string $table
     * @param array $data
     * @param string $connection
     * 
     * @return boolean
     */
    static function insert($table, $data, $connection = 'default') {
        $data = mysql\Sql::insert($table, $data);
        
        $conn = self::connection($connection);
        $stm = $conn->prepare($q);
        return $stm->execute($data);
    }
    
    /**
     * Select records available on table param by param options
     * 
     * @param string $table
     * @param array $options
     * @param string $connection
     * 
     * @return array
     */
    static function select($table, array $options = array(), $connection = 'default') {
        $r = static::query(mysql\Sql::select($table, $options), $connection);
        return !is_array($r) ? array() : $r;
    }

    /**
     * Security table record update
     * 
     * @param string $table
     * @param array $data
     * @param array $where 'id = 1' ['id = 1', 'id = 2', [id => 2]]
     * @param string $connection
     * 
     * @return boolean
     */
    static function update($table, $data, $where = '', $connection = 'default') {
        $data = mysql\Sql::update_security($table, $data, $where);
        return pg_query_params(self::connection($connection), $data['sql_query_params'], $data['values']);
    }

    /**
     * Delete table records.
     * 
     * @param string $table
     * @param array $where 'id = 1' ['id = 1', 'id = 2', [id => 2]]
     * @param string $connection
     * 
     * @return boolean
     */
    static function delete($table, $where = '', $connection = 'default') {
        return static::query(mysql\Sql::delete($table, $where), $connection);
    }

    /**
     * 
     * @param type $connection_name
     * @return type
     */
    static function databases(&$connection = 'default') {
        $s = 'SHOW DATABASES;';

        foreach (self::query($s, $connection) as $d)
            @$ds[] = $d['Database'];

        return @$ds ? : array();
    }

    /**
     * Obtém todas as tabelas criadas na conexão informada por paramêtro.
     * 
     * @param <string> $connection
     * 
     * @return <array>
     */
    static function tables($connection = 'default') {
        $s = 'SHOW TABLES;';

        $d = Connection::get($connection);

        foreach (self::query($s, $connection) as $t)
            @$ts[] = $t["Tables_in_{$d['database']}"];

        return @$ts ? : array();
    }

    /**
     * Obtém todas as column que possui a tabela informada por paramêtro.
     * 
     * @param <string> $table
     * @param <string> $connection_name
     * 
     * @return <array>
     */
    static function columns($table, $connection = 'default') {
        $s = "SHOW COLUMNS FROM $table;";

        foreach (self::query($s, $connection) as $t)
            @$c[] = $t['Field'];

        return @$c ? : array();
    }

}
