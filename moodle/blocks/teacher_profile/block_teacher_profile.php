<?php
class block_teacher_profile extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_teacher_profile');
    }

    public function get_content() {
        global $COURSE, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $context = context_course::instance($COURSE->id);

        // Incluir el CSS aquí.
        $this->page->requires->css('/blocks/asesor_profile/css/profesor_styles.css');

        // Obtener todos los profesores del curso.
        $teachers = get_role_users(3, $context); // ID de rol 3 es el rol de profesor.

        if ($teachers) {
            $teacher_profiles = '';
            foreach ($teachers as $teacher) {
                $user_picture = new user_picture($teacher);
                $user_picture->size = 100; // Tamaño de la imagen.

                // URL para enviar un mensaje al profesor.
                $message_url = new moodle_url('/message/index.php', array('id' => $teacher->id));

                // Crear el enlace de mensaje con el ícono.
                $message_icon = $OUTPUT->pix_icon('t/email', get_string('sendmessage', 'block_teacher_profile'));
                $message_link = html_writer::link($message_url, $message_icon);

                // Combinar la imagen, nombre del profesor y el ícono de mensaje en un bloque.
                $teacher_profiles .= html_writer::div(
                    $OUTPUT->render($user_picture) .
                    html_writer::tag('p', fullname($teacher) . ' ' . $message_link),
                    'teacher-profile'
                );
            }

            // Asignar los perfiles de los profesores al contenido del bloque.
            $this->content->text = $teacher_profiles;
        } else {
            $this->content->text = get_string('noteacher', 'block_teacher_profile');
        }

        return $this->content;
    }
}
