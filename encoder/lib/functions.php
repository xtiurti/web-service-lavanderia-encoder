<?php

/** @PhpCalls */ {

    require_once CORE . 'lib' . DS . 'dir.php';

    /**
     * Inclui automaticamente uma classe a nossa aplicação.
     * 
     * @param <string> $name >> nome da classe que será carregada.
     */
    function encoder_autoload($name) {
        # echo $name . ' >> ' . Dir::app_file_path($name) . '<br>';
        require_once Dir::app_file_path($name);

        # chamamos o método simulador a um construtor estático.
        if (method_exists($name, 'init'))
            $name::init();
    }

    spl_autoload_register('encoder_autoload');
}


/** @Basics */ {

    function globals($name = null, $value = null) {
        return App::globals($name, $value);
    }

    function timer() {
        return App::timer();
    }

    function session($key = null, $value = null) {
        return Session::_session($key, $value);
    }

    function app_log($name, $content = null) {
        return Log::_log($name, $content);
    }

    function init($file) {
        return App::init_class($file);
    }

    function mail_by_view($to, $subject, $view, $data = array()) {
        return Mail::by_view($to, $subject, $view, $data);
    }
    
    function send($to, $subject, $message) {
        return Mail::send($to, $subject, $message);
    }

    /**
     * Responde uma requisição no formato JSON.
     * 
     * @param <?> $content
     */
    function response_ajax($content) {
        die(json($content));
    }

    /**
     * Comprimi uma string retirando todos seus espaços.
     * 
     * @param <string> $string
     * @return <string>
     */
    function compress($string) {
        $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace = array('>', '<', '\\1');
        return preg_replace($search, $replace, $string);
    }

    /**
     * Gera um código alphanumeric aleatório.
     * 
     * @param <int> $length
     * @param <function(code)> $method_return
     * 
     * @return <string>
     */
    function random($length = 32, $method_return = null) {
        $code = bin2hex(openssl_random_pseudo_bytes($length));
        return $method_return ? $method_return($code) : $code;
    }

    /**
     * Captura todos os últimos galhos de um Array 
     * independente de quantos sub-galhos o mesmo tenha.
     * 
     * @param array $array que será capturado os últimos galhos
     * @param array $match recipiente para os últimos galhos
     * @param int $cb número do galho atual
     */
    function array_last_branches(Array $array, &$match, $cb = 0) {
        foreach ($array as $key => $value)
            is_array($value) ? array_last_branches($value, $match, $cb++) : $match[$cb][] = $value;
    }

}


/** @Route */ {

    function url_call() {
        return Route::url_call();
    }

    function go($route = null) {
        Route::go($route ? : '/' . hierarchy());
    }

    function url_go($url) {
        Url::go($url);
    }

    function locale() {
        return Route::locale();
    }

}


/** @Parsers */ {

    /**
     * Tranforma uma string em um array
     * 
     * :key value :key value
     * 
     * @param <string> $str
     * 
     * @return <array>
     */
    function a($str) {
        preg_match_all("/:(.*?) /", ($str = $str . ':'), $matches);

        $a = array();
        foreach ($matches[1] as $key => $ind) {
            preg_match("/$ind(.*?):/", $str, $sub_matches);
            @$a[$ind] = $sub_matches[1];
        }

        return $a;
    }

    /**
     * Converte o conteúdo de uma variável para JSON.
     * 
     * @return <string>
     */
    function json($content) {
        return json_encode($content);
    }

    /**
     * print_r() convenience function
     *
     * In terminals this will act similar to using print_r() directly, when not run on cli
     * print_r() will also wrap <pre> tags around the output of given variable. Similar to debug().
     *
     * @param mixed $var Variable to print out
     * @return void
     * @see debug()
     * @link http://book.cakephp.org/3.0/en/core-libraries/global-constants-and-functions.html#pr
     * @see debug()
     */
    function pr($var) {
        $template = php_sapi_name() !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
        printf($template, print_r($var, true));
    }

}


