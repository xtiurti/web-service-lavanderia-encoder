<?php

namespace postgresql;

class Sql extends \Sql {

    /**
     * 
     * @param string $table
     * @param array $data
     * @param array, string $where
     * 
     * @return array
     */
    static function insert_security($table, array $data) {
        $columns = $values = $keys = array();
        foreach ($data as $column => $value) {
            $columns[] = $column;
            $values[] = $value;
            $keys[] = '$' . @ ++$i;
        }

        $columns = implode(', ', $columns);
        $keys = implode(', ', $keys);

        # $q = "INSERT INTO $table ($columns) VALUES($keys);";
        # return pg_query_params(self::connection($connection), $q, $values);
        return array(
            'sql_query_params' => "INSERT INTO $table ($columns) VALUES($keys);",
            'values' => $values,
        );
    }

    /**
     * 
     * @param string $table
     * @param array $data
     * @param array, string $where
     * 
     * @return array
     */
    static function update_security($table, array $data, $where = null) {
        $values = $column_values = array();
        foreach ($data as $column => $value) {
            $values[] = $value;
            $column_values[] = $column . ' = $' . @ ++$i;
        }

        return array(
            'sql_query_params' => 'UPDATE ' . $table . ' SET ' . implode(', ', $column_values) . ' ' . static::where($where) . ';',
            'values' => $values,
        );
    }

}
