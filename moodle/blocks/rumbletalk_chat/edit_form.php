<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Handles displaying the rumbletalk group chat block.
 *
 * @package    block_rumbletalk_chat
 * @copyright  2021 RumbleTalk, LTD {@link https://www.rumbletalk.com/}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_rumbletalk_chat_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        // Div sample.
        // $mform->addElement('html', '<div style="width: 85%; margin-bottom: 2em; padding-left: 1em;">RumbleTalk chat will allow you to add a group chat into the right side of your page. Set the chat to allow guests and social logins or by checking the members checkbox, users will login to the chat with their Moodle user name automatically.</div>');
        $mform->addElement('html', get_string('intro', 'block_rumbletalk_chat'));
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('embed_chat', 'block_rumbletalk_chat'));
        // Input field for HashCode.
        $mform->addElement('text', 'config_code', get_string('embed_code', 'block_rumbletalk_chat'));
        $mform->addRule('config_code', get_string('error_code_required', 'block_rumbletalk_chat'), 'required', null, 'client');
        $mform->addHelpButton('config_code', 'code', 'block_rumbletalk_chat');
        $mform->setType('config_code', PARAM_TEXT);
        // Input field for Height.
        $mform->addElement('text', 'config_height', get_string('embed_height', 'block_rumbletalk_chat'));
        $mform->addRule('config_height', get_string('error_numbers_only', 'block_rumbletalk_chat'), 'numeric', null, 'client');
        $mform->addHelpButton('config_height', 'height', 'block_rumbletalk_chat');
        $mform->setType('config_height', PARAM_TEXT);
        // Checkbox for Members Only.
        $mform->addElement('advcheckbox', 'config_members', get_string('login_type', 'block_rumbletalk_chat'),
         get_string('members_only', 'block_rumbletalk_chat'), array('group' => 1), array(0, 1));
        $mform->addHelpButton('config_members', 'members', 'block_rumbletalk_chat');
        $mform->setType('config_members', PARAM_TEXT);
        $mform->addElement('html', get_string('take_note', 'block_rumbletalk_chat'));
    }

    public function specialization() {
        if (isset($this->config)) {
            // Default Height of the chat is 500px.
            if (empty($this->config->height)) {
                $this->config->height = get_string('default_height', 'block_rumbletalk_chat');
            }
            $this->content->text = get_string('chat_div', 'block_rumbletalk_chat');
        }
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function instance_config_save($data, $nolongerused =false) {
        if (get_config('rumbletalk', 'Allow_HTML')) {
            $data->text = strip_tags($data->text);
        }

        if ($this->config->members == 1) {
            $this->content->text .= get_string('rtmq_script', 'block_rumbletalk_chat');
        }

        // And now forward to the default implementation defined in the parent class.
        return parent::instance_config_save($data, $nolongerused);
    }

}