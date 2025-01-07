<?php
/*
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 * SPDX-FileCopyrightText: 2024 Albert Gasset <albertgasset@fsfe.org>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

namespace local_mail;

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__ . '/testcase.php');

/**
 * @covers \local_mail\course
 */
class course_test extends testcase {
    public function test_get() {
        $generator = self::getDataGenerator();
        $record = $generator->create_course(['groupmode' => SEPARATEGROUPS]);
        $grouping = $generator->create_grouping(['courseid' => $record->id]);
        $record->defaultgroupingid = $grouping->id;
        update_course($record);

        $course = course::get($record->id);

        self::assertInstanceOf(course::class, $course);
        self::assertEquals((int) $record->id, $course->id);
        self::assertEquals($record->shortname, $course->shortname);
        self::assertEquals($record->fullname, $course->fullname);
        self::assertEquals((bool) $record->visible, $course->visible);
        self::assertEquals((int) $record->groupmode, $course->groupmode);
        self::assertEquals((int) $record->defaultgroupingid, $course->defaultgroupingid);
        self::assertEquals($course, course::cache()->get($course->id));

        // Missing course.
        try {
            course::get(123);
            self::fail();
        } catch (exception $e) {
            self::assertEquals('errorcoursenotfound', $e->errorcode);
            self::assertEquals(123, $e->a);
        }

        // Ignored missing course.
        self::assertNull(course::get(123, IGNORE_MISSING));
    }

    public function test_get_by_user() {
        $generator = self::getDataGenerator();
        $course1 = new course($generator->create_course());
        $course2 = new course($generator->create_course());
        $course3 = new course($generator->create_course());
        $course4 = new course($generator->create_course());
        $course5 = new course($generator->create_course(['visible' => false]));
        $course6 = new course($generator->create_course());
        $user1 = new user($generator->create_user());
        $user2 = new user($generator->create_user());
        $user3 = new user($generator->create_user());
        $generator->enrol_user($user1->id, $course1->id);
        $generator->enrol_user($user1->id, $course2->id);
        $generator->enrol_user($user2->id, $course3->id);
        $generator->enrol_user($user1->id, $course4->id);
        $generator->enrol_user($user1->id, $course5->id);
        $generator->enrol_user($user1->id, $course6->id, 'guest');

        $result = course::get_by_user($user1);

        self::assertEquals([$course4->id => $course4, $course2->id => $course2, $course1->id => $course1], $result);
        self::assertEquals($course1, course::cache()->get($course1->id));
        self::assertEquals($course2, course::cache()->get($course2->id));
        self::assertEquals($course4, course::cache()->get($course4->id));
        self::assertFalse(course::cache()->has($course3->id));
        self::assertFalse(course::cache()->has($course5->id));
        self::assertFalse(course::cache()->has($course6->id));
        self::assertEquals([$course4->id, $course2->id, $course1->id], course::user_cache()->get($user1->id));

        // Use with no courses.
        self::assertEquals([], course::get_by_user($user3));
        self::assertEquals([], course::user_cache()->get($user3->id));

        // Get from cache.
        course::user_cache()->set($user1->id, [$course1->id, $course3->id]);
        $result = course::get_by_user($user1);
        self::assertEquals([$course1->id => $course1, $course3->id => $course3], $result);
    }

    public function test_get_context() {
        $generator = self::getDataGenerator();
        $course1 = new course($generator->create_course());
        $course2 = new course($generator->create_course());

        self::assertEquals(\context_course::instance($course1->id), $course1->get_context());
        self::assertEquals(\context_course::instance($course2->id), $course2->get_context());
    }

    public function test_get_many() {
        $generator = self::getDataGenerator();
        $course1 = new course($generator->create_course());
        $course2 = new course($generator->create_course());
        $course3 = new course($generator->create_course());

        $result = course::get_many([$course2->id, $course3->id, $course1->id, $course3->id]);

        self::assertEquals([$course2->id => $course2, $course3->id => $course3, $course1->id => $course1], $result);
        self::assertEquals($course1, course::cache()->get($course1->id));
        self::assertEquals($course2, course::cache()->get($course2->id));
        self::assertEquals($course3, course::cache()->get($course3->id));

        // Missing course.
        try {
            course::get_many([$course1->id, 123, $course2->id]);
            self::fail();
        } catch (exception $e) {
            self::assertEquals('errorcoursenotfound', $e->errorcode);
            self::assertEquals(123, $e->a);
        }

        // Ignored missing course.
        $result = course::get_many([$course1->id, 123, $course2->id], IGNORE_MISSING);
        self::assertEquals([$course1->id => $course1, $course2->id => $course2], $result);

        // No IDs.
        self::assertEquals([], course::get_many([]));
    }

