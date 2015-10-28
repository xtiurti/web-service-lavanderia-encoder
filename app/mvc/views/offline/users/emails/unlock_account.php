<h2>
    <small>- Olá </small>
    <b><?php echo format('first_name', $user->name); ?></b>
</h2>

Sua conta foi bloqueada devido ao número excessivo de vezes que alguém tentou se conectar.

<br/>
<br/>

<div style="color: 31708f; background: #d9edf7; padding: 15px 20px;">
    Acesse o endereço abaixo para desbloquear sua conta.

    <br/>
    <br/>

    <a href="<?php echo url('/unlock_account?hash=' . $user->hash_unlock_account); ?>" style="color: blue;">
        <b>
            &nbsp;Clique Aqui&nbsp;
            para Desbloquear sua Conta
        </b>
    </a>
</div>