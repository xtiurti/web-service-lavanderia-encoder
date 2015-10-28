<?php

class Object {

    /**
     * Construtor para classes que não Estáticas, classes Instanciadas.
     * 
     * @return <void>
     */
    public function __construct($data = null) {
        # Se a classe PAI possuir o método instantiation, chamaremos como um construtor.
        if (method_exists($this, 'instantiation'))
            $this->instantiation($data);
    }

    /**
     * Obtém nome Básico da classe referênciadora. Sem o namespace.
     * 
     * @return <string>
     */
    static function name() {
        return basename(str_replace('\\', DS, get_called_class()));
    }

    /**
     * Obtém o nome Completo da classe referênciadora. Com o namespace.
     * 
     * @return <string>
     */
    static function name_full() {
        return get_called_class();
    }

}
