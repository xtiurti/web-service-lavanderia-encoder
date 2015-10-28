<?php

Form::$form_element = '
    <form action=":action" method=":method">
';

Form::$message_element = '
    <small class="red-text relative" style="top: -10px;">
        <br/>
        <i class="material-icons" style="font-size: 20px; margin-right: 3px;">error</i>
        <span class="relative" style="top: -6px;">
            <b>:message</b>
        </span>
    </small>
';
