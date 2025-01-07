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
 * @covers \local_mail\output\strings
 */
class output_strings_test extends testcase {
    public function test_get() {
        global $SESSION;

        $generator = $this->getDataGenerator();
        $user = $generator->create_user();
        $this->setUser($user);

        foreach (['en', 'ca', 'es', 'eu', 'gl'] as $lang) {
            $SESSION->forcelang = $lang;

            $strings = self::setup_strings($lang);

            foreach ($strings as $id => $string) {
                self::assertEquals($string, output\strings::get($id));
            }

            // Parameter replacement.
            self::assertEquals(
                str_replace(['{$a->index}', '{$a->total}'], ['3', '14'], $strings['pagingsingle']),
                output\strings::get('pagingsingle', ['index' => '3', 'total' => '14'])
            );
        }
    }

    public function test_get_all() {
        global $SESSION;

        $generator = $this->getDataGenerator();
        $user = $generator->create_user();
        $this->setUser($user);

        foreach (['en', 'ca', 'es'] as $lang) {
            $strings = self::setup_strings($lang);

            $SESSION->forcelang = $lang;

            self::assertEquals($strings, output\strings::get_all());
        }
    }

    public function test_get_ids() {
        global $SESSION;

        $generator = $this->getDataGenerator();
        $user = $generator->create_user();
        $this->setUser($user);

        $strings = self::setup_strings('en');

        $SESSION->forcelang = 'en';

        self::assertEquals(array_keys($strings), output\strings::get_ids());
    }

    public function test_get_many() {
        global $SESSION;

        $generator = $this->getDataGenerator();
        $user = $generator->create_user();
        $this->setUser($user);

        foreach (['en', 'ca', 'es'] as $lang) {
            $strings = self::setup_strings($lang);

            $SESSION->forcelang = $lang;

            $ids = self::random_items(array_keys($strings), 10);
            self::assertEquals(
                array_intersect_key($strings, array_combine($ids, $ids)),
                output\strings::get_many($ids)
            );
        }
    }

    private static function setup_strings(string $lang): array {
        global $CFG;

        make_writable_directory("$CFG->langlocalroot/{$lang}_local");
        $content = "<?php
            defined('MOODLE_INTERNAL') || die();
            \$string['forward'] = 'LOCAL';
        ";
        file_put_contents("$CFG->langlocalroot/{$lang}_local/local_mail.php", $content);

        $string = [];
        include("$CFG->dirroot/local/mail/lang/$lang/local_mail.php");
        $string['forward'] = 'LOCAL';

        return $string;
    }
}
