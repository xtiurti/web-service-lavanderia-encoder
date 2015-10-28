<div class="row">
    <div class="col s4 m2 l4">&nbsp;</div>

    <div class="col s12 m8 l4">
        <div class="card">
            <div class="card-image center-align">
                <br/>
                
                <img src="<?php echo ASSETS . 'img/logo.png' ?>" style="width: 130px;" />
                
                <h4>
                    <b class="grey-text text-darken-3">
                        Plet's Gummer
                    </b>
                </h4>
            </div>

            <div class="card-content center-align" style="padding-top: 0;">
                <form action="<?php echo url(); ?>" method="post" class="encrypt_password">
                    <?php echo input_csfr(); ?>

                    <div class="row">
                        <div class="row">
                            <br/>
                            <div class="input-field col s12">
                                <i class="material-icons prefix grey-text">&#xE0BE;</i>

                                <input name="offline\User[email]"
                                       placeholder="Digite seu e-mail aqui"
                                       type="email"
                                       maxlength="92"
                                       autofocus="autofocus"
                                       required
                                       <?php echo input_id_value($user, 'email'); ?>
                                       />

                                <?php echo input_label_message('E-mail', $user, 'email'); ?>
                            </div>

                            <br/>
                            <br/>
                            <br/>
                            <br/>

                            <div class="input-field col s12">
                                <i class="material-icons prefix grey-text">&#xE899;</i>

                                <input name="offline\User[password]"
                                       placeholder="Digite sua senha aqui"
                                       type="password"
                                       maxlength="92"
                                       minlength="5"
                                       autocomplete="off"
                                       required
                                       <?php echo input_id($user, 'password'); ?>
                                       />

                                <label>Senha</label>

                                <?php echo input_label_message('Senha', $user, 'password'); ?>
                            </div>
                        </div>

                        <button class="btn waves-effect waves-light btn-large blue" type="submit" name="action">
                            <span class="white-text" style="top: -7px; position: relative;">Entrar</span>
                            &nbsp;&nbsp;
                            <i class="material-icons">&#xE890;</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div style="padding: 0 5%;">

            <a href="<?php echo url('/sign_up'); ?>" class="pull-right text-darken-1 green-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Efetuar cadastro no sistema" style="padding: 0 20px;" >
                <small>
                    <i class="material-icons">&#xE85D;</i>
                    <b class="relative" style="top: -8px">CRIAR CONTA</b>
                </small>
            </a>

            <div class="pull-right">
                <div class="dropdown center top icon">
                    <div class="title">
                        <small>
                            <b class="smooth-text relative" style="top: -8px;">
                                PRECISO DE AJUDA
                            </b>

                            <i class="material-icons smooth-text">&#xE5C5;</i>
                        </small>
                    </div>

                    <div class="menu" style="display: none;">
                        <a href="<?php echo url('/unlock_account_email'); ?>" class="item">
                            <i class="material-icons">&#xE898;</i>
                            <b class="grey-text text-darken-4">Desbloquear</b> Minha Conta
                        </a>

                        <a href="<?php echo url('/confirm_account_email'); ?>" class="item">
                            <i class="material-icons">&#xE876;</i>
                            <b class="grey-text text-darken-4">Confirmar</b> Minha Conta
                        </a>

                        <a href="<?php echo url('/password_forgot_email'); ?>" class="item">
                            <i class="material-icons">&#xE897;</i>
                            <b class="grey-text text-darken-4">Esqueci</b> Minha Senha
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>