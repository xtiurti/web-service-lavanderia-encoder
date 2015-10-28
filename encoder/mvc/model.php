<?php

namespace core;

class Model extends \Object {

    /**
     * Conexão que o modelo atual irá 
     * utilizar para o gerenciamento de registros.
     * 
     * @var <string>
     */
    static $connection = 'default';

    /**
     * @var array
     */
    static protected $data;

    /**
     * @var array
     */
    private $__validate_messages = array();
    
    /**
     * on methods :edit :delete :find :first
     * @var string
     */
    # static $primary_key = 'id';

    /**
     *
     * @var array
     */
    static $event = array();

    /**
     * Construct a object model
     * 
     * @param array $data
     * @return void
     */
    protected function instantiation($data = array()) {
        if (!empty($data))
            foreach ($data as $column => $value)
                $this->$column = $value;
    }

    # ----------------------------------------------------------------------------------------------------------
    # STATIC PUBLIC
    # ----------------------------------------------------------------------------------------------------------

    /**
     * Execura uma query SQL no datasource configurado para a conexão do modelo.
     * 
     * @return <array>
     */
    static function query($sql) {
        $datasource = static::datasource();
        return $datasource::query($sql, static::$connection);
    }

    /**
     * Obtém o datasource presente na conexão definida no modelo.
     * 
     * @return string datasource
     */
    static function datasource() {
        return \Connection::datasource(static::$connection);
    }

    /**
     * Efetua uma busca dos registros pertencentes a tabela do modelo pai.
     * 
     * @param array $options [fields, where, order, limit, offset]
     * @return array<\core\model>
     */
    static function find($options = array()) {
        $c = static::datasource();
        $c = $c::select(static::table(), $options, static::$connection);

        # um find sem sucesso retornará um array vazio.
        if (empty($c))
            return array();

        # tranformamos todos os resultados em uma instancia do seu modelo.
        $m = static::name_full();
        $c[key($c)] = new $m(current($c));
        for (; next($c); $c[key($c)] = new $m(current($c)))
            ;

        return $c;
    }

    /**
     * Insert a table record related with current model.
     * 
     * @param array $data [column => value]
     * 
     * @return booelan
     */
    static function insert(array $data) {
        $d = static::datasource();
        return $d::insert(static::table(), $data, static::$connection);
    }

    /**
     * Update table records related with current model.
     * 
     * @param array $data [column => value]
     * @param array $where 'id = 1', ['id = 1', 'id = 2', [id => 2]]
     * 
     * @return booelan
     */
    static function update(array $data, $where = '') {
        $d = static::datasource();
        return $d::update(static::table(), $data, $where, static::$connection);
    }

    /**
     * Delete table records related with current model.
     * 
     * @param array $where 'id = 1', ['id = 1', 'id = 2', [id => 2]]
     * 
     * @return booelan
     */
    static function delete($where = null) {
        $d = static::datasource();
        return $d::delete(static::table(), $where, static::$connection);
    }

    /**
     * Efetua uma busca dos registros pertencentes a tabela do modelo pai.
     * 
     * @param array $options [fields, where, order, offset]
     * @return array<\core\model>
     */
    static function first($options = array()) {
        @$options['limit'] = 1;

        $c = static::find($options);

        if (!empty($c)) {
            $model = static::name_full();
            return new $model($c[0]);
        }

        return array();
    }

    /**
     * Count table records by condition
     * 
     * @param array $where 'id = 1', ['id = 1', 'id = 2', [id => 2]]
     * 
     * @return int
     */
    static function count($where = '') {
        $d = static::datasource();

        $count = $d::select(static::table(), array(
            'fields' => 'count(*)',
            'where' => $where
        ), static::$connection);

        return @$count[0]['count'] ?: @$count[0]['count(*)'];
    }

    /**
     * 
     * @param type $where
     * @return type
     */
    static function exists($where = '') {
        return static::count($where) > 0;
    }

    /**
     * Obtém dados que estão sendo enviados pra este moledo através de POST ou GET.
     * 
     * @return <array>
     */
    static function data($key = null, $method = 'post') {
        if (empty(static::$data))
            static::$data = \Request::data(static::name_full(), $method);

        return $key ? @static::$data[$key] : static::$data;
    }

    /**
     * 
     * @return \self
     */
    static function requested($method = 'post') {
        $files = self::get_data_files();
        $request = static::data(null, $method) ? : array();
        $data = array_merge($files, $request);
        $model = static::name_full();

        return !empty($data) ? new $model($data) : new $model();
    }

