<?php
class block_expert_profile extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_expert_profile');
    }

    public function get_content() {
        global $COURSE, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $context = context_course::instance($COURSE->id);

        // Incluir el CSS aquí.
        $this->page->requires->css('/blocks/expert_profile/css/styles.css');

        // Obtener todos los expertos del curso.
        $experts = get_role_users(15, $context); // Reemplaza 'ROL_ID_EXPERTO' por el ID real del rol experto.

        if ($experts) {
            $expert_profiles = '';
            foreach ($experts as $expert) {
                $user_picture = new user_picture($expert);
                $user_picture->size = 100; // Tamaño de la imagen.

                // Combinar la imagen y el nombre del experto en un bloque.
                $expert_profiles .= html_writer::div(
                    $OUTPUT->render($user_picture) .
                    html_writer::tag('p', fullname($expert)),
                    'expert-profile'
                );
            }

            // Asignar los perfiles de los expertos al contenido del bloque.
            $this->content->text = $expert_profiles;
        } else {
            $this->content->text = get_string('noexpert', 'block_expert_profile');
        }

        return $this->content;
    }
}
