<?php

class Form {

    static $form_element;
    static $message_element;

    static function init() {
        init('form');
    }

    /**
     * Verifica se o paramêtro $model é um Model. 
     * Obtém o valor $model->$field.
     * 
     * @param Model $model
     * @param <string> $field
     * @return <?>
     */
    static function value($model, $field) {
        return @$model->$field ?: '';
    }

    /**
     * Obtém o ID a ser utilizado em um input respectivo a um campo de um modelo.
     * 
     * @param <Model> $model
     * @param <string> $field
     */
    static function input_id($model, $field) {
        $model = $model ? $model::name_full() : '';
        $model = str_replace('\\', '_', strtolower($model));
        return $model . '_' . $field;
    }

    /**
     * Retorn o HTML de um label a ser utilizada em um input respectivo a um campo de um modelo.
     * 
     * @param <string> $text
     * @param <Model> $model
     * @param <string> $field
     */
    static function label($text, $model, $field) {
        return '<label for="' . self::input_id($model, $field) . '">
            ' . $text . '
        </label>';
    }

    /**
     * Verifica se o paramêtro $model é um Model. 
     * Obtém a primeira mensagem escrita no $model->$field.
     * 
     * @param Model $model
     * @param <string> $field
     * @return <string>
     */
    static function message($model, $field) {
        $message = !$model->nil() ? $model->message($field) : '';
        return $message ? str_replace(':message', $message, static::$message_element) : '';
    }

    /**
     * 
     * @param type $options
     */
    static function open($action = null, $multipart = false) {
        $action = $action ? url($action) : url();
        return '<form action="' . $action . '" method="POST" enctype="multipart/form-data">' . input_csfr();
    }

    /**
     * 
     */
    static function close() {
        return '</form>';
    }

}
