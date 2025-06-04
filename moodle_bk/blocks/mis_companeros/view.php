<?php
require_once('../../config.php');
require_once('renderer.php');

$courseid = required_param('courseid', PARAM_INT);
require_login($courseid);

$context = context_course::instance($courseid);
require_capability('moodle/block:view', $context);

$PAGE->set_url('/blocks/mis_companeros/view.php', ['courseid' => $courseid]);
$PAGE->set_context($context);
$PAGE->set_title(get_string('viewcompanions', 'block_mis_companeros'));
$PAGE->set_heading(get_string('viewcompanions', 'block_mis_companeros'));

// JavaScript para la funcionalidad de seleccionar/deseleccionar todos
$PAGE->requires->js_init_code('
    document.getElementById("selectall").addEventListener("change", function() {
        var checkboxes = document.querySelectorAll(".student-checkbox");
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
');

$output = $PAGE->get_renderer('block_mis_companeros');

// Obtener lista de estudiantes con rol 5
$students = get_enrolled_users($context, 'mod/assign:submit', 0, 'u.id, u.firstname, u.lastname, u.email, u.picture');
$students_list = [];
foreach ($students as $student) {
    $students_list[] = (object)[
        'id' => $student->id,
        'name' => $student->firstname . ' ' . $student->lastname,
        'email' => $student->email,
        'profileimageurl' => new moodle_url('/user/pix.php/' . $student->id . '/f1.jpg')
    ];
}

echo $output->header();

// Agregamos un título para la vista
echo '<h2>' . get_string('viewcompanions', 'block_mis_companeros') . '</h2>';

// Formulario para enviar mensajes
echo '<form action="send_message.php" method="post">';
echo '<input type="hidden" name="courseid" value="' . $courseid . '">';

// Encabezado de la tabla con checkbox para seleccionar todos
echo '<table class="companion-list">';
echo '<tr>';
echo '<th>' . get_string('photo', 'block_mis_companeros') . '</th>';
echo '<th>' . get_string('name', 'block_mis_companeros') . '</th>';
echo '<th>' . get_string('email', 'block_mis_companeros') . '</th>';
echo '<th><input type="checkbox" id="selectall">' . get_string('selectall', 'block_mis_companeros') . '</th>';
echo '</tr>';

// Filas de estudiantes
foreach ($students_list as $student) {
    echo '<tr>';
    echo '<td><img src="' . $student->profileimageurl . '" alt="' . $student->name . '" /></td>';
    echo '<td>' . $student->name . '</td>';
    echo '<td>' . $student->email . '</td>';
    echo '<td><input type="checkbox" class="student-checkbox" name="selected[]" value="' . $student->id . '"></td>';
    echo '</tr>';
}
echo '</table>';

// Cuadro de mensaje y botón de envío
echo '<br>';
echo '<textarea name="message" placeholder="' . get_string('sendmessage', 'block_mis_companeros') . '" style="width: 100%; height: 100px;"></textarea>';
echo '<br><input type="submit" value="' . get_string('sendmessage', 'block_mis_companeros') . '" style="margin-top: 10px;">';

// Botón de regreso al curso
$course_url = new moodle_url('/course/view.php', ['id' => $courseid]);
echo '<br><br><a href="' . $course_url . '" class="btn btn-secondary">' . get_string('backtocourse', 'block_mis_companeros') . '</a>';

echo '</form>';

echo $output->footer();