<?php
defined('MOODLE_INTERNAL') || die();

// Verifica si el administrador tiene permisos para configurar el sitio.
if ($hassiteconfig) {

    // Añade una nueva página de configuraciones para el plugin en la categoría de plugins locales.
    $settings = new admin_settingpage('local_metalinklabel', get_string('pluginname', 'local_metalinklabel'));

    // Opción para activar o desactivar la creación automática de etiquetas.
    $settings->add(new admin_setting_configcheckbox(
        'local_metalinklabel/enableautomaticlabels',
        get_string('enableautomaticlabels', 'local_metalinklabel'),
        get_string('enableautomaticlabels_desc', 'local_metalinklabel'),
        1
    ));

    // Opción para personalizar el texto de la etiqueta.
    $settings->add(new admin_setting_configtext(
        'local_metalinklabel/labeltext',
        get_string('labeltext', 'local_metalinklabel'),
        get_string('labeltext_desc', 'local_metalinklabel'),
        get_string('metalinklabel', 'local_metalinklabel'), // Valor por defecto
        PARAM_TEXT
    ));

    // Agregar las configuraciones a la página.
    $ADMIN->add('localplugins', $settings);
}
