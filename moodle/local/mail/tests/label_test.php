<?php
/*
 * SPDX-FileCopyrightText: 2012-2013 Institut Obert de Catalunya <https://ioc.gencat.cat>
 * SPDX-FileCopyrightText: 2021 Marc Català <reskit@gmail.com>
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

namespace local_mail;

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__ . '/testcase.php');

/**
 * @covers \local_mail\label
 */
class label_test extends testcase {
    public function test_create() {
        $generator = self::getDataGenerator();
        $user = new user($generator->create_user());
        label::user_cache()->set($user->id, []);

        $label = label::create($user, 'name', 'red');

        self::assertInstanceOf(label::class, $label);
        self::assertGreaterThan(0, $label->id);
        self::assertEquals($user->id, $label->userid);
        self::assertEquals('name', $label->name);
        self::assertEquals('red', $label->color);
        self::assert_label($label);
        self::assertEquals($label, label::cache()->get($label->id));
        self::assertFalse(label::user_cache()->get($user->id));
    }

    public function test_delete() {
        $generator = self::getDataGenerator();
        $user = new user($generator->create_user());
        $course = new course($generator->create_course());
        $label1 = label::create($user, 'name 1', 'red');
        $label2 = label::create($user, 'name 2');
        $data = message_data::new($course, $user);
        $message = message::create($data);
        $message->set_labels($user, [$label1, $label2]);
        label::user_cache()->set($user->id, []);

        $label1->delete();

        self::assertNull(label::get($label1->id, IGNORE_MISSING));
        self::assertEquals($label2, label::get($label2->id));
        $message = message::get($message->id);
        self::assertEquals([$label2], $message->get_labels($user));
        self::assertFalse(label::cache()->get($label1->id));
        self::assertFalse(label::user_cache()->get($user->id));
    }

    public function test_get() {
        $generator = self::getDataGenerator();
        $user = new user($generator->create_user());
        $label = label::create($user, 'name 1', 'red');
        label::cache()->purge();

        $result = label::get($label->id);

        self::assertEquals($label, $result);
        self::assertEquals($label, label::cache()->get($label->id));

        // Missing label.
        try {
            label::get(123);
            self::fail();
        } catch (exception $e) {
            self::assertEquals('errorlabelnotfound', $e->errorcode);
            self::assertEquals(123, $e->a);
        }

        // Ignore missing label.
        self::assertNull(label::get(123, IGNORE_MISSING));
    }

    public function test_get_by_user() {
        $generator = self::getDataGenerator();
        $user1 = new user($generator->create_user());
        $user2 = new user($generator->create_user());
        $user3 = new user($generator->create_user());
        $label2 = label::create($user1, 'name 2', 'blue');
        $label4 = label::create($user1, 'name 4', 'purple');
        $label3 = label::create($user2, 'name 3', 'yellow');
        $label1 = label::create($user1, 'name 1', 'red');

        $result = label::get_by_user($user1);

        self::assertEquals([$label1->id, $label2->id, $label4->id], array_keys($result));
        self::assertEquals([$label1, $label2, $label4], array_values($result));
        self::assertEquals([$label1->id, $label2->id, $label4->id], label::user_cache()->get($user1->id));

        // User with no labels.
        self::assertEquals([], label::get_by_user($user3));
        self::assertEquals([], label::user_cache()->get($user3->id));

        // Get from cache.
        label::user_cache()->set($user1->id, [$label1->id, $label3->id]);
        $result = label::get_by_user($user1);
        self::assertEquals([$label1->id => $label1, $label3->id => $label3], $result);
    }

    public function test_get_many() {
        $generator = self::getDataGenerator();
        $user1 = new user($generator->create_user());
        $user2 = new user($generator->create_user());
        $label1 = label::create($user1, 'name 1', 'red');
        $label2 = label::create($user2, 'name 2', 'blue');
        $label3 = label::create($user1, 'name 3', 'yellow');

        label::cache()->purge();

        $result = label::get_many([$label1->id, $label2->id, $label1->id]);

        self::assertEquals([$label1->id => $label1, $label2->id => $label2], $result);
        self::assertEquals($label1, label::cache()->get($label1->id));
        self::assertEquals($label2, label::cache()->get($label2->id));

        // Missing label.
        try {
            label::get_many([$label1->id, 123, $label2->id]);
            self::fail();
        } catch (exception $e) {
            self::assertEquals('errorlabelnotfound', $e->errorcode);
            self::assertEquals(123, $e->a);
        }

        // Ignore missing label.
        $result = label::get_many([$label1->id, 123, $label2->id], IGNORE_MISSING);
        self::assertEquals([$label1->id => $label1, $label2->id => $label2], $result);

        // No IDs.
        self::assertEquals([], label::get_many([]));
    }

    public function test_update() {
        $generator = self::getDataGenerator();
        $user = new user($generator->create_user());
        $label = label::create($user, 'name 1', 'red');

        $label->update('new name', 'indigo');

        self::assertEquals('new name', $label->name);
        self::assertEquals('indigo', $label->color);
        self::assert_label($label);
        self::assertEquals($label, label::cache()->get($label->id));
    }

    public function test_normalized_name() {
        self::assertEquals('', label::nromalized_name(''));
        self::assertEquals('word', label::nromalized_name('word'));
        self::assertEquals('multiple words', label::nromalized_name('multiple words'));
        self::assertEquals('collapse space', label::nromalized_name('collapse     space'));
        self::assertEquals('replace line breaks', label::nromalized_name("replace\nline\rbreaks"));
        self::assertEquals('replace tab character', label::nromalized_name("replace\ttab\tcharacter"));
        self::assertEquals('trim text', label::nromalized_name('  trim text  '));
    }

    /**
     * Asserts that a label is stored correctly in the database.
     *
     * @param label $label Label.
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    protected static function assert_label(label $label): void {
        self::assert_record_data('labels', [
            'id' => $label->id,
        ], [
            'userid' => $label->userid,
            'name' => $label->name,
            'color' => $label->color,
        ]);
    }
}
