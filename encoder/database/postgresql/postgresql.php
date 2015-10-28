<?php

class Postgresql {

    /**
     * Método que irá abrir uma conexão com servidor.
     * 
     * @param <string> $name >> nome da conexão.
     */
    static function connection($name) {
        $config = Connection::get($name);

        # iniciando conexão, caso isto ainda não tenha sido feito.
        if (!array_key_exists('connection', $config)) {
            Connection::$connections[$name]['connection'] = pg_connect("host={$config['host']} port={$config['port']} dbname={$config['database']} user={$config['user']} password={$config['password']}");
            pg_set_client_encoding(Connection::$connections[$name]['connection'], 'UTF-8');
        }
        
        return Connection::$connections[$name]['connection'];
    }

    /**
     * Make execution by SQL script.
     * 
     * @param string $sql
     * @param string $connection
     */
    static function query($sql, $connection = 'default') {
        # executando/verificando validade da query.
        if (!$query = pg_query(self::connection($connection), $sql))
            return false;

        # efetuando/verificando requisição no banco.
        if (($fetch = pg_fetch_all($query)) !== null)
            return empty($fetch) ? true : $fetch;

        return false;
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
        $r = static::query(postgresql\Sql::select($table, $options), $connection);
        return !is_array($r) ? array() : $r;
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
        $data = postgresql\Sql::insert_security($table, $data);
        return pg_query_params(self::connection($connection), $data['sql_query_params'], $data['values']);
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
        $data = postgresql\Sql::update_security($table, $data, $where);
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
        return static::query(postgresql\Sql::delete($table, $where), $connection);
    }

    /**
     * Get Databases available in connection param.
     * 
     * @param string $connection
     * 
     * @return array
     */
    static function databases(&$connection = 'default') {
        $sql = 'SELECT datname FROM pg_database;';

        foreach (self::query($sql, $connection) as $db)
            @$dbs[] = $db['datname'];

        return @$dbs ? : array();
    }

    /**
     * Get tables available in connection param.
     * 
     * @param string $connection
     * 
     * @return array
     */
    static function tables($connection = 'default') {
        $sql = 'SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\';';

        foreach (self::query($sql, $connection) as $table)
            @$tables[] = $table['table_name'];

        return @$tables ? : array();
    }

    /**
     * Get columns available in table and conection param.
     * 
     * @param string $table
     * @param string $connection
     * 
     * @return array
     */
    static function columns($table, $connection = 'default') {
        $query = 'SELECT column_name FROM information_schema.columns WHERE table_name =\'' . $table . '\';';
        $query = self::query($query, $connection);

        # caso a tabela informada não possua nenhuma coluna.
        if (!is_array($query))
            return array();

        foreach ($query as $column)
            @$columns[] = $column['column_name'];

        return $columns;
    }

    /**
     * Get type of column table.
     * 
     * @param string $table
     * @param string $column
     * @param string $connection
     * 
     * @return array
     */
    static function column_type($table, $column, $connection = 'default') {
        $sql = "SELECT data_type FROM information_schema.columns WHERE table_name = '$table' AND column_name = '$column';";
        $sql = self::query($sql, $connection);
        return @$sql[0]['data_type'];
    }

    /**
     * Description column table.
     * 
     * @param string $table
     * @param string $column
     * @param string $connection
     * @return array
     */
    static function column_description($table, $column, $connection = 'default') {
        $sql = "        
            SELECT 
                table_name AS table,
                column_name AS column,
                column_default AS default, 
                is_nullable AS nullable,
                is_updatable AS updatable,
                data_type AS type,
                character_maximum_length AS max_length,
                numeric_precision_radix AS precision
            FROM information_schema.columns 
            WHERE table_name = '$table' AND column_name = '$column';";

        $sql = self::query($sql, $connection);
        return @$sql[0];
    }

}
