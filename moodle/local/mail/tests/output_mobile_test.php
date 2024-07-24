<?php
/*
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

namespace local_mail;

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__ . '/testcase.php');

/**
 * @covers \local_mail\output\mobile
 */
class output_mobile_test extends testcase {
    public function test_init() {
        global $CFG;

        $generator = self::getDataGenerator();
        $course = new course($generator->create_course());
        $user1 = new user($generator->create_user());
        $user2 = new user($generator->create_user());
        $generator->enrol_user($user1->id, $course->id);
        self::setUser($user1->id);

        // User with courses.
        self::assertEquals(
            ['javascript' => file_get_contents("$CFG->dirroot/local/mail/classes/output/mobile-init.js")],
            output\mobile::init(),
        );

        // User with no courses.
        self::setUser($user2->id);
        self::assertEquals(['disabled' => true], output\mobile::init());

        // Not installed.
        unset_config('version', 'local_mail');
        self::setUser($user1->id);
        self::assertEquals(['disabled' => true], output\mobile::init());
    }

    public function test_view() {
        global $CFG;

        self::assertEquals(
            [
                'templates' => [
                    [
                        'id' => 'main',
                        'html' => '<core-iframe src="' . $CFG->wwwroot . '/local/mail/view.php?t=inbox&m=123"></core-iframe>',
                    ],
                ],
                'javascript' => file_get_contents("$CFG->dirroot/local/mail/classes/output/mobile-view.js"),
            ],
            output\mobile::view(['t' => 'inbox', 'm' => 123])
        );
    }
}
