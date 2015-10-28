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

                <br/>
                <div>
                    <small>
                        <i>&lt;<?php echo $user->email; ?>&gt;</i>
                    </small>
                    
                    <br/>
                    
                    Olá <b><?php echo ucwords(strtolower($user->name)); ?></b>,
                    preecha os campos abaixo para renovar sua senha.
                </div>

                <form action="<?php echo url(); ?>" method="post">
                    <?php echo input_csfr(); ?>

                    <div class="row">
                        <div class="row">
                            <br/>
                            <div class="input-field">
                                <i class="material-icons prefix grey-text">&#xE899;</i>

                                <input name="offline\User[password]"
                                       placeholder="Digite sua senha aqui"
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
                                       placeholder="Digite sua senha novamente"
                                       type="password"
                                       maxlength="32"
                                       minlength="5"
                                       required
                                       <?php echo input_id($user, 'password_confirm'); ?>
                                       />

                                <?php echo input_label_message('Confirmar Senha', $user, 'password_confirm'); ?>
                            </div>
                        </div>

                        <br/>

                        <button class="btn waves-effect waves-light btn-large indigo lighten-2" type="submit" name="action">
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
