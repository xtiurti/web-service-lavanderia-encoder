<div class="row">

    <!-- l:desktop m:tablet s:mobile -->
    <div class="col s4 m2 l3">&nbsp;</div>

    <div class="col s12 m8 l6">

        <?php echo element('page/back'); ?>

        <h1 class="center-align">
            <i class="material-icons green-text" style="font-size: 180%;">&#xE7F2;</i>

            <div>
                QUASE LÁ!
            </div>
        </h1>

        <h5 class="center-align grey-text">
            <b>Sucesso!</b>
            Resta apenas <u>confirmar sua conta</u>. 

            <br/>
            <br/>
            Para lhe ajudar com isso, enviamos um e-mail para 
            <span class="blue-text"><b>&lt;<?php echo $user->email; ?>&gt;</b></span>.
        </h5>

        <br/>
        
        <p class="center-align grey-text text-small">
            <i class="material-icons relative orange-text" style="bottom: -7px;">&#xE88F;</i>
            Verifique sua <b>Lixeira</b> ou <b>Caixa de Span</b>.

            <br/>
            <a href="<?php echo url('/confirm_account_email'); ?>" class="center-align">
                <u>Não Recebi o E-mail</u>
            </a>
        </p>
        
        <br/>
        <hr/>

        <p class="right-align grey-text text-small">
            <i>Agradecemos seu Registro!</i>
        </p>

    </div>
</div>