    /**
     * Obtém a tabela respectiva ao modelo atual.
     * 
     * @param <string> $table >> Tabela que deseja definir.
     * @return <string>
     */
    static function table() {
        $model = static::name_full();
        $table = property_exists($model, 'table') ? $model::$table : \Inflector::pluralize($model::name());
        return strtolower($table);
    }

    /**
     * Obtem todas as tabelas básicas que compõe do esquema publico da conexão atual.
     * 
     * @return <array>
     */
    static function tables() {
        $d = static::datasource();
        return $d::tables(static::$connection);
    }

    /**
     * Obtem as column na tabela pertencente ao model atual.
     * 
     * @return <array>
     */
    static function columns() {
        $d = static::datasource();
        return $d::columns(static::table(), static::$connection, static::$connection);
    }

    /**
     * Obtem as column na tabela pertencente ao model atual.
     * 
     * @param <string> $column
     * 
     * @return <array>
     */
    static function column_type($column) {
        $d = static::datasource();
        return $d::column_type(static::table(), $column, static::$connection);
    }

    # ----------------------------------------------------------------------------------------------------------
    # STATIC PROTECTED
    # ----------------------------------------------------------------------------------------------------------

    /**
     * Atravez do atributo $event. No primeiro indíce é definido o  evento 
     * (find, delete, update, save). No segundo índice o momento (before, after).
     * 
     * @param type $event >> evento
     * @param type $instant >> instante
     */
    static protected function event($event, $instant, &$model) {
        $methods = @static::$event[$instant . ':' . $event];
       
        if (is_array($methods)) {
            foreach ($methods as $method) {
                static::$method($model);
            }
        } else {
            $methods ? static::$methods($model) : false;
        }
        
        return true;
    }

    # ----------------------------------------------------------------------------------------------------------
    # OBJECT PUBLIC
    # ----------------------------------------------------------------------------------------------------------

    /**
     * 
     * @return type
     */
    public function save() {
        # adicionando colunas básicas.
        $this->id = @$this->id ? : sha1(date('dmYHisu') . rand(0, 1000000000));
        $this->created_at = date('Y-m-d H:i:s');

        static::event('save', 'before', $this);
        $this->destroy_attribute_not_is_column();

        $datasource = static::datasource();
        $save = $datasource::insert(static::table(), (array) $this, static::$connection);

        # se editado com sucesso vamos chamar o evento after:edit.
        return $save ? static::event('save', 'after', $this) : false;
    }

    /**
     * Insere registros no banco de dados.
     * 
     * @return boolean
     */
    public function edit($by = 'id') {
        static::event('edit', 'before', $this);

        # definindo valores por padrão.
        # preencher colunas apenas se elas existirem na tabela.
        $this->updated_at = @$this->updated_at ? : date('Y-m-d H:i:s');

        # definindo as condições para edição dos dados.
        $where = $this->conditions_by_columns($by);

        $this->destroy_attribute_not_is_column();

        # preparando SQL e editando dados.
        $set = array();
        foreach ($this as $column => $value) {
            empty($this->$column) ?
                            $set[] = $column . ' = NULL' :
                            $set[] = $column . ' = \'' . $value . '\'';
        }

        $edit = $this->query('UPDATE ' . static::table() . ' SET ' . implode(', ', $set) . ' ' . $where . ';');

        # se editado com sucesso vamos chamar o evento after:edit.
        return $edit ? static::event('edit', 'after', $this) : false;
    }
    
    /**
     * 
     * @param string $columns_by
     */
    public function del($columns_by = 'id') {
        
        static::event('del', 'before', $this);
        $by = static::query('DELETE FROM ' . static::table() . $this->conditions_by_columns($columns_by));
        return $by ? static::event('edit', 'after', $this) : false;
    }

    /**
     * Check if current instance is empty by self properts.
     * 
     * @return boolean
     */
    public function nil() {
        foreach (get_object_vars($this) as $attr => $value) {
            if (!empty($value) || $attr != '__validate_messages')
                return false;
        }

        return true;
    }

    /**
     * Efetua a validação do campos de uma instância de um modelo.
     * 
     * @return <bool>
     */
    public function validate() {
        return \Validate::model($this);
    }

    /**
     * Seta uma mensagem de erro para um único campo de uma instância de uma modelo.
     * 
     * @param <string> $field
     * @param <string> $message
     */
    public function set_message($field, $message) {
        $this->__validate_messages[$field][] = $message;
    }

    /**
     * Obtém as mensagens de erro definidas para os campos da instância de uma modelo.
     * 
     * @param <string> $field >> Obter mensagens de apenas um campo.
     * @param <boolean> $all >> Obter todas as mensagens do campo.
     * @return <array || string>
     */
    public function messages($field = null, $all = false) {
        if (!$field)
            return $this->__validate_messages;

        if (!$messages = @$this->__validate_messages[$field])
            return null;

        return $all ? $this->__validate_messages[$field] : $this->__validate_messages[$field][0];
    }

