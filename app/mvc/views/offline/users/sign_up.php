<div class="row">
    <!-- l:desktop m:tablet s:mobile -->
    <div class="col s0 l2 m1">
        &nbsp;
    </div>

    <div class="col s12 l8 m10">
        <form action="<?php echo url(); ?>" method="POST">
            <?php echo input_csfr(); ?>

            <div class="row">
                <div class="col s12">
                    <?php echo element('page/back'); ?>

                    <br/>

                    <h4>
                        <b class="grey-text text-darken-3">
                            Criar Conta
                        </b>
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12 l6 m12">
                    <div class="row">
                        <div class="painel">
                            <div class="center-align">
                                <small><b>Identificação</b></small>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix grey-text">&#xE8A6;</i>

                                <input name="offline\User[name]"
                                       type="text"
                                       maxlength="92"
                                       autofocus=autofocus
                                       required
                                       <?php echo input_id_value($user, 'name'); ?>
                                       />

                                <?php echo input_label_message('Nome Completo', $user, 'name'); ?>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix grey-text">&#xE85E;</i>

                                <input name="offline\User[documentation]"
                                       class="mask cpf"
                                       type="text"
                                       maxlength="32"
                                       required
                                       <?php echo input_id_value($user, 'documentation'); ?>
                                       />

                                <?php echo input_label_message('Número do CPF', $user, 'documentation'); ?>
                            </div>
                        </div>

                        <div class="painel">
                            <div class="center-align">
                                <small><b>Endereço</b></small>
                            </div>

                            <div class="input-field">
                                <input name="offline\User[address_zipcode]"
                                       class="mask cep zipcode_zipcode"
                                       type="text"
                                       maxlength="9"
                                       required
                                       <?php echo input_id_value($user, 'address_zipcode'); ?>
                                       />

                                <?php echo input_label_message('CEP', $user, 'address_zipcode'); ?>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <input name="offline\User[address_state]"
                                           class="zipcode_state"
                                           type="text"
                                           maxlength="92"
                                           required
                                           <?php echo input_id_value($user, 'address_state'); ?>
                                           />

                                    <?php echo input_label_message('Estado', $user, 'address_state'); ?>
                                </div>

                                <div class="input-field col s6">
                                    <input name="offline\User[address_city]"
                                           class="zipcode_city"
                                           type="text"
                                           maxlength="92"
                                           required
                                           <?php echo input_id_value($user, 'address_city'); ?>
                                           />

                                    <?php echo input_label_message('Cidade', $user, 'address_city'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <input name="offline\User[address_street]"
                                           class="zipcode_street"
                                           type="text"
                                           maxlength="92"
                                           required
                                           <?php echo input_id_value($user, 'address_street'); ?>
                                           />

                                    <?php echo input_label_message('Logradouro', $user, 'address_street'); ?>
                                </div>

                                <div class="input-field col s6">
                                    <input name="offline\User[address_neighborhood]"
                                           class="zipcode_neighborhood"
                                           type="text"
                                           maxlength="92"
                                           required
                                           <?php echo input_id_value($user, 'address_neighborhood'); ?>
                                           />

                                    <?php echo input_label_message('Bairro', $user, 'address_neighborhood'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <input name="offline\User[address_number]"
                                           class="mask natural number zipcode_number"
                                           type="number"
                                           maxlength="8"
                                           required
                                           <?php echo input_id_value($user, 'address_number'); ?>
                                           />

                                    <?php echo input_label_message('Número', $user, 'address_number'); ?>
                                </div>

                                <div class="input-field col s6">
                                    <input name="offline\User[address_complement]"
                                           type="text"
                                           maxlength="92"
                                           <?php echo input_id_value($user, 'address_complement'); ?>
                                           />

                                    <?php echo input_label_message('Complemento', $user, 'address_complement'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s12 l6 m12">
                    <div class="row">
                        <div class="painel">
                            <div class="center-align">
                                <small><b>Contato</b></small>
                            </div>

                            <div class="input-field">
                                <input name="offline\User[phone]"
                                       class="mask phone"
                                       type="text"
                                       maxlength="32"
                                       minlength="5"
                                       required
                                       <?php echo input_id_value($user, 'phone'); ?>
                                       />

                                <?php echo input_label_message('Telefone', $user, 'phone'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s12 l6 m12">
                    <div class="row">
                        <div class="painel">
                            <div class="center-align">
                                <small><b>Conta</b></small>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix grey-text">&#xE0BE;</i>

                                <input name="offline\User[email]"
                                       type="text"
                                       maxlength="92"
                                       required
                                       <?php echo input_id_value($user, 'email'); ?>
                                       />

                                <?php echo input_label_message('E-mail', $user, 'email'); ?>
                            </div>

                            <div class="input-field">
                                <i class="material-icons prefix grey-text">&#xE899;</i>

                                <input name="offline\User[password]"
                                       type="password"
                                       maxlength="32"
                                       minlength="5"
                                       required
                                       <?php echo input_id($user, 'password'); ?>
                                       />

                                <?php echo input_label_message('Senha:', $user, 'password'); ?>
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

                                <?php echo input_label_message('Digite sua Senha Novamente:', $user, 'password_confirm'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="btn waves-effect waves-light btn-large green" type="submit" name="action" style="position: fixed; bottom: 5%; right: 2%;">
                <span class="white-text" style="top: -7px; position: relative;">Criar Conta</span>
                &nbsp;&nbsp;
                <i class="material-icons">&#xE862;</i>
            </button>
        </form>
    </div>
</div>

