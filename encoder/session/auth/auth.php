<?php

class Auth {

    /**
     * Nome da classe do Model que corresponde à tabela de usuários.
     * 
     * @var <string>
     */
    static $model;

    /**
     * Nome do campo na tabela de usuários que representao nome de usuário.
     * 
     * @var <string>
     */
    static $username_field;

    /**
     * Nome do campo na tabela de usuários que representao nome de usuário.
     * 
     * @var <string>
     */
    static $password_field;

    /**
     * Nome do campo na tabela de usuários que representao a senha.
     * 
     * @var <string>
     */
    static $active_field;

    /**
     * Campos que serão salvos na sessão quando o usuário se conectar.
     * 
     * @var <string>
     */
    static $fields;

    /**
     * Índice da sessão que ficará salvo os dados do usuário.
     * 
     * @var <string>
     */
    static $session_key;

    /**
     * Nome da hierarquia do usuário quando ele não estiver conectado.
     * 
     * @var <string>
     */
    static $default_hierarchy;

    /**
     * Máximo de tentativas de login sem 
     * sucesso até a conta do usuário ser bloqueada.
     * @var int
     */
    static $max_login_attempts = 5;

    /**
     * Método utilizado para encriptar a senha do usuário.
     * 
     * @var <function($password)>
     */
    static $encrypt;

    static function init() {
        init('auth');
    }

    /**
     * Inicia a sessão de um usuário.
     * 
     * @param <string> $username
     * @param <string> $password
     * 
     * @return int 0 user not found
     * @return int -1 password expired
     * @return int -2 password invalid
     * @return int -3 account not confirmed
     * @return int -4 account disabled
     * @return int -5 account blocked
     */
    static function login($username, $password) {
        $model = self::$model;

        # buscando usuário
        $user = $model::first(array('where' => array(self::$username_field => $username)));

        # nenhum usuário com o email informado
        if (empty($user))
            return 0;

        $code = 1;
        $field_password = self::$password_field;
        $field_active = self::$active_field;

        # senha expirada
        if (!empty($user->hash_password_expired)) {
            $user->login_attempts++;
            $code = -1;
        }

        # usuário com conta bloqueada.
        else if ($user->login_attempts >= (self::$max_login_attempts - 1)) {
            # <implements{self::email_unlock_account($user)}> enviar email para desbloquear a conta.

            $user->hash_unlock_account = $user->hash_unlock_account ? : random(32);
            $user->login_attempts++;
            $code = -5;
        }

        # senha inválida
        else if ($user->$field_password != $password) {
            $user->login_attempts++;
            $code = -2;
        }

        # conta não confirmada
        else if (!empty($user->hash_confirm_account)) {
            # $user->login_attempts++;
            $code = -3;
        }

        # usuário com conta desativada.
        else if ($user->$field_active == 'f' || !$user->$field_active) {
            # $user->login_attempts++;
            $code = -4;
        }

        # usuário com dados corretos para login
        if ($code == 1) {
            $user->last_login = date('Y-m-d H:i:s');
            $user->login_attempts = 0;
            $user->login_count++;
        } else {
            # banir conta
            if ($user->login_attempts >= 99) {
                $user->$field_active = false;
                $user->login_attempts = 99;
            }
        }

        # editando dados do usuário
        $user->edit();

        # verificamos se ocorreu algum erro
        if ($code <= 0)
            return $code;

        # definindo sessão
        $session = array();
        foreach (self::$fields as $field)
            $session[$field] = $user->$field;

        return self::session((object) $session);
    }

    /**
     * Destrói a sessão do usuário conectado.
     * 
     * return <void>
     */
    static function logout() {
        return Session::destroy('auth');
    }

    /**
     * Obtém um ou mais dados da sessão do usuário.
     * 
     * @param <string> $field
     * @return <string>
     */
    static function user($field = null) {
        $auth = session('auth');

        # caso o usuário deseje obter apenas um campo do usuário.
        if ($field != null)
            return @$auth[self::$session_key]->$field;

        return @$auth[self::$session_key];
    }

    /**
     * Escreve os dados do usuário na sessão.
     * 
     * @param Model $user
     */
    private function session($user) {
        return Session::set('auth', array(
                    self::$session_key => $user
        ));
    }

    /**
     * Obtém a hierarquia do usuário atual.
     * 
     * @return <string>
     */
    static function hierarchy() {
        return self::user('hierarchy') ? : Auth::$default_hierarchy;
    }

