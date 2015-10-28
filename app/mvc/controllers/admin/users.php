<?php

namespace admin;

class Users extends \Controller {

    static function index() {
        
    }

    static function paginate() {
        view_var('transactions', paginate_find('Transaction', array(
            'limit' => 10,
        )));
    }
    
    static function logout() {
        logout();
        go();
    }
}
