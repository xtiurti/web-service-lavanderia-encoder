<?php

class Dir {

    private static $class_path_files;

    /**
     * Converte uma arvorá diretória para um array com seus subníveis.
     * 
     * @param <string> $dir
     * @return <array>
     */
    static function to_array($dir) {
        $result = array();

        foreach (scandir($dir) as $key => $value) {
            if (!in_array($value, array('.', '..'))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                    $result[$value] = dir_to_array($dir . DIRECTORY_SEPARATOR . $value);
                else
                    $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * Obtém todos as classes juntamente com seu 
     * namespace e caminho de diretório que está armazenada.
     * 
     * @param <string> $dir
     * @return <array>
     */
    static function classname_path_files($dir = null) {
        $dir = $dir ? : ROOT;
        $class_paths = array();

        foreach (new RegexIterator(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)), '/\.php$/') as $file) {
            $namespace = '';            
            $tokens = token_get_all(file_get_contents($file->getRealPath()));

            for ($i = 0; isset($tokens[$i]); $i++) {
                if (isset($tokens[$i][0])) {
                    if (T_NAMESPACE === $tokens[$i][0]) {
                        $i += 2; # skip namespace keyword and whitespace
                        while (isset($tokens[$i]) && is_array($tokens[$i]))
                            $namespace .= $tokens[$i++][1];
                    }
                    
                    if (T_CLASS === $tokens[$i][0]) {
                        $namespace .= $namespace ? '\\' : '';
                        ($i += 2) & $class_paths[$namespace . $tokens[$i][1]] = $file->getRealPath();
                    }
                }
            }
        }

        return $class_paths;
    }

    static function app_file_path($class_name = null) {
        if (empty(self::$class_path_files))
            self::$class_path_files = self::classname_path_files(ROOT);

        return !$class_name ? self::$class_path_files : @self::$class_path_files[$class_name];
    }

    static function create($dir) {
        return file_exists($dir) ? true : mkdir($dir, 0777, true);
    }

}
