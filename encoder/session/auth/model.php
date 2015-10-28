<?php

namespace auth;

class Model extends \Model {

    static $table = 'users';
    static $validate = array(
        
        # login
        'not_empty {email, password} {login}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {email} {login}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 92
        ),
        
        # sign_up
        'not_empty {name, documentation, phone, email, password, address_zipcode, address_state, address_city, address_street, address_neighborhood, address_number} {sign_up}' => array(
            'É obrigatório preencher este campo.',
        ),
        'numeric {address_number} {sign_up}' => array(
            'Este valor não é numérico.'
        ),
        'strmax {name, email, address_zipcode, address_state, address_city, address_street, address_neighborhood, address_number, address_complement} {sign_up}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 124
        ),
        'strmin {name, email} {sign_up}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'cpf {documentation} {sign_up}' => array(
            'Insira um CPF no formato xxx.xxx.xxx-xx'
        ),
        'phone {phone} {sign_up}' => array(
            'Insira um telefone no formato (dd) xxxx-xxxx'
        ),
        'unique {documentation, email} {sign_up}' => array(
            'Já existe um registro com este valor.'
        ),
        
        # password_forgot_email onfirm_account_email password_expired_email
        'not_empty {email} {confirm_account_email, password_forgot_email, password_expired_email, unlock_account_email}' => array(
            'É obrigatório preencher este campo.',
        ),
        'email {email} {confirm_account_email, password_forgot_email, password_expired_email, unlock_account_email}' => array(
            'Este e-mail não é válido.',
        ),
        'strmax {email} {confirm_account_email, password_forgot_email, password_expired_email, unlock_account_email}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 92
        ),
        'exists {email} {confirm_account_email, password_forgot_email, password_expired_email, unlock_account_email}' => array(
            'Não há registro com este e-mail.'
        ),
        
        # login sign_up password_forgot password_expired
        'not_empty {password} {sign_up, password_forgot, password_expired}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {password} {sign_up, password_forgot, password_expired}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 32
        ),
        'strmin {password} {sign_up, password_forgot, password_expired}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'confirm {password_confirm} {sign_up, password_forgot, password_expired}' => array(
            'As senhas não conferem.',
            'compare_to' => 'password'
        ),
    );
//    static $validate = array(
//
//        # sign_up
//        'not_empty {name, documentation, phone, email, password, address_zipcode, address_state, address_city, address_street, address_neighborhood, address_number} {sign_up}' => array(
//            'É obrigatório preencher este campo.',
//        ),
//        'numeric {address_number} {sign_up}' => array(
//            'Este valor não é numérico.'
//        ),
//        'strmax {name, email, password, address_zipcode, address_state, address_city, address_street, address_neighborhood, address_number, address_complement} {sign_up}' => array(
//            'Insira no máximo :max caracteres.',
//            'max' => 92
//        ),
//        'strmin {name, email} {sign_up}' => array(
//            'Insira no mínimo :min caracteres.',
//            'min' => 5
//        ),
//        'confirm {password_confirm} {sign_up, password_forgot, password_expired}' => array(
//            'As senhas não conferem.',
//            'compare_to' => 'password'
//        ),
//        'cpf {documentation} {sign_up}' => array(
//            'Insira um CPF no formato xxx.xxx.xxx-xx'
//        ),
//        'phone {phone} {sign_up}' => array(
//            'Insira um telefone no formato (dd) xxxx-xxxx'
//        ),
//        'unique {documentation, email} {sign_up}' => array(
//            'Já existe um registro com este valor.'
//        ),
//        
//        # password_forgot, password_expired
//        'not_empty {password} {password_forgot, password_expired}' => array(
//            'É obrigatório preencher este campo.',
//        ),
//        'strmin {password} {password_forgot, password_expired}' => array(
//            'Insira no mínimo :min caracteres.',
//            'min' => 5
//        ),
//        'strmax {password} {password_forgot, password_expired}' => array(
//            'Insira no máximo :max caracteres.',
//            'max' => 92
//        ),
//
//        # login
//        'not_empty {email, password} {login}' => array(
//            'É obrigatório preencher este campo.',
//        ),
//        'strmin {email, password} {login}' => array(
//            'Informe seu e-mail completo.',
//            'min' => 5
//        ),
//        'strmax {email, password} {login}' => array(
//            'Insira no máximo :max caracteres.',
//            'max' => 92
//        ),
//
//        # password_forgot, password_expired, unlock_account
//        'not_empty {email} {password_forgot, password_expired, unlock_account}' => array(
//            'É obrigatório preencher este campo.',
//        ),
//        'email {email} {password_forgot, password_expired, unlock_account}' => array(
//            'Este e-mail não é válido.',
//        ),
//        'strmax {email} {password_forgot, password_expired, unlock_account}' => array(
//            'Insira no máximo :max caracteres.',
//            'max' => 92
//        ),
//        'exists {email} {password_forgot, password_expired, unlock_account}' => array(
//            'Não há registro com este e-mail.'
//        ),
//
//        # confirm_account
//        'not_empty {email} {confirm_account}' => array(
//            'É obrigatório preencher este campo.',
//        ),
//        'strmin {email} {confirm_account}' => array(
//            'Informe seu e-mail completo.',
//            'min' => 5
//        ),
//        'strmax {email} {confirm_account}' => array(
//            'Insira no máximo :max caracteres.',
//            'max' => 92
//        ),
//        'exists {email} {confirm_account}' => array(
//            'Não há registro com este e-mail.'
//        ),
//
//        # validar e-mail para todas as actions
//        'email {email} {login, password_forgot, password_expired, sign_up}' => array(
//            'Este email não é válido',
//        ),
//    );
    static $event = array(
        'before:save' => array('typograph', 'set_address'),
    );

    protected static function typograph($user) {
        #logical
        $user->hash_confirm_account = base64_encode(sha1($user->email . date('dmYHis')));

        # identification
        $user->name = @mb_strtoupper($user->name);

        # address
        $user->address_state = mb_strtoupper($user->address_state);
        $user->address_city = mb_strtoupper($user->address_city);
        $user->address_street = mb_strtoupper($user->address_street);
        $user->address_neighborhood = mb_strtoupper($user->address_neighborhood);
        $user->address_number = mb_strtoupper($user->address_number);
        $user->address_zipcode = mb_strtoupper($user->address_zipcode);

        # account
        $user->email = mb_strtolower($user->email);
        $user->password = \Auth::encrypt($user->password);
    }

    protected static function set_address($user) {
        $user->address = json(array(
            'state' => $user->address_state,
            'city' => $user->address_city,
            'street' => $user->address_street,
            'neighborhood' => $user->address_neighborhood,
            'number' => $user->address_number,
            'zipcode' => $user->address_zipcode
        ));
    }

}
