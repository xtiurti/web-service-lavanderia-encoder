<?php

Connection::$connections = array(
    'default' => array(
        'source' => 'Sqlite',
        'path' => APP . 'database' . DS . 'sqlite' . DS,
        'database' => 'encoder',
    ),
);
