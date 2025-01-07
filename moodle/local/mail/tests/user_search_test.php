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
 * @covers \local_mail\user_search
 */
class user_search_test extends testcase {
    private const NUM_USERS = 50;

    public function test_count() {
        $users = self::generate_data();
        foreach (self::cases($users) as $search) {
            $expected = count(self::filter_users($users, $search));
            self::assertEquals($expected, $search->count(), $search);
        }
    }

    public function test_get() {
        $users = self::generate_data();
        foreach (self::cases($users) as $search) {
            $filteredusers = self::filter_users($users, $search);
            $expected = array_slice($filteredusers, 5, 10, true);
            $result = $search->get(5, 10);
            self::assertEquals($expected, $result, $search);
            self::assertEquals(array_keys($expected), array_keys($result), $search);
        }
    }

    /**
     * Returns different search casses for the givem users.
     *
     * @param user[] $users All users.
     * @return user_search[] Array of search parameters.
     */
    public static function cases(array $users): array {
        $result = [];

        foreach ($users as $user) {
            foreach (course::get_by_user($user) as $course) {
                // All users.
                $result[] = new user_search($user, $course);

                // Roles.
                foreach (array_keys($course->get_viewable_roles($user)) as $roleid) {
                    $search = new user_search($user, $course);
                    $search->roleid = $roleid;
                    $result[] = $search;
                }

                // Groups.
                foreach (array_keys(groups_get_all_groups($course->id, 0, $course->defaultgroupingid)) as $groupid) {
                    $search = new user_search($user, $course);
                    $search->groupid = $groupid;
                    $result[] = $search;
                }

                // Full name.
                $search = new user_search($user, $course);
                $search->fullname = self::random_item($users)->firstname;
                $result[] = $search;

                // Include.
                $search = new user_search($user, $course);
                $search->include = array_column(self::random_items($users, self::NUM_USERS / 2), 'id');
                $result[] = $search;
            }
        }

        return $result;
    }

    /**
     * Returns thee generated users filtered by search parameters.
     *
     * @param message[] $message Array of messages.
     * @param user_search $search Search parameters.
     * @return user[] Found users, indexed by ID.
     */
    protected static function filter_users(array $users, user_search $search): array {
        global $DB;

        $context = $search->course->get_context();

        $excludedroleids = [];
        if (!has_capability('local/mail:mailsamerole', $context, $search->user->id, false)) {
            $excludedroleids = array_column(get_user_roles($context, $search->user->id, false), 'roleid');
        }

        $usergroups = $search->course->get_viewable_groups($search->user);

        $fullnamematches = [];
        if ($search->fullname) {
            $select = $DB->sql_like($DB->sql_fullname(), '?', false, false);
            $params = ['%' . $DB->sql_like_escape($search->fullname) . '%'];
            $fullnamematches = $DB->get_records_select('user', $select, $params);
        }

        $result = [];

        foreach ($users as $user) {
            if (
                $user->id == $search->user->id ||
                !is_enrolled($context, $user, 'local/mail:usemail', true) ||
                $excludedroleids && array_intersect(
                    $excludedroleids,
                    array_column(get_user_roles($context, $user->id, false), 'roleid')
                ) ||
                $search->roleid && !user_has_role_assignment($user->id, $search->roleid, $context->id) ||
                $search->groupid && !groups_is_member($search->groupid, $user->id) ||
                $search->fullname && !isset($fullnamematches[$user->id]) ||
                $search->include && !in_array($user->id, $search->include)
            ) {
                continue;
            }

            $result[$user->id] = $user;
        }

        return $result;
    }

    /**
     * Generates random users and courses.
     *
     * @return user[] Users.
     */
    public static function generate_data(): array {
        $generator = self::getDataGenerator();

        $courses = [];
        $users = [];
        $roleids = [];
        $groupids = [];

        // Generate roles.
        foreach (get_roles_with_capability('local/mail:usemail') as $role) {
            unassign_capability('local/mail:usemail', $role->id);
            unassign_capability('local/mail:mailsamerole', $role->id);
        }
        $rolecaps = [
            [],
            ['local/mail:usemail' => 'allow'],
            ['local/mail:usemail' => 'allow', 'local/mail:mailsamerole' => 'allow'],
        ];
        foreach ($rolecaps as $caps) {
            $roleid = $generator->create_role();
            $generator->create_role_capability($roleid, $caps, \context_system::instance());
            $roleids[] = $roleid;
        }

        // Generate courses and group.
        foreach ([NOGROUPS, VISIBLEGROUPS, SEPARATEGROUPS] as $groupmode) {
            $course = new course($generator->create_course(['groupmode' => $groupmode]));
            $courses[] = $course;
            $roles[$course->id] = get_role_names_with_caps_in_context($course->get_context(), ['local/mail:usemail']);
            $group1 = $generator->create_group(['courseid' => $course->id]);
            $group2 = $generator->create_group(['courseid' => $course->id]);
            $groupids[$course->id] = [0, $group1->id, $group2->id];
        }

        // Generate users.
        for ($i = 0; $i < self::NUM_USERS; $i++) {
            $user = new user($generator->create_user());
            $users[] = $user;
            foreach (self::random_items($courses, count($courses) - 1) as $course) {
                $roleid = self::random_item($roleids);
                $generator->enrol_user($user->id, $course->id, $roleid);
                $groupid = self::random_item($groupids[$course->id]);
                if ($groupid) {
                    $generator->create_group_member(['userid' => $user->id, 'groupid' => $groupid]);
                }
            }
        }

        // Sort users.
        \core_collator::asort_objects_by_method($users, 'sortorder');

        return $users;
    }
}
