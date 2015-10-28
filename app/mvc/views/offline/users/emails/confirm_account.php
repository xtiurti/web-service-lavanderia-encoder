<h2>
    <small>- Olá </small>
    <b><?php echo format('first_name', $user->name); ?></b>
</h2>

<div style="color: 3c763d; background: #dff0d8; padding: 15px 20px; text-transform: u">
    <b>
        <span style="font-size: 120%;">
            SUCESSO!
        </span> Seu registro foi efetuado <br/>
    </b>
</div>

<br/>

<div style="color: 31708f; background: #d9edf7; padding: 15px 20px;">
    Resta apenas confirmar sua conta clicando no endereço abaixo:

    <br/>
    <br/>

    <a href="<?php echo url('/confirm_account?hash=' . $user->hash_confirm_account); ?>" style="color: blue;">
        <b>
            &nbsp; Clique Aqui para confirmar sua conta &nbsp;
        </b>
    </a>
</div>