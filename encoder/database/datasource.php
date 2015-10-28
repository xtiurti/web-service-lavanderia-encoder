<?php

abstract class Datasource {

    /**
     * Open DB connection.
     * 
     * @param string $name >> nome da conexão.
     */
    abstract static function connection($connection = 'default');
    
    /**
     * Make execution by SQL script.
     * 
     * @param string $sql
     * @param string $connection
     */
    abstract static function query($sql, $connection = 'default');
    
    /**
     * Select records available on table param by param options
     * 
     * @param string $table
     * @param array $options
     * @param string $connection
     * 
     * @return array
     */
    abstract static function select($table, array $options = array(), $connection = 'default');
    
    /**
     * Security table record insert
     * 
     * @param string $table
     * @param array $data
     * @param string $connection
     * 
     * @return boolean
     */
    abstract static function insert($table, $data, $connection = 'default');
    
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
    abstract static function update($table, $data, $where = '', $connection = 'default');
    
    /**
     * Delete table records.
     * 
     * @param string $table
     * @param array $where 'id = 1' ['id = 1', 'id = 2', [id => 2]]
     * @param string $connection
     * 
     * @return boolean
     */
    abstract static function delete($table, $where = '', $connection = 'default') ;
    
    /**
     * Get Databases available in connection param.
     * 
     * @param string $connection
     * 
     * @return array
     */
    abstract static function databases(&$connection = 'default');

    /**
     * Get tables available in connection param.
     * 
     * @param string $connection
     * 
     * @return array
     */
    abstract static function tables($connection = 'default');
    
    /**
     * Get columns available in table and conection param.
     * 
     * @param string $table
     * @param string $connection
     * 
     * @return array
     */
    abstract static function columns($table, $connection = 'default');
    
    
    /**
     * Get type of column table.
     * 
     * @param string $table
     * @param string $column
     * @param string $connection
     * 
     * @return array
     */
    abstract static function column_type($table, $column, $connection = 'default');

    /**
     * Description column table.
     * 
     * @param string $table
     * @param string $column
     * @param string $connection
     * @return array
     */
    abstract static function column_description($table, $column, $connection = 'default');
}
