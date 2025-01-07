<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [

    // Permiso para añadir una instancia del bloque.
    'block/mis_companeros:addinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
            // Los estudiantes no pueden añadir una instancia del bloque.
        ],
    ],
    
    // Permiso para ver el bloque.
    'block/mis_companeros:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        ],
    ],

    // Permiso para enviar mensajes.
    'block/mis_companeros:sendmessage' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'student' => CAP_ALLOW, // 
        ],
    ],

    // Permiso para ver mensajes.
    'block/mis_companeros:viewmessages' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'student' => CAP_ALLOW, 
        ],
    ],
];