<?php
/*
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

use local_mail\message;
use local_mail\settings;
use local_mail\user;

require_once('../../config.php');
require_once("$CFG->libdir/filelib.php");

$messageid = required_param('m', PARAM_INT);

require_login(null, false);

if (!settings::is_installed()) {
    throw new moodle_exception('errorpluginnotinstalled', 'local_mail');
}

$user = user::current();
$message = message::get($messageid, IGNORE_MISSING);
$context = $message->get_course()->get_context() ?? null;
if (!$user || !$message || !$context || !$user->can_view_files($message)) {
    send_file_not_found();
}

$files = get_file_storage()->get_area_files(
    $context->id,
    'local_mail',
    'message',
    $message->id,
    'filepath, filename',
    false
);

$zipfiles = [];
foreach ($files as $file) {
    $filename = clean_filename($file->get_filepath() . $file->get_filename());
    $zipfiles[$filename] = $file;
}

$zipper = new zip_packer();
$tempzip = tempnam($CFG->tempdir . '/', 'local_mail_');

if ($zipper->archive_to_pathname($zipfiles, $tempzip)) {
    $filename = clean_filename($message->get_sender()->fullname() . ' - ' . $message->subject . '.zip');
    send_temp_file($tempzip, $filename);
} else {
    send_file_not_found();
}
