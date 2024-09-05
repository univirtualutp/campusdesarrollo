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

        // Incluir el CSS y Font Awesome aquí.
        $this->page->requires->css(new moodle_url('/blocks/advisor_profile/css/styles.css'));

        // Carga de la hoja de estilo externa.
        $this->page->requires->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');


        // Obtener todos los asesores del curso.
        $roleid = 11; // ID de rol 11 es el rol de Asesor Univirtual.
        $users = get_role_users($roleid, $context);

        if ($users) {
            $advisor_profiles = '';
            foreach ($users as $user) {
                $user_picture = new user_picture($user);
                $user_picture->size = 100; // Tamaño de la imagen.

                // URL para enviar un mensaje al usuario.
                $message_url = new moodle_url('/message/index.php', array('id' => $user->id));

                // Enlace de WhatsApp.
                $whatsapp_url = 'https://wa.me/c/573203921622';
                $whatsapp_icon = '<i class="fab fa-whatsapp"></i>'; // Ícono de WhatsApp.

                // Crear el enlace de mensaje con el ícono.
                $message_icon = $OUTPUT->pix_icon('t/email', get_string('sendmessage', 'block_advisor_profile'));
                $message_link = html_writer::link($message_url, $message_icon);

                // Crear el enlace de WhatsApp con el ícono.
                $whatsapp_link = html_writer::link($whatsapp_url, $whatsapp_icon, array('class' => 'whatsapp-link'));

                // Combinar la imagen, nombre del usuario, el ícono de mensaje y el ícono de WhatsApp en un bloque.
                $advisor_profiles .= html_writer::div(
                    $OUTPUT->render($user_picture) .
                    html_writer::tag('p', fullname($user) . ' ' . $message_link . ' ' . $whatsapp_link),
                    'advisor-profile'
                );
            }

            // Asignar los perfiles de los asesores al contenido del bloque.
            if ($advisor_profiles) {
                $this->content->text = $advisor_profiles;
            } else {
                $this->content->text = get_string('noadvisor', 'block_advisor_profile');
            }
        } else {
            $this->content->text = get_string('noadvisor', 'block_advisor_profile');
        }

        return $this->content;
    }
}
