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
 * @covers \local_mail\exception
 */
class exception_test extends testcase {
    public function test_construct() {
        $exception = new exception('errortoomanyrecipients', 123, 'debug info');

        self::assertEquals('errortoomanyrecipients', $exception->errorcode);
        self::assertEquals('local_mail', $exception->module);
        self::assertEquals(123, $exception->a);
        self::assertEquals('', $exception->link);
        self::assertEquals('debug info', $exception->debuginfo);
    }
}
