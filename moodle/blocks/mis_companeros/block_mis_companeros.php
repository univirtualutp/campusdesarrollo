<?php
class block_mis_companeros extends block_base {
    
    public function init() {
        $this->title = get_string('miscompaneros', 'block_mis_companeros');
    }

    public function get_content() {
        global $USER, $OUTPUT, $PAGE;

        // Solo mostrar el contenido si el rol del usuario es el rol 5 (Estudiante).
        $context = context_course::instance($this->page->course->id);
        if (!has_capability('block/mis_companeros:view', $context)) {
            return '';
        }

        // Crear el enlace para ver a los estudiantes con el rol 5.
        $url = new moodle_url('/blocks/mis_companeros/view.php', array('courseid' => $this->page->course->id));
        $link = html_writer::link($url, get_string('vercompaneros', 'block_mis_companeros'));

        // Generar el contenido del bloque.
        $this->content = new stdClass();
        $this->content->text = $link;
        return $this->content;
    }

    public function applicable_formats() {
        return array('course-view' => true);
    }
}
