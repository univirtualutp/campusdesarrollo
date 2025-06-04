<?php
class block_asesor_profile extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_asesor_profile');
    }

    public function get_content() {
        global $COURSE, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $context = context_course::instance($COURSE->id);

        // Incluir el CSS aquí.
        $this->page->requires->css('/blocks/asesor_profile/css/asesor_styles.css');


        // Obtener todos los asesores del curso.
        $asesores = get_role_users(11, $context); // ID de rol 11 es el rol de asesor.

        // Número telefónico fijo para el enlace de WhatsApp.
        $fixed_phone_number = '573203921622'; // Reemplaza con el número que desees utilizar.

        if ($asesores) {
            $asesor_profiles = '';
            foreach ($asesores as $asesor) {
                $user_picture = new user_picture($asesor);
                $user_picture->size = 100; // Tamaño de la imagen.

                // URL para enviar un mensaje al asesor.
                $message_url = new moodle_url('/message/index.php', array('id' => $asesor->id));

                // URL fija de WhatsApp.
                $whatsapp_url = 'https://wa.me/' . $fixed_phone_number;

                // Crear los íconos para el mensaje y WhatsApp.
                $message_icon = $OUTPUT->pix_icon('t/email', get_string('sendmessage', 'block_asesor_profile'));
                $whatsapp_icon = html_writer::tag('i', '', array('class' => 'fa fa-whatsapp'));

                // Crear los enlaces para el mensaje y WhatsApp.
                $message_link = html_writer::link($message_url, $message_icon, array('title' => get_string('sendmessage', 'block_asesor_profile')));
                $whatsapp_link = html_writer::link($whatsapp_url, $whatsapp_icon, array('title' => 'WhatsApp', 'target' => '_blank'));

                // Combinar la imagen, nombre del asesor y los íconos de mensaje y WhatsApp en un bloque.
                $asesor_profiles .= html_writer::div(
                    $OUTPUT->render($user_picture) .
                    html_writer::tag('p', fullname($asesor) . ' ' . $message_link . ' ' . $whatsapp_link),
                    'asesores-profile'
                );
            }

            // Asignar los perfiles de los asesores al contenido del bloque.
            $this->content->text = $asesor_profiles;
        } else {
            $this->content->text = get_string('noasesor', 'block_asesor_profile');
        }

        return $this->content;
    }
}
