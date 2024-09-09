<?php
require_once('../../config.php');
global $DB, $USER, $PAGE;

// Obtener el ID del curso y los estudiantes seleccionados.
$courseid = required_param('courseid', PARAM_INT);
$studentids = required_param_array('studentids', PARAM_INT);

$context = context_course::instance($courseid);

// Comprobar que el usuario tiene permisos en el curso.
require_login($courseid);
require_capability('block/mis_companeros:view', $context);

// Configurar la página.
$PAGE->set_url('/blocks/mis_companeros/sendmessage.php');
$PAGE->set_pagelayout('standard');

// Preparar el mensaje.
$message = "Hola, este es un mensaje de " . fullname($USER) . " en el curso.";
$sendresult = true;

// Enviar mensajes a los estudiantes seleccionados.
foreach ($studentids as $studentid) {
    $student = $DB->get_record('user', array('id' => $studentid));

    if ($student) {
        $eventdata = new \core\message\message();
        $eventdata->courseid = $courseid;
        $eventdata->component = 'block_mis_companeros';
        $eventdata->name = 'notification';
        $eventdata->userfrom = $USER;
        $eventdata->userto = $student;
        $eventdata->subject = "Nuevo mensaje de " . fullname($USER);
        $eventdata->fullmessage = $message;
        $eventdata->fullmessageformat = FORMAT_PLAIN;
        $eventdata->fullmessagehtml = '<p>' . $message . '</p>';
        $eventdata->smallmessage = $message;
        $eventdata->notification = 1; // 1 significa que es una notificación en lugar de un mensaje directo.

        // Enviar el mensaje.
        if (!message_send($eventdata)) {
            $sendresult = false;
        }
    }
}

redirect(new moodle_url('/blocks/mis_companeros/view.php', array('courseid' => $courseid)), 
    $sendresult ? get_string('messagesentsuccess', 'block_mis_companeros') : get_string('messagesentfail', 'block_mis_companeros'));
