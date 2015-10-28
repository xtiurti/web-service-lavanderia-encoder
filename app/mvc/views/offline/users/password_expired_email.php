<div class="row">
    <div class="col s4 m2 l4">&nbsp;</div>

    <div class="col s12 m8 l4">

        <?php echo element('page/back'); ?>

        <div class="card">
            <div class="card-image center-align">
                <br/>
                <h4>
                    <b class="grey-text text-darken-3">
                        Renovar Minha Senha
                    </b>
                </h4>
            </div>

            <div class="card-content center-align" style="padding-top: 0;">
                <form action="<?php echo url('/password_expired_email'); ?>" method="post">
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
                        </div>

                        <br/>

                        <div class="blue-text left-align">
                            <i class="material-icons">&#xE88F;</i>
                            <b class="relative" style="top: -7px;">INFORMAÇÃO</b>
                        </div>

                        <p class="grey-text center-align info_painel">
                            Enviaremos para seu e-mail uma carta com as instruções para você <b class="black-text">Renovar</b> sua senha.
                            <br/>
                            <small class="amber-text text-accent-4">
                                <b>VERIFIQUE SUA CAIXA DE SPAN!</b>
                            </small>
                        </p>

                        <br/>

                        <button class="btn waves-effect waves-light btn-large indigo lighten-2 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Enviar instruções para meu e-mail." type="submit" name="action">
                            <span class="white-text" style="top: -7px; position: relative;">Enviar</span>
                            &nbsp;&nbsp;
                            <i class="material-icons white-text">&#xE163;</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>