    /**
     * Obtém a primeira smensagem definida em um campo validado.
     * 
     * @param <string> $field
     * @return <string>
     */
    public function message($field) {
        return @$this->__validate_messages[$field][0];
    }

    /**
     * Check if current instance has a particular attribute.
     * 
     * @param string $attr
     * @return boolean
     */
    public function hasAttr($attr) {
        return @$this->$attr;
    }

    /**
     * 
     * @param type $options
     */
    static function paginate($options = array()) {
        \Paginate::$model = static::name_full();
        return \Paginate::find($options);
    }

    # ----------------------------------------------------------------------------------------------------------
    # OBJECT PRIVATE
    # ----------------------------------------------------------------------------------------------------------

    /**
     * 
     * @param strin $columns
     * @return string
     */
    private function conditions_by_columns($columns) {
        $where = array();
        foreach (explode(',', str_replace(' ', '', $columns)) as $column)
            if (!empty($column))
                $where[$column] = $this->$column;
        
        $s = strtolower(static::datasource()) . '\Sql';
        return $s::where($where);
    }
    
    /**
     * Obtém de forma padronizada todos os arquivos
     * que estão sendo enviado a este modelo by POST.
     * 
     * @return array
     */
    private static function get_data_files() {
        $data_files = array();

        if (@$files = $_FILES[self::name_full()]) { # verificamos se existe algum arquivo sendo enviado a este model.
            foreach ($files['name'] as $column => $value) { # percorrendo colunas
                if (!is_array($files['name'][$column])) { # se o input atual possui um único arquivo.
                    $data_files[$column]['name'] = $value;
                    $data_files[$column]['type'] = $files['type'][$column];
                    $data_files[$column]['tmp_name'] = $files['tmp_name'][$column];
                    $data_files[$column]['error'] = $files['error'][$column];
                    $data_files[$column]['size'] = $files['size'][$column];

                    # definindo nome para salvar o arquivo.
                    $ext = explode('.', $value);
                    $data_files[$column]['save_name'] = $column . '_' . random(16) . '.' . end($ext);
                } else {
                    foreach ($files['name'][$column] as $key => $name) { # se o input atual possui vários arquivo.
                        $data_files[$column][$name]['type'] = $files['type'][$column][$key];
                        $data_files[$column][$name]['tmp_name'] = $files['tmp_name'][$column][$key];
                        $data_files[$column][$name]['error'] = $files['error'][$column][$key];
                        $data_files[$column][$name]['size'] = $files['size'][$column][$key];

                        # definindo nome para salvar o arquivo.
                        $ext = explode('.', $name);
                        $data_files[$column][$name]['save_name'] = $column . '_' . random(16) . '.' . end($ext);
                    }
                }
            }
        }

        return $data_files;
    }

    /**
     * Destrói as colunas que foram passadas por parâmetro na instância de um modelo.
     * 
     * @return void
     */
    private function destroy_attribute_not_is_column() {
        $columns = static::columns();

        foreach ($this as $attr => $val) {
            if (!in_array($attr, $columns))
                unset($this->$attr);
        }
    }

    /**
     * array(
     *      event => array(
     *          field => array(
     *              rule => array(
     *                  array(
     *                      message => 'message'
     *                      mex => 2
     *                  )
     *              )
     *          )
     *      )
     * )
     * 
     * @return <void>
     */
    static function validate_prepare() {

        # Se o atributo $validate não estiver definido no Model.
        if (!property_exists(static::name_full(), 'validate'))
            return null;

        $validates_prepared = array();

        # percorrendo validações
        foreach (static::$validate as $validation => $confs) {
            $validation = explode('{', $validation);
            $rule = str_replace(' ', '', $validation[0]);
            $fields = explode(',', str_replace(array(' ', '}'), '', $validation[1]));
            $actions_only = @str_replace(array(' ', '}'), '', $validation[2]);
            $actions_only = $actions_only ? explode(',', $actions_only) : null;
            $action = \Route::$action;

            die(pr($actions_only));

            # verificando se a validação é definida para a ação atual
            if (!empty($actions_only) && (!in_array($action, $actions_only) || in_array("!$action", $actions_only)))
                continue;

            foreach ($fields as $field) {

                # verificando se há alguma mensagem definida.
                if (array_key_exists(0, $confs)) {
                    $confs['message'] = $confs[0];
                    unset($confs[0]);
                }

                $validates_prepared[$action][$field][$rule] = $confs;
            }
        }

        pr($validates_prepared);

        die;
    }

}
