<div class="row">
    <div class="col s4 m2 l4">&nbsp;</div>

    <div class="col s12 m8 l4">

        <a href="<?php echo url('/') ?>" class="text-darken-1 cyan-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Retornar a página de conexão" style="padding: 0 20px;">
            <small>
                <i class="material-icons">&#xE5C4;</i>

                <b class="relative" style="top: -8px">
                    VOLTAR
                </b>
            </small>
        </a>

        <div class="card">
            <div class="card-image center-align">
                <br/>
                <h4>
                    <b class="grey-text text-darken-3">
                        Alterar Minha Senha
                    </b>
                </h4>
            </div>

            <div class="card-content center-align" style="padding-top: 0;">

                <br/>
                <div>
                    <small>
                        <i>&lt;<?php echo $user->email; ?>&gt;</i>
                    </small>

                    <br/>

                    Olá <b><?php echo ucwords(strtolower($user->name)); ?></b>,
                    preecha os campos abaixo para alterar sua senha.
                </div>

                <form action="<?php echo url(); ?>" method="post">
                    <?php echo input_csfr(); ?>

                    <div class="row">
                        <div class="row">
                            <br/>
                            <div class="input-field">
                                <i class="material-icons prefix grey-text">&#xE899;</i>

                                <input name="offline\User[password]"
                                       type="password"
                                       maxlength="32"
                                       minlength="5"
                                       required
                                       <?php echo input_id($user, 'password'); ?>
                                       />

                                <?php echo input_label_message('Senha', $user, 'password'); ?>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix grey-text"></i>

                                <input name="offline\User[password_confirm]"
                                       type="password"
                                       maxlength="32"
                                       minlength="5"
                                       required
                                       <?php echo input_id($user, 'password_confirm'); ?>
                                       />

                                <?php echo input_label_message('Digite Sua Senha Novamente', $user, 'password_confirm'); ?>
                            </div>
                        </div>

                        <br/>

                        <button class="btn waves-effect waves-light btn-large orange" type="submit" name="action">
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
