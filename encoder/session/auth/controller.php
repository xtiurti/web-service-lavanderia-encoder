<?php

namespace auth;

class Controller extends \Controller {

    static function login() {
        $model = \Auth::$model;
        $user = $model::requested();

        if (!$user->nil()) {
            if ($user->validate()) {
                $code = login($user->email, $user->password);

                if ($code == 0 || $code == -2)
                    flash('Combinação de e-mail e senha inválida.', 'error');
                else if ($code == -1) {
                    flash('Sua senha está expirada, é necessário criar uma nova.', 'warning');
                    render('offline/users/password_expired_email', array('user' => $user), 'offline');
                } else if ($code == -3)
                    flash('Sua conta não foi confirmada.', 'warning');
                else if ($code == -4)
                    flash('Sua conta está inativa.', 'warning');
                else if ($code == -5)
                    flash('Sua conta está bloqueada.', 'warning');
                else
                    go();# conectou
            } else {
                flash('Verifique os dados do formulário.', 'error');
            }
        }

        globals('user', $user);
    }

    static function sign_up() {
        $model = \Auth::$model;
        $user = $model::requested();

        # verificando se existem dados para o modelo (POST) e efetuando a validação dos mesmo.
        if (!$user->nil()) {
            if ($user->validate()) {
                if ($user->save()) {
                    if (confirm_account_email($user->email)) {
                        flash("Cadastro Efetuado!");
                        render('offline/users/confirm_account', array(
                            'user' => $user
                        ), 'offline');
                    } else {
                        $user->del();
                        flash('Não foi lhe enviar o e-mail. Por favor, tente novamente mais tarde.', 'error') & go('/');
                    }
                } else {
                    flash('Não possível criar seu registro neste momento. Por favor, tente novamente mais tarde.', 'error') & go('/');
                }
            } else {
                flash('Verifique os dados do formulário.', 'error');
            }
        }

        globals('user', $user);
    }

    # ------------- #
    # EMAIL METHODS #
    # ------------- #

    static function password_forgot_email() {
        # verificando se existem dados para o modelo (POST).
        $model = \Auth::$model;
        $user = $model::requested();

        if (!$user->nil()) {
            if ($user->validate()) {

                password_forgot_email($user) ?
                                flash("Enviamos um e-mail para <small><b>$user->email</b></small> com as instruções para você criar uma nova senha.") :
                                flash('Não foi possível lhe enviar o e-mail. Por favor, tente novamente mais tarde.', 'error');

                go('/');
            } else {
                flash('Verifique os dados do formulário.', 'error');
            }
        }

        globals('user', $user);
    }

    static function confirm_account_email() {
        # verificando se existem dados para o modelo (POST).
        $model = \Auth::$model;
        $user = $model::requested();

        if (!$user->nil()) {
            if ($user->validate()) {
                $code = confirm_account_email($user->email);

                if ($code === -1) {
                    flash('Sua conta já está confirmada, basta acessá-la.', 'warning');
                } else if ($code == true)
                    flash("Enviamos um e-mail para <small><b>$user->email</b></small> com as instruções para você confirmar sua conta.");
                else
                    flash('Não foi possível lhe enviar o e-mail. Por favor, tente novamente mais tarde.', 'error');

                go('/');
            } else {
                flash('Verifique os dados do formulário.', 'error');
            }
        }

        globals('user', $user);
    }

    static function password_expired_email() {
        # verificando se existem dados para o modelo (POST).
        $model = \Auth::$model;
        $user = $model::requested();

        if (!$user->nil()) {
            if ($user->validate()) {

                password_expired_email($user) ?
                                flash("Enviamos um e-mail para <small><b>$user->email</b></small> com as instruções para você criar uma nova senha.") :
                                flash('Não foi possível lhe enviar o e-mail. Por favor, tente novamente mais tarde.', 'error');

                go('/');
            } else {
                flash('Verifique os dados do formulário.', 'error');
            }
        }

        globals('user', $user);
    }

    static function unlock_account_email() {
        $model = \Auth::$model;
        $user = $model::requested();

        if (!$user->nil()) {
            if ($user->validate()) {
                $code = unlock_account_email($user->email);

                if ($code == -1) {
                    flash('Sua conta não está bloqueada.', 'error');
                } else if ($code == -2) {
                    flash('Sua conta não está bloqueada.', 'warning');
                } else if ($code == -3) {
                    flash('Não foi possível desbloquear sua conta neste momento. Por favor, tente mais tarde.', 'error');
                } else {
                    flash("Enviamos um email para <small><b>$user->email</b></small> com as instruções para Desbloquear a conta.");
                }

                go('/');
            } else {
                flash('Verifique os dados do formulário.', 'error');
            }
        }

        globals('user', $user);
    }

    # ------------ #
    # HASH METHODS #
    # ------------ #

    /**
     * Releases the vision to edit the password from the hash.
     */
    static function password_forgot() {
        $model = \Auth::$model;

        # hash GET param exists
        if (!$hash = data('hash'))
            go('/');

        # user hash exists
        $user = $model::first(array(
                    'fields' => 'id, email, name',
                    'where' => "hash_password_forgot = '$hash'"
        ));

        if (empty($user))
            go('/');

        # POST passwords sent
        if ($model::data()) {
            $user->password = $model::data('password');
            $user->password_confirm = $model::data('password_confirm');

            # validate passwords
            if ($user->validate()) {
                $user->password = auth_encrypt($user->password);
                $user->hash_password_forgot = '';

                $user->edit() ?
                                flash('Sua senha foi alterada com sucesso.') :
                                flash('Algo ocorreu errado. Entre em contrato com a empresa.', 'error');

                go('/');
            }
        }

        globals('user', $user);
    }

    /**
     * Confirm user account by hash.
     */
    static function confirm_account() {
        
        # hash GET param exists
        if ($hash = data('hash')) {
            
            $hash = confirm_account($hash);

            if ($hash === -3)
                flash('Algo ocorreu errado. Tente novamente mais tarde..', 'error');
            else if ($hash === true)
                flash('Conta Confirmada! Agora você já pode se conectar.');
        }

        go('/');
    }

    /**
     * Releases the vision to renew the password from the hash.
     */
    static function password_expired() {
        $model = \Auth::$model;

        # hash GET param exists
        if (!$hash = data('hash'))
            go('/');

        # user hash exists
        $user = $model::first(array(
                    'fields' => 'id, email, name',
                    'where' => "hash_password_expired = '$hash'"
        ));

        if (empty($user))
            go('/');

        # POST passwords sent
        if ($model::data()) {
            $user->password = $model::data('password');
            $user->password_confirm = $model::data('password_confirm');

            # validate passwords
            if ($user->validate()) {
                
                # password edit
                $code = password_edit($user->email, $user->password);

                # check status
                if ($code === -2)
                    flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
                else if ($code === true)
                    flash('Sua senha foi renovada com sucesso.');

                go('/');
            }
        }

        globals('user', $user);
    }

    /**
     * Unlock account user by hash.
     */
    static function unlock_account() {
        $model = \Auth::$model;

        # hash GET param exists
        if ($hash = data('hash')) {

            # verificando se ha algum usuário com a hash.
            $user = $model::first(array(
                        'fields' => 'id, hash_unlock_account',
                        'where' => "hash_unlock_account = '$hash'"
            ));

            if (!empty($user)) {
                $user->hash_unlock_account = '';
                $user->login_attempts = 0;

                $user->edit() ?
                                flash('Sua conta foi desbloqueada.') :
                                flash('Algo ocorreu errado. Tente novamente mais tarte.', 'error');
            }
        }

        go('/');
    }

}
