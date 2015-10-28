<?php

class Validate {

    /**
     * Efetua a validaçãos dos campos definidos na instância de um Model.
     * 
     * @param <Model> $model
     * @return <array[field][message]>
     */
    static function model($model) {
        # percorrendo validações
        foreach ($model::$validate as $validation => $confs) {
            $validation = explode('{', $validation);
            $rule = str_replace(' ', '', $validation[0]);
            $fields = explode(',', str_replace(array(' ', '}'), '', $validation[1]));
            $actions_only = @str_replace(array(' ', '}'), '', $validation[2]);
            $actions_only = $actions_only ? explode(',', $actions_only) : null;
            $action = Route::$action;

            # verificando se a validação é definida para a ação atual
            if (!empty($actions_only) && (!in_array($action, $actions_only) || in_array("!$action", $actions_only)))
                continue;

            # verificando se foi definido alguma mensagem.
            if (@$confs[0]) {

                # armazenando e destruindo da confs.
                $message = $confs[0];
                unset($confs[0]);

                # definindo mensagem e suas palavras especiais
                foreach ($confs as $conf => $value)
                    $message = str_replace(":$conf", $value, $message);
            }

            # percorrendo e validando os campo
            foreach ($fields as $field) {

                # passar model por paramêtro para algumas validações.
                if (is_int(array_search($rule, array('unique', 'confirm', 'exists'))))
                    $confs['model'] = $model;

                # para regra unique é necessário parra o field.
                if ($rule == 'unique')
                    $confs['field'] = $field;
                
                if (!self::$rule(@$model->$field, $confs))
                    $model->set_message($field, @$message ? : '');
            }
        }

        return !$model->messages() ? : false;
    }

    /**
     * 
     * @param type $value
     * 
     * @return boolean é ou não é válido(a)
     */
    static function not_empty($value) {
        return !empty($value);
    }

    /**
     * 
     * @param type $value
     * 
     * @return boolean é ou não é válido(a)
     */
    static function numeric($value) {
        return is_numeric($value);
    }

    /**
     * 
     * @param type $value
     * @param type $config
     *      min => 2
     *      max => 92
     * 
     * @return boolean é ou não é válido(a)
     */
    static function strlen($value, $config) {
        $value = strlen($value);

        // Caso não haja o valor Min, atribuimos 0 (zero).
        if (!array_key_exists('min', $config))
            $config['min'] = 0;

        // Caso não haja o valor Max, não comparamos a extremidade superior.
        if (!array_key_exists('max', $config))
            return $config['min'] <= $value;

        return $config['min'] <= $value && $value <= $config['max'];
    }

    /**
     * 
     * @param type $value
     * @param type $config
     * 
     * @return boolean é ou não é válido(a)
     */
    static function strmin($value, $config) {
        return $config['min'] <= strlen($value);
    }

    /**
     * 
     * @param type $value
     * @param type $config
     * 
     * @return boolean é ou não é válido(a)
     */
    static function strmax($value, $config) {
        return $config['max'] >= strlen($value);
    }

    /**
     * 
     * @param type $value
     * @param type $config
     *      min => 2
     *      max => 92
     * 
     * @return boolean é ou não é válido(a)
     */
    static function numlen($value, $config) {
        // Caso não haja o valor Min, atribuimos 0 (zero).
        if (!array_key_exists('min', $config))
            $config['min'] = 0;

        // Caso não haja o valor Max, não comparamos a extremidade superior.
        if (!array_key_exists('max', $config))
            return $config['min'] <= $value;

        return $config['min'] <= $value && $value <= $config['max'];
    }

    /**
     * Efetua a verificação de um e-mail por expressão regular.
     * 
     * @param type $email
     * @param type $expression
     * 
     * @return boolean é ou não é válido(a)
     */
    static function email($email) {
        return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email);
    }

    static function generic($string) {
        return preg_match('/^[0-9,a-z,A-Z,á-ú,Á-Ú,à-ù,À-Ù,ã-õ,Ã-Õ,â-û,Â-Û,ä-ü,Ä-Ü,\.,\º,\ª,\-,\:,[:space:]]{0,1024}$/', $string);
    }

    static function name($name) {
        # '|^[a-z çá-úà-ù]{0,92}$|i'
        return preg_match('|^[a-z çá-úà-ù]*$|i', $name);
    }

    static function cpf($cpf) {
        return preg_match('|^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$|', $cpf);
    }

    static function rg($rg) {
        return preg_match('|[0-9]{0,16}|', $rg);
    }

    static function cep($cep) {
        return preg_match('|^[0-9]{5}-[0-9]{3}$|', $cep);
    }

    static function phone($phone) {
        return preg_match('|^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$|', $phone);
    }

    static function cnpj($cnpj) {
        return preg_match('|^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$|', $cnpj);
    }

    /**
     * 
     * @param type $value
     * @param type $options
     * @return type
     */
    static function unique($value, $options) {
        return $options['model']->exists("{$options['field']} = '$value'") <= 0;
    }

    /**
     * 
     * @param type $value
     * @param type $options
     * @return type
     */
    static function confirm($value, $options) {
        $field = $options['compare_to'];
        return $value == @$options['model']->$field;
    }

    /**
     * 
     * @param type $value
     * @param type $options
     * @return type
     */
    static function exists($email, $options) {
        return $options['model']->exists("email = '$email'");
    }

    static function date($date) {
        if (empty($date))
            return true;
        
        $date = new Date($date, 'dmY', 'Y-m-d');
        return $date->is();
    }

    static function date_greater_than_now($date) {
        $now = new Date(date('Y-m-d'), 'Ymd', 'Y-m-d');
        $date = new Date($date, 'dmY', 'Y-m-d');
        return $date->compare($now) > -1;
    }

}
