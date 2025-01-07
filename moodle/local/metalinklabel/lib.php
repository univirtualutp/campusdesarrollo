<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Función auxiliar para crear una etiqueta con los enlaces a los cursos enlazados.
 *
 * @param int $courseid El ID del curso principal.
 * @param int $linkedcourseid El ID del curso enlazado.
 * @return string El contenido HTML de la etiqueta.
 */
function local_metalinklabel_create_label($courseid, $linkedcourseid) {
    global $DB;

    // Obtener el nombre del curso enlazado.
    $linkedcoursename = $DB->get_field('course', 'fullname', ['id' => $linkedcourseid]);

    // Crear el contenido de la etiqueta.
    $labelcontent = '<div style="display: flex; justify-content: space-between;">';
    $labelcontent .= '<div>';
    $labelcontent .= '<a href="' . new \moodle_url('/course/view.php', ['id' => $linkedcourseid]) . '">' . get_string('course', 'local_metalinklabel') . ': ' . $linkedcoursename . '</a>';
    $labelcontent .= '</div>';
    $labelcontent .= '<div>';
    $labelcontent .= '<!-- Espacio para agregar contenido adicional -->';
    $labelcontent .= '</div>';
    $labelcontent .= '</div>';

    return $labelcontent;
}

/**
 * Ejemplo de una función que podría agregarse al archivo lib.php para futuros usos.
 *
 * Esta función se podría usar para agregar un mensaje de bienvenida o cualquier
 * otra funcionalidad adicional que desees implementar en el futuro.
 */
function local_metalinklabel_example_function() {
    // Implementación de alguna funcionalidad futura.
}
