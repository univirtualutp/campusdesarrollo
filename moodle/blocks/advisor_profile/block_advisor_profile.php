<?php
class block_advisor_profile extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_advisor_profile');
    }

    public function get_content() {
        global $COURSE, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $context = context_course::instance($COURSE->id);

        // Incluir el CSS aquí.
        $this->page->requires->css('/blocks/advisor_profile/css/styles.css');

        // Obtener todos los asesores del curso.
        $advisors = get_role_users(11, $context); // ID de rol 11 es el rol de asesor.

        if ($advisors) {
            $advisor_profiles = '';
            foreach ($advisors as $advisor) {
                $user_picture = new user_picture($advisor);
                $user_picture->size = 100; // Tamaño de la imagen.

                // URL para enviar un mensaje al asesor.
                $message_url = new moodle_url('/message/index.php', array('id' => $advisor->id));

                // Crear el enlace de mensaje con el ícono.
                $message_icon = $OUTPUT->pix_icon('t/email', get_string('sendmessage', 'block_advisor_profile'));
                $message_link = html_writer::link($message_url, $message_icon);

                // Enlace de WhatsApp que ya tienes.
                $whatsapp_link = '<a class="fa fa-whatsapp" href="https://wa.me/c/573203921622" target="_blank" rel="noopener">&nbsp;</a>';

                // Combinar la imagen, nombre del asesor y los íconos de mensaje y WhatsApp en un bloque.
                $advisor_profiles .= html_writer::div(
                    $OUTPUT->render($user_picture) .
                    html_writer::tag('p', fullname($advisor) . ' ' . $message_link . ' ' . $whatsapp_link),
                    'teacher-profile' // Cambiar el nombre de la clase si es necesario.
                );
            }

            // Asignar los perfiles de los asesores al contenido del bloque.
            $this->content->text = $advisor_profiles;
        } else {
            $this->content->text = get_string('noadvisor', 'block_advisor_profile');
        }

        return $this->content;
    }
}
