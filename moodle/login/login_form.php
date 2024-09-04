<?php

require_once($CFG->libdir . '/formslib.php');

class login_form extends moodleform {
    // Definición del formulario
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'username', get_string('username'));
        $mform->setType('username', PARAM_NOTAGS);

        $mform->addElement('password', 'password', get_string('password'));
        $mform->setType('password', PARAM_RAW);

        $this->add_action_buttons(false, get_string('login'));
    }
}