/** @Files */ {

    /**
     * Obtém o conteúdo de um arquivo.
     * 
     * @param <string> $relative_path Caminho do arquivo apartir da raiz da aplicação, ROOT.
     * 
     * @return <string>
     */
    function content($relative_path) {
        return file_get_contents(ROOT . $relative_path);
    }

    /**
     * Verifica se um determinado arquivo existe.
     * 
     * @param <string> $class >> nome da completo da classe
     * @return <boolean>
     */
    function exists($app_file) {
        return file_exists(str_replace(array('\\', '/'), DS, strtolower(ROOT . $app_file . '.php')));
    }

}


/** @Auth */ {

    /* Basic functions */ {

        function user($key = null) {
            return Auth::user($key);
        }

        function user_first_name() {
            $name = user('name');
            $name = explode(' ', $name);
            return ucfirst(strtolower($name[0]));
        }

        function hierarchy() {
            return Auth::hierarchy();
        }

        function login($username, $password) {
            return Auth::login($username, $password);
        }

        function logout() {
            return Auth::logout();
        }

        function auth_encrypt($pass) {
            return Auth::encrypt($pass);
        }

    }

    /* Email functions */ {

        function password_forgot_email(auth\Model &$user) {
            return Auth::password_forgot_email($user);
        }

        function password_expired_email($email) {
            return Auth::password_expired_email($email);
        }

        function unlock_account_email($email) {
            return Auth::unlock_account_email($email);
        }

        function confirm_account_email($email) {
            return Auth::confirm_account_email($email);
        }

    }

    /* Hash functions */ {
        
        function confirm_account($hash) {
            return Auth::confirm_account($hash);
        }

        function unlock_account($hash) {
            return Auth::unlock_account($hash);
        }
        
        function password_edit($email, $new_password) {
            return Auth::password_edit($email, $new_password);
        }
    }
}


/** @Date */ {

    /**
     * Explode uma data em todos seus elementos.
     * 
     * @param <string> $date
     * @param <string> $input_format
     * 
     * @return <array>
     */
    function date_explode($date, $input_format = 'Y-m-d H:i:s') {
        $date_explode = array();
        $date = preg_replace('/[^0-9]/', '', $date);
        $input_format = preg_replace('/[^a-zA-Z]/', '', $input_format);

        foreach (str_split($input_format) as $l) {
            $date_explode[$l] = substr($date, 0, ($e = strlen(date($l))));
            $date = substr($date, $e, strlen($date));
        }

        return $date_explode;
    }

    /**
     * Obtém apenas um elementro da data.
     * 
     * @param <string> $date
     * @param <string> $extrapt
     * @param <string> $input_format
     * 
     * @return <string>
     */
    function date_extrapt($date, $extrapt, $input_format = 'Y-m-d H:i:s') {
        $date = date_explode($date, $input_format);
        return @$date[$extrapt];
    }

    /**
     * Formata todos os elementro uma data.
     * 
     * @param <string> $date
     * @param <string> $extrapt
     * @param <string> $input_format
     * 
     * @return <string>
     */
    function date_template($date, $input_format = 'Y-m-d H:i:s', $output_format = 'd/m/Y H:i:s') {
        foreach (date_explode($date, $input_format) as $l => $d)
            $output_format = str_replace($l, $d, $output_format);
        return $output_format;
    }

    /**
     * Obtém o nome do mês referente ao número do parâmetro.
     * @param type $number
     * @return type
     */
    function month_pt_br($number) {
        return Date::month_pt_br($number);
    }

}


/** @View */ {

    function view($view, $vars = array(), $layout = null) {
        return View::partial($view, $vars, $layout);
    }

    function render($view, $vars = array(), $layout = null) {
        View::render($view, $vars, $layout);
    }

    function element($element, $vars = array(), $layout = null) {
        return View::element($element, $vars, $layout);
    }

    function view_yield() {
        return View::content();
    }

    /**
     * Define uma variável de visão no controller que chamou está função.
     * 
     * @param <string> $var
     * @param <?> $value
     */
    function view_var($var, $value) {
        $controller = debug_backtrace(-1);
        $controller = $controller[1]['class'];
        $controller::$view_vars[$var] = $value;
    }

    /**
     * Após retornar à visão com dados de formulário, é possível obter o valor 
     * de um campo através desta função, utilizando o nome do campo.
     * 
     * @param <string> $key
     * @param <string> $method
     * @return <?>
     */
    function request_value($key, $method = 'post') {
        # se não for array retornamos o valor
        if (stripos($key, ']') === false) {
            $method = Request::$$method;
            return @$method[$key] ? : '';
        }

        # obtendo indíces do array
        $ls = explode('[', $key);
        foreach ($ls as $k => $l)
            $ls[$k] = substr($l, strlen($l) - 1) == ']' ? substr($l, 0, -1) : $l;

        $post = Request::$$method;
        for ($i = 0; is_array($post); $i++) {
            # verificando se existe o indíce
            if (!array_key_exists($ls[$i], $post))
                return null;

            $post = $post[$ls[$i]];
        }

        return $post;
    }

}


