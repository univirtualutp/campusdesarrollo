<?php
/*
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

namespace local_mail\event;

class message_viewed extends \core\event\base {
    public static function create_from_message(\local_mail\message $message): \core\event\base {
        global $USER;

        return self::create([
            'userid' => $USER->id,
            'objectid' => $message->id,
            'context' => $message->get_course()->get_context(),
        ]);
    }

    protected function init() {
        $this->data['objecttable'] = 'local_mail_messages';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    public static function get_name() {
        return \local_mail\output\strings::get('eventmessageviewed');
    }

    public function get_description() {
        return "The user with id '$this->userid' has viewed the message with id '$this->objectid'.";
    }

    public static function get_objectid_mapping() {
        return ['db' => 'local_mail_messages', 'restore' => 'local_mail_message'];
    }

    public function get_url() {
        return new \moodle_url('/local/mail/view.php', ['t' => 'course', 'c' => $this->courseid, 'm' => $this->objectid]);
    }
}
