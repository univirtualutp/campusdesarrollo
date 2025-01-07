<?php
require_once('../../config.php');
global $DB, $USER, $OUTPUT, $PAGE, $COURSE;

// Obtener ID del curso.
$courseid = required_param('courseid', PARAM_INT);
$context = context_course::instance($courseid);

// Comprobar que el usuario tiene permisos en el curso.
require_login($courseid);
require_capability('block/mis_companeros:view', $context);

// Configurar la página.
$PAGE->set_url('/blocks/mis_companeros/view.php', array('courseid' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('companeros', 'block_mis_companeros'));
$PAGE->set_heading(get_string('companeros', 'block_mis_companeros'));

// Obtener los estudiantes con el rol 5 (Estudiante).
$sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.picture
        FROM {user} u
        JOIN {role_assignments} ra ON u.id = ra.userid
        JOIN {context} ctx ON ra.contextid = ctx.id
        WHERE ra.roleid = :roleid AND ctx.contextlevel = :contextlevel AND ctx.instanceid = :courseid";

$params = [
    'roleid' => 5, 
    'contextlevel' => CONTEXT_COURSE, 
    'courseid' => $courseid
];

$students = $DB->get_records_sql($sql, $params);

// Mostrar la lista de estudiantes.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('companeros', 'block_mis_companeros'));

// Mostrar el formulario para seleccionar estudiantes y enviar mensajes.
echo '<form method="post" action="sendmessage.php">';
echo '<input type="hidden" name="courseid" value="' . $courseid . '">';

echo '<div class="mis-companeros">';
foreach ($students as $student) {
    $user_picture = new user_picture($student);
    $user_picture->size = 100; // Tamaño de la imagen de perfil.

    echo '<div class="companion">';
    echo '<input type="checkbox" name="studentids[]" value="' . $student->id . '">';
    echo $OUTPUT->render($user_picture);
    echo '<div class="student-info">';
    echo '<p><strong>' . fullname($student) . '</strong></p>';
    echo '<p>' . $student->email . '</p>';
    echo '</div></div>';
}
echo '</div>';
echo '<br><button type="submit">' . get_string('sendmessage', 'block_mis_companeros') . '</button>';
echo '</form>';

echo $OUTPUT->footer();
