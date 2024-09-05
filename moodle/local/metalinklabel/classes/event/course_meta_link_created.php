<?php
namespace local_metalinklabel\event;

defined('MOODLE_INTERNAL') || die();

class course_meta_link_created {
    public static function handle($event) {
        global $DB;

        $courseid = $event->objectid; // ID del curso principal.
        $linkedcourseid = $event->other['linkid']; // ID del curso enlazado.

        // Obtener el nombre del curso enlazado.
        $linkedcoursename = $DB->get_field('course', 'fullname', ['id' => $linkedcourseid]);

        // Crear el contenido de la etiqueta.
        $labelcontent = '<div style="display: flex; justify-content: space-between;">';
        $labelcontent .= '<div>';
        $labelcontent .= '<a href="' . new \moodle_url('/course/view.php', ['id' => $linkedcourseid]) . '">' . get_string('course') . ': ' . $linkedcoursename . '</a>';
        $labelcontent .= '</div>';
        $labelcontent .= '<div>';
        $labelcontent .= '<!-- Espacio para agregar contenido adicional -->';
        $labelcontent .= '</div>';
        $labelcontent .= '</div>';

        // Insertar la etiqueta en la base de datos.
        $labeldata = new \stdClass();
        $labeldata->course = $courseid;
        $labeldata->name = get_string('metalinklabel', 'local_metalinklabel');
        $labeldata->intro = $labelcontent;
        $labeldata->introformat = FORMAT_HTML;
        $labeldata->timemodified = time();

        // Insertar el label en la base de datos.
        $DB->insert_record('label', $labeldata);
    }
}
