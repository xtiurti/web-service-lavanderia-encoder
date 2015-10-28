<?php

class Sqlite extends Datasource {

    /**
     * Método que irá abrir uma conexão com servidor.
     * 
     * @param <string> $name >> nome da conexão.
     */
    static function connection($connection = 'default') {
        $config = Connection::get($connection);

        if (!array_key_exists('connection', $config)) {
            # criando arquivo do SQLite
            if (!$conn = new PDO("sqlite:{$config['path']}{$config['database']}.db"))
                die('SQLite: Erro ao se conectar.');

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            Connection::$connections[$connection]['connection'] = $conn;
        }

        return Connection::$connections[$connection]['connection'];
    }

    static function query($sql, $connection = 'default') {
        $conn = self::connection($connection);

        try {
            $stm = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }

        $stm->execute();
        $q = $stm->fetchAll(PDO::FETCH_ASSOC);
        return is_array($q) && empty($q) ? true : $q;
    }

    static function databases(&$connection = 'default') {
        
    }

    static function tables($connection = 'default') {
        $tables_query = Sqlite::query('SELECT name FROM sqlite_master WHERE type=\'table\'');

        # encontrou alguma tabela ?
        if (!is_array($tables_query))
            return array();

        foreach ($tables_query as $t)
            $tables[] = $t['name'];

        return $tables;
    }

    static function columns($table, $connection = 'default') {
        foreach (Sqlite::query("pragma table_info($table);") as $c)
            $columns[] = $c['name'];

        return @$columns ? : array();
    }

    static function column_type($table, $column, $connection = 'default') {
        
    }

    static function column_description($table, $column, $connection = 'default') {
        
    }

    static function insert($table, $data, $connection = 'default') {
        return static::query(\Sql::insert($table, $data) . ' asd', $connection);
    }

    static function select($table, array $options = array(), $connection = 'default') {
        return static::query(\Sql::select($table, $options), $connection);
    }

    static function update($table, $data, $where = '', $connection = 'default') {
        return static::query(\Sql::update($table, $data, $where), $connection);
    }

    static function delete($table, $where = '', $connection = 'default') {
        return static::query(\Sql::delete($table, $where), $connection);
    }

}
