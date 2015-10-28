<h2>
    <small>- Olá </small>
    <b><b><?php echo $user->email; ?></b></b>
</h2>

<br/>

<div style="color: 31708f; background: #d9edf7; padding: 15px 20px;">
    Acesse o endereço abaixo para criar uma nova senha.

    <br/>
    <br/>
    <a href="<?php echo url('/password_expired?hash=' . $user->hash_password_expired); ?>" style="color: blue;">
        <b>
            &nbsp; Clique Aqui para Criar uma Nova Senha &nbsp;
        </b>
    </a>
</div>