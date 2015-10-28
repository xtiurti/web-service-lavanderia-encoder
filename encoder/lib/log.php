<?php

class Log {

    /**
     *
     * @var string
     */
    static $path;

    /**
     *
     * @var string
     */
    static $line_end;

    static function init() {
        init('log');
    }

    /**
     * Escreve uma linha no arquivo referente ao parâmentro $name.
     * Na ausência do parâmetro $content, retorna o conteúdo do arquivo referente ao parâmentro $name.
     * 
     * @param <string> $name
     * @param <string> $content
     * @return <bool || string>
     */
    static function _log($name, $content = null) {
        return !$content ? self::get($name) : self::write($name, $content);
    }

    /**
     * 
     * @param type $name
     * @param type $content
     * 
     * @return boolean
     */
    static function write($name, $content) {
        if (!($file = fopen(self::$path . $name, 'a')))
            return false;

        fwrite($file, $content . self::$line_end);
        fclose($file);

        return true;
    }

    /**
     * 
     * @param type $name
     * @return string
     */
    static function get($name) {
        return file_get_contents(self::$path . $name);
    }

    /**
     * 
     * @param type $name
     * 
     * @return boolean
     */
    static function destroy($name) {
        return unlink(self::$path . $name);
    }

}