/** @Validates */ {

    /**
     * Efetua validação de um valor a partir de um método.
     * 
     * @param <string> $method
     * @param <string> $value
     * 
     * @return <string>
     */
    function is($method, $value) {
        return Validate::$method($value);
    }

    function format($method, $value) {
        return Format::$method($value);
    }

    function validate($model) {
        return $model->validate();
    }

}


/** @Request */ {

    function data($key = null, $method = 'post') {
        return Request::data($key, $method);
    }

    function csfr_validation() {
        return Request::csfr_validation(data('csfr'));
    }

    function is_post() {
        return Request::is_post();
    }

    function is_ajax() {
        return Request::is_ajax();
    }

    function ip() {
        return Request::ip();
    }

}


/** @Html */ {

    function css($files) {
        return Html::css($files);
    }

    function js($files) {
        return Html::js($files);
    }

    /**
     * Retorna uma URL completa, para acessar alguma rota da aplicação.
     * 
     * @param <string> $route
     * @return <string>
     */
    function url($route = null) {
        return $route ? Route::gen($route) : URL_CURRENT;
    }

    function input_csfr() {
        return Request::input_csfr();
    }

    function post_button($form_content, $url, $form_attrs = '') {
        return Html::post_button($form_content, $url, $form_attrs);
    }

}


/** @Form */ {

    function form_open($action = null) {
        return Form::open($action);
    }

    function form_close() {
        return Form::close();
    }

    function input_message($model, $field) {
        return Form::message($model, $field);
    }

    function input_id($model, $field) {
        return 'id="' . Form::input_id($model, $field) . '"';
    }

    function input_value($model, $field) {
        $val = Form::value($model, $field);
        return empty($val) ? ' value=""' : ' value="' . $val . '"';
    }

    function input_label($text, $model, $field) {
        return Form::label($text, $model, $field);
    }

    function input_id_value($model, $field) {
        return input_id($model, $field) . input_value($model, $field);
    }

    function input_label_message($text, $model, $field) {
        return input_label($text, $model, $field) . input_message($model, $field);
    }

}


/** @Flash */ {

    function flash($message, $element = 'success', $escope = null) {
        Flash::set($message, 'toastr' . DS . $element, $escope);
    }

    function flashes($scope = null) {
        return Flash::get($scope);
    }

}


/** @Dir */ {

    function class_file_exists($class_name) {
        return @Dir::app_file_path($class_name) ? : true;
    }

    function dir_to_array($dir) {
        return Dir::to_array($dir);
    }

    function classname_path_files($dir) {
        return Dir::classname_path_files($dir);
    }

    function dir_create($dir) {
        return Dir::create($dir);
    }

}

/** @Paginate */ {

    function paginate_find($model, $options = array()) {
        Paginate::$model = $model;
        return Paginate::find($options);
    }

    function paginate_page_back() {
        return Paginate::page_back();
    }

    function paginate_page_current() {
        return Paginate::page_current();
    }

    function paginate_page_forward() {
        return Paginate::page_forward();
    }

    function paginate_total_records() {
        return Paginate::total_records();
    }

    function paginate_total_pages() {
        return Paginate::total_pages();
    }

    function paginate_record_start() {
        return Paginate::record_start();
    }

    function paginate_record_forward() {
        return Paginate::record_forward();
    }

    function paginate_url_back() {
        return Paginate::url_back();
    }

    function paginate_url_forward() {
        return Paginate::url_forward();
    }

    function paginate_page_exists($page) {
        return Paginate::page_exists($page);
    }

    function paginate_page_current_exists() {
        return Paginate::page_current_exists();
    }

    function paginate_href_page_back() {
        return Paginate::href_url_back();
    }

    function paginate_href_page_forward() {
        return Paginate::href_url_forward();
    }

}