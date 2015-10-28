<?php

namespace offline;

class Users extends \auth\Controller {

    static function login() {
        parent::login();
        view_var('user', globals('user'));
    }

    static function sign_up() {
        parent::sign_up();
        view_var('user', globals('user'));
    }
    
    /* email methods */

    static function password_forgot_email() {
        parent::password_forgot_email();
        view_var('user', globals('user'));
    }

    static function confirm_account_email() {
        parent::confirm_account_email();
        view_var('user', globals('user'));
    }

    static function password_expired_email() {
        parent::password_expired_email();
        view_var('user', globals('user'));
    }

    static function unlock_account_email() {
        parent::unlock_account_email();
        view_var('user', globals('user'));
    }

    /* hash and view methods */

    static function password_forgot() {
        parent::password_forgot();
        view_var('user', globals('user'));
    }

    static function password_expired() {
        parent::password_expired();
        view_var('user', globals('user'));
    }

}
