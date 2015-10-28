<?php

class Sql {

    static $string_identification = "'";

    /**
     * 
     * @param type $options
     */
    static function options($options = array()) {
        return self::where(@$options['where']) .
                self::order(@$options['order']) .
                self::limit(@$options['limit']) .
                self::offset(@$options['offset']);
    }

    /**
     * 
     * @param int $limit
     * @return string
     */
    static function limit($limit = null) {
        return $limit === null ? '' : ' LIMIT ' . $limit;
    }

    /**
     * 
     * @param int $offset
     * @return string
     */
    static function offset($offset = null) {
        return $offset === null ? '' : ' OFFSET ' . $offset;
    }

    /**
     * @param string $where 'id DESC'
     * @param array $where array('id DESC', 'id', 'id' => 'DESC')
     * 
     * @return string
     */
    static function order($order = null) {
        if (empty($order))
            return '';

        if (is_string($order))
            return ' ORDER BY ' . $order;

        $orders = array();
        foreach ($order as $key => $direction)
            is_numeric($key) ?
                            $orders[] = $direction :
                            $orders[] = $key . ' ' . $direction;

        return ' ORDER BY ' . implode(', ', $orders);
    }

    /**
     * @param string $where 'id = 1'
     * @param array $where array('id = 1', 'id' => 2)
     * 
     * @return string
     */
    static function where($where = null) {
        if (empty($where))
            return '';

        if (is_string($where))
            return ' WHERE ' . $where;

        $sql = array();

        if (is_array($where)) {
            foreach ($where as $field => $condition) {
                if (is_numeric($field))
                    $sql[] = $condition;
                else {
                    is_numeric($condition) ?
                                    $sql[] = $field . ' = ' . $condition :
                                    $sql[] = $field . ' = ' . static::$string_identification . $condition . static::$string_identification;
                }
            }
        }

        return ' WHERE ' . implode(' AND ', $sql);
    }

    /**
     * @param string $fields
     * @return string
     */
    static function fields($fields = null) {
        return empty($fields) ? '*' : $fields;
    }

    /**
     * 
     * @param string $table
     * @param array $data
     * @return string
     */
    static function insert($table, array $data) {
        $columns = $values = array();
        foreach ($data as $column => $value) {
            $columns[] = $column;

            is_numeric($value) ?
                            $values[] = $value :
                            $values[] = static::$string_identification . $value . static::$string_identification;
        }

        $columns = implode(', ', $columns);
        $values = implode(', ', $values);

        return "INSERT INTO $table ($columns) VALUES($values);";
    }

    /**
     * 
     * @param string $table
     * @param array $data
     * @param array $where
     * 
     * @return string Sql to update
     */
    static function update($table, array $data, $where = null) {
        $values = array();
        foreach ($data as $column => $value) {
            is_numeric($value) ?
                            $values[] = $column . ' = ' . $value :
                            $values[] = $column . ' = ' . static::$string_identification . $value . static::$string_identification;
        }

        return 'UPDATE ' . $table . ' SET ' . implode(', ', $values) . ' ' . static::where($where) . ';';
    }

    /**
     * 
     * @param string $table
     * @param string, array $where
     * @return string
     */
    static function delete($table, $where = '') {
        return 'DELETE FROM ' . $table . ' ' . self::where($where) . ';';
    }

    /**
     * 
     * @param string $table 
     * @param array $options [fields, where, order, limit, offset]
     * 
     * @return string
     */
    static function select($table, $options) {
        $fields = static::fields(@$options['fields']);
        return 'SELECT ' . $fields . ' FROM ' . $table . ' ' . static::options($options) . ';';
    }

}
