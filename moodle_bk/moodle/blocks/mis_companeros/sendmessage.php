<?php
require_once('../../config.php');
global $DB, $USER, $OUTPUT, $PAGE;

// Obtener parámetros
$courseid = required_param('courseid', PARAM_INT);
$studentids = optional_param_array('studentids', array(), PARAM_INT);
$mensaje = required_param('mensaje', PARAM_TEXT);

// Comprobar que el usuario tiene permisos en el curso.
$context = context_course::instance($courseid);
require_login($courseid);
require_capability('moodle/course:message', $context);

// Verificar si se seleccionaron estudiantes
if (empty($studentids)) {
    print_error('nomessagesselected', 'block_mis_companeros');
}

// Enviar el mensaje a cada estudiante seleccionado
foreach ($studentids as $studentid) {
    // Cargar el usuario
    $user = $DB->get_record('user', array('id' => $studentid));
    if ($user) {
        // Enviar mensaje
        message_post_message($USER->id, $user->id, $mensaje);
    }
}

// Redirigir a la página de vista con un mensaje de éxito
redirect(new moodle_url('/blocks/mis_companeros/view.php', array('courseid' => $courseid)), get_string('messagesent', 'block_mis_companeros'));
