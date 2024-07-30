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

require_once('../../config.php');
require_once('/blocks/rumbletalk_chat/classes/forms/create_form.php');

$createaccountparams = [
    'id' => $USER->id
];

require_login();
$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/blocks/rumbletalk_chat/create_account.php'), $createaccountparams);
$PAGE->set_title(get_string('title_create', 'block_rumbletalk_chat'));
$PAGE->set_heading(get_string('heading_create', 'block_rumbletalk_chat'));
$PAGE->navbar->add(get_string('pluginname', 'block_rumbletalk_chat'));
$PAGE->navbar->add(get_string('create_account', 'block_rumbletalk_chat'));

echo $OUTPUT->header();

$mform = new create_account_form();
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/', ['redirect' => 0]));
} else if ($data = $mform->get_data()) {
    // Form has been submitted.
    $email = $data->create_email;
    $password = $data->create_password;
    $createparams = array(
        'email' => $email,
        'password' => $password);
    $PAGE->requires->js_call_amd('block_rumbletalk_chat/create_account', 'init', array($createparams));
} else {
    // Just display the form.
    $mform->set_data($createaccountparams);
    $mform->display();
}