    /**
     * Encriptar o password do usuário.
     * 
     * @param <string> $password
     * 
     * @return <string>
     */
    static function encrypt($password) {
        return self::$encrypt->__invoke($password);
    }

    /**
     * Send user email with instructions to create new password.
     * 
     * @param auth\Model $user
     * 
     * @return int -1 error on edit user record
     * @return bool email sent
     */
    static function password_forgot_email(auth\Model &$user) {
        $user->hash_password_forgot = random();

        if (!$user->edit('email'))
            return -1;

        # obtendo a mensagem que será enviada e enviamos o e-mail.
        $m = view('offline/users/emails/password_forgot', array('user' => $user), 'email');
        return Mail::send($user->email, 'site contato', $m);
    }

    /**
     * Send user email with instructions to Renew the password.
     * 
     * @param auth\Model $user
     * 
     * @return int -1 error on edit user record
     * @return bool email sent
     */
    static function password_expired_email($user) {
        $user->hash_password_expired = random();

        if (!$user->edit('email'))
            return -1;

        # obtendo a mensagem que será enviada e enviamos o e-mail.
        $m = view('offline/users/emails/password_expired', array('user' => $user), 'email');
        return Mail::send($user->email, 'site contato', $m);
    }

    /**
     * Envia um email com as instruções para alterar a 
     * senha do usuário correspondente ao Model do parâmetro.
     * 
     * @param Model $user
     * 
     * @return int -1 account confirmed
     * @return int -2 error on edit user
     * @return bool sended email
     */
    static function confirm_account_email($email) {
        $model = self::$model;

        $u = $model::first(array(
                    'fields' => 'id, name, email, hash_confirm_account',
                    'where' => "email = '$email'"
        ));

        # account confirmed
        if (empty($u->hash_confirm_account))
            return -1;

        return mail_by_view($u->email, 'Confirmar Conta', 'offline/users/emails/confirm_account', array('user' => $u));
    }

    /**
     * Send email for uuser Unlock Account
     * 
     * @param string $email of the user who will be unlocked account
     * 
     * @return int -1 user not found
     * @return int -2 account not blocked
     * @return int -3 error on edit user record
     * @return int -4 error on send email
     * @return auth\Model $user email sent
     */
    static function unlock_account_email($email) {
        $model = self::$model;

        $user = $model::first(array(
                    'fields' => 'id, name, email, login_attempts',
                    'where' => "email = '$email'"
        ));

        if (empty($user))
            return -1;

        if ($user->login_attempts <= static::$max_login_attempts)
            return -2;

        $user->hash_unlock_account = random();
        if (!$user->edit())
            return -3;

        $m = view('offline/users/emails/unlock_account', array('user' => $user), 'email');
        if (!Mail::send($user->email, 'site contato', $m))
            return -4;

        return $user;
    }

    /**
     * 
     * @param type $hash
     * 
     * @return <int> -1 > user not found
     * @return <int> -2 > error on edit user
     */
    static function confirm_account($hash) {
        $model = self::$model;

        $user = $model::first(array(
                    'fields' => 'id, hash_confirm_account',
                    'where' => "hash_confirm_account = '$hash'"
        ));

        if (empty($user))
            return -1;

        if (empty($user->hash_confirm_account))
            return -2;

        $user->hash_confirm_account = '';

        if (!$user->edit())
            return -3;

        return true;
    }

    /**
     * 
     * @param string $hash
     * @param string $password
     * 
     * @return integer -1 email not pertence a user
     * @return integer -2 error on edit user
     */
    static function password_edit($email, $password) {
        $model = self::$model;

        # verificando se ha algum usuário com a hash.
        $user = $model::first(array(
                    'fields' => 'id',
                    'where' => "email = '$email'"
        ));

        # usuário não encontrado por email
        if (empty($user))
            return -1;

        $user->password = auth_encrypt($password);
        $user->hash_password_forgot = '';
        $user->hash_password_expired = '';

        if (!$user->edit())
            return -2;

        return true;
    }

    /**
     * Unlock user account by hash
     * 
     * @param $hash refered of the user who will be unlocked account
     * 
     * @return int -1 user hash not found
     * @return int -2 error on edit user record
     * @return auth\Model $user successfully unlocked account
     */
    static function unlock_account($hash) {
        $model = self::$model;

        $user = $model::first(array(
                    'fields' => 'id, name, email, login_attempts',
                    'where' => "hash_unlock_account = '$hash'"
        ));

        if (empty($user))
            return -1;

        $user->login_attempts = 0;
        if (!$user->edit())
            return -2;

        return $user;
    }

}
