<?php

# configurações básicas de cabeçalho.
ini_set('display_errors', 'On');
ini_set('default_charset', 'UTF-8');

# constants
define('DS', DIRECTORY_SEPARATOR);
define('SERVER', str_replace(['\\', '/'], DS, $_SERVER['DOCUMENT_ROOT']));
define('URI', str_replace(['\\', '/', 'index.php'], [DS, DS, ''], $_SERVER['SCRIPT_NAME'])); # verificar se em servidor Win a barra deve ser invertida.
define('ROOT', SERVER . URI);
define('APP', ROOT . 'app' . DS);

define('CORE', ROOT . 'encoder' . DS);
define('LIB', CORE . 'lib' . DS);
define('INIT', APP . 'init' . DS);
define('MVC', APP . 'mvc' . DS);
define('ASSETS', 'app/mvc/views/@assets/');

## iniciamos nossa aplicação aqui
require INIT . 'app.php';
