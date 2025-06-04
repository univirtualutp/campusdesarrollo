<?php

defined('MOODLE_INTERNAL') || die();

$functions = [
    'block_mis_companeros_send_message' => [
        'classname' => 'block_mis_companeros_message_provider',
        'methodname' => 'send_message',
        'classpath' => 'blocks/mis_companeros/classes/message/provider.php',
        'description' => 'Send messages to selected users from the Mis Compañeros block',
        'type' => 'write',
        'capabilities' => 'block/mis_companeros:sendmessage',
    ],
];

$services = [
    'Mensajes de Mis Compañeros' => [
        'functions' => array_keys($functions),
        'restrictedusers' => 0,
        'enabled' => 1,
    ],
];
