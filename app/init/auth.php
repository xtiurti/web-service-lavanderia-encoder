<?php

Auth::$model = 'offline\User';
Auth::$username_field = 'email';
Auth::$password_field = 'password';
Auth::$active_field = 'active';
Auth::$fields = array('id', 'name', 'email', 'hierarchy', 'active');
Auth::$default_hierarchy = 'offline';

# cada aplicação desenvolvida neste framework deve possuir um índice diferente na sessão.
Auth::$session_key = sha1(Url::$application);

Auth::$encrypt = function($password) {
    return md5($password);
};