    public function test_get_viewable_groups() {
        $generator = self::getDataGenerator();
        $course1 = new course($generator->create_course(['groupmode' => NOGROUPS]));
        $course2 = new course($generator->create_course(['groupmode' => VISIBLEGROUPS]));
        $course3 = new course($generator->create_course(['groupmode' => SEPARATEGROUPS]));
        $group1 = $generator->create_group(['courseid' => $course1->id]);
        $group2 = $generator->create_group(['courseid' => $course2->id]);
        $group3 = $generator->create_group(['courseid' => $course2->id]);
        $group4 = $generator->create_group(['courseid' => $course3->id]);
        $group5 = $generator->create_group(['courseid' => $course3->id]);

        $user1 = new user($generator->create_user());
        $user2 = new user($generator->create_user());
        $generator->enrol_user($user1->id, $course1->id, 'student');
        $generator->enrol_user($user1->id, $course2->id, 'student');
        $generator->enrol_user($user1->id, $course3->id, 'student');
        $generator->enrol_user($user2->id, $course1->id, 'editingteacher');
        $generator->enrol_user($user2->id, $course2->id, 'editingteacher');
        $generator->enrol_user($user2->id, $course3->id, 'editingteacher');
        $generator->create_group_member(['userid' => $user1->id, 'groupid' => $group1->id]);
        $generator->create_group_member(['userid' => $user2->id, 'groupid' => $group1->id]);
        $generator->create_group_member(['userid' => $user1->id, 'groupid' => $group2->id]);
        $generator->create_group_member(['userid' => $user1->id, 'groupid' => $group4->id]);
        $generator->create_group_member(['userid' => $user2->id, 'groupid' => $group5->id]);

        // Student in course with no groups.
        self::assertEquals([], $course1->get_viewable_groups($user1));

        // Teacher in course with no groups.
        self::assertEquals([], $course1->get_viewable_groups($user2));

        // Student in course with visible groups.
        $expected = [
            0 => get_string('allgroups', 'local_mail'),
            $group2->id => $group2->name,
            $group3->id => $group3->name,
        ];
        self::assertEquals($expected, $course2->get_viewable_groups($user1));

        // Teacher in course with visible groups.
        $expected = [
            0 => get_string('allgroups', 'local_mail'),
            $group2->id => $group2->name,
            $group3->id => $group3->name,
        ];
        self::assertEquals($expected, $course2->get_viewable_groups($user2));

        // Student in course with separate groups.
        $expected = [$group4->id => $group4->name];
        self::assertEquals($expected, $course3->get_viewable_groups($user1));

        // Teacher in course with separate groups (access all groups capability).
        $expected = [
            0 => get_string('allgroups', 'local_mail'),
            $group4->id => $group4->name,
            $group5->id => $group5->name,
        ];
        self::assertEquals($expected, $course3->get_viewable_groups($user2));
    }

    public function test_get_viewable_roles() {
        $generator = self::getDataGenerator();
        $course = new course($generator->create_course());
        $user = new user($generator->create_user());
        $generator->enrol_user($user->id, $course->id);
        self::setUser($user->id);

        $roles = get_roles_with_capability('local/mail:usemail');
        $expected = [];
        foreach (get_viewable_roles($course->get_context(), $user->id) as $roleid => $rolename) {
            if (isset($roles[$roleid])) {
                $expected[$roleid] = $rolename;
            }
        }

        self::assertEquals($expected, $course->get_viewable_roles($user));
    }

    public function test_url() {
        global $CFG;

        $generator = self::getDataGenerator();
        $course = new course($generator->create_course());

        self::assertEquals("$CFG->wwwroot/course/view.php?id={$course->id}", $course->url());
    }
}
