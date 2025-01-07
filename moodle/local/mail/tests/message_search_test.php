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
 * @covers \local_mail\message_search
 */
class message_search_test extends testcase {
    /* Constants used for generating random mail data. */
    private const NUM_COURSES = 5;
    private const NUM_USERS = 10;
    private const NUM_COURSES_PER_USER = 4;
    private const NUM_LABELS_PER_USER = 3;
    private const NUM_MESSAGES = 1000;
    private const REPLY_FREQ = 0.5;
    private const DRAFT_FREQ = 0.2;
    private const RECIPIENT_FREQ = 0.2;
    private const UNREAD_FREQ = 0.2;
    private const STARRED_FREQ = 0.2;
    private const DELETED_FREQ = 0.2;
    private const DELETED_FOREVER_FREQ = 0.1;
    private const ATTACHMENT_FREQ = 0.2;
    private const INC_TIME_FREQ = 0.9;
    private const WORDS = [
        'Xiuxiuejar', 'Aixopluc', 'Caliu', 'Tendresa', 'Llibertat',
        'Moixaina', 'Amanyagar', 'Enraonar', 'Ginesta', 'Atzavara', 'Paral·lel',
    ];

    public function test_count() {
        [$users, $messages] = self::generate_data();
        foreach (self::cases($users, $messages) as $search) {
            $expected = count(self::search_result($messages, $search));
            self::assertEquals($expected, $search->count(), $search);
        }
    }

    public function test_count_per_course() {
        [$users, $messages] = self::generate_data();
        foreach (self::cases($users, $messages) as $search) {
            $expected = [];
            foreach (self::search_result($messages, $search) as $message) {
                $expected[$message->courseid] = ($expected[$message->courseid] ?? 0) + 1;
            }
            self::assertEquals($expected, $search->count_per_course(), $search);
        }
    }

    public function test_count_per_label() {
        [$users, $messages] = self::generate_data();
        foreach (self::cases($users, $messages) as $search) {
            $expected = [];
            foreach (self::search_result($messages, $search) as $message) {
                foreach ($message->get_labels($search->user) as $label) {
                    if (!$search->label || $search->label->id == $label->id) {
                        $expected[$label->id][$message->courseid] = ($expected[$label->id][$message->courseid] ?? 0) + 1;
                    }
                }
            }
            self::assertEquals($expected, $search->count_per_label(), $search);
        }
    }

    public function test_get() {
        [$users, $messages] = self::generate_data();
        foreach (self::cases($users, $messages) as $search) {
            $expected = self::search_result($messages, $search);
            $result = $search->get(0, 0);
            self::assertEquals($expected, $result, $search);
            self::assertEquals(array_keys($expected), array_keys($result), $search);

            // Offset and limit.
            $expected = array_slice($expected, 5, 20, true);
            $result = $search->get(5, 20);
            self::assertEquals($expected, $result, $search);
            self::assertEquals(array_keys($expected), array_keys($result), $search);
        }
    }


    /**
     * Returns different search casses for the givem users and messages.
     *
     * @param user[] $users All users.
     * @param message[] $messages All messages.
     * @return message_search[] Array of search parameters.
     */
    public static function cases(array $users, array $messages): array {
        $result = [];

        foreach ($users as $user) {
            // All messages.
            $result[] = new message_search($user);

            // Inbox.
            $search = new message_search($user);
            $search->roles = [message::ROLE_TO, message::ROLE_CC, message::ROLE_BCC];
            $result[] = $search;

            // Unread.
            $search = new message_search($user);
            $search->roles = [message::ROLE_TO, message::ROLE_CC, message::ROLE_BCC];
            $search->unread = true;
            $result[] = $search;

            // Starred.
            $search = new message_search($user);
            $search->starred = true;
            $result[] = $search;

            // Sent.
            $search = new message_search($user);
            $search->draft = false;
            $search->roles = [message::ROLE_FROM];
            $result[] = $search;

            // Drafts.
            $search = new message_search($user);
            $search->draft = true;
            $search->roles = [message::ROLE_FROM];
            $result[] = $search;

            // Trash.
            $search = new message_search($user);
            $search->deleted = true;
            $result[] = $search;

            // Course.
            foreach (course::get_by_user($user) as $course) {
                $search = new message_search($user);
                $search->course = $course;
                $result[] = $search;
            }

            // Label.
            foreach (label::get_by_user($user) as $label) {
                $search = new message_search($user);
                $search->label = $label;
                $result[] = $search;
            }

            // Content.
            $search = new message_search($user);
            $search->content = self::random_item($messages)->subject;
            $result[] = $search;

            // Sender name.
            $search = new message_search($user);
            $search->sendername = self::random_item($users)->fullname();
            $result[] = $search;

            // Recipient name.
            $search = new message_search($user);
            $search->recipientname = self::random_item($users)->fullname();
            $result[] = $search;

            // With files only.
            $search = new message_search($user);
            $search->withfilesonly = true;
            $result[] = $search;

            // Max time.
            $search = new message_search($user);
            $search->maxtime = self::random_item($messages)->time;
            $result[] = $search;

            // Start message.
            $search = new message_search($user);
            $search->start = self::random_item($messages);
            $result[] = $search;

            // Stop message.
            $search = new message_search($user);
            $search->stop = self::random_item($messages);
            $result[] = $search;

            // Reverse.
            $search = new message_search($user);
            $search->reverse = true;
            $result[] = $search;

            // Start and reverse.
            $search = new message_search($user);
            $search->start = self::random_item($messages);
            $search->reverse = true;
            $result[] = $search;

            // Stop and reverse.
            $search = new message_search($user);
            $search->stop = self::random_item($messages);
            $search->reverse = true;
            $result[] = $search;

            // Impossible search, always results in no messages.
            $search = new message_search($user);
            $search->roles = [message::ROLE_TO];
            $search->draft = true;
            $result[] = $search;
        }

        return $result;
    }

    /**
     * Generates random courses, users, labels and messages.
     *
     * @return array Array with users and messages.
     */
    public static function generate_data() {
        $generator = self::getDataGenerator();

        $courses = [];
        $users = [];
        $userlabels = [];
        $messages = [];
        $sentmessages = [];

        $time = make_timestamp(2021, 10, 11, 12, 0);

        for ($i = 0; $i < self::NUM_COURSES; $i++) {
            $courses[] = new course($generator->create_course());
        }

        for ($i = 0; $i < self::NUM_USERS; $i++) {
            $user = new user($generator->create_user());
            $users[] = $user;
            $userlabels[$user->id] = [];
            // One user with no courses and no labels.
            if ($i == 0) {
                continue;
            }
            foreach (self::random_items($courses, self::NUM_COURSES_PER_USER) as $course) {
                $generator->enrol_user($user->id, $course->id, 'student');
            }
            foreach (self::random_items(self::WORDS, self::NUM_LABELS_PER_USER) as $name) {
                $userlabels[$user->id][] = label::create($user, $name);
            }
            // One label with no messages.
            $userlabels[$user->id] = array_slice($userlabels[$user->id], 1);
        }

        // One user and one course with no messages.
        $participants = array_slice($users, 0, count($users) - 1);
        $courses = array_slice($courses, 1);

        for ($i = 0; $i < self::NUM_MESSAGES; $i++) {
            if (self::random_bool(self::INC_TIME_FREQ)) {
                $time++;
            }

            if (count($sentmessages) > 0 && self::random_bool(self::REPLY_FREQ)) {
                $reference = self::random_item($sentmessages);
                $data = message_data::reply($reference, self::random_item($reference->get_recipients()), false);
            } else {
                $data = message_data::new(self::random_item($courses), self::random_item($participants));
            }

            if (self::random_bool(self::ATTACHMENT_FREQ)) {
                $filename = self::random_item(self::WORDS) . '.txt';
                $content = self::random_item(self::WORDS) . ' ' . self::random_item(self::WORDS);
                self::create_draft_file($data->draftitemid, $filename, $content);
            }

            $data->subject = self::random_item(self::WORDS);
            $data->content = ' <p> ' . self::random_item(self::WORDS) . '   ' . self::random_item(self::WORDS) . ' </p> ';
            $data->format = FORMAT_HTML;
            $data->time = $time;

            if ($data->course) {
                foreach ($participants as $user) {
                    if ($user->id != $data->sender->id && self::random_bool(self::RECIPIENT_FREQ)) {
                        $rolename = self::random_item(['to', 'cc', 'bcc']);
                        $data->{$rolename}[] = $user;
                    }
                }
            }

            $message = message::create($data);

            $message->set_starred($data->sender, self::random_bool(self::STARRED_FREQ));
            $message->set_labels($data->sender, self::random_items($userlabels[$data->sender->id]));

            $messages[] = $message;

            if (self::random_bool(self::DRAFT_FREQ) || !$message->get_recipients()) {
                continue;
            }

            $message->send($time);
            $sentmessages[] = $message;

            $message->set_unread($data->sender, self::random_bool(self::UNREAD_FREQ));

            foreach ([$data->sender, ...$message->get_recipients()] as $user) {
                $message->set_unread($user, self::random_bool(self::UNREAD_FREQ));
                if ($user->id != $data->sender->id) {
                    $message->set_starred($user, self::random_bool(self::STARRED_FREQ));
                    $message->set_labels($user, self::random_items($userlabels[$user->id]));
                }
                if (self::random_bool(self::DELETED_FREQ)) {
                    $message->set_deleted($user, message::DELETED);
                }
                if (self::random_bool(self::DELETED_FOREVER_FREQ)) {
                    $message->set_deleted($user, message::DELETED_FOREVER);
                }
            }
        }

        return [$users, $messages];
    }

    /**
     * Returns thee generated messages filtered by search parameters.
     *
     * @param message[] $messages Array of messages.
     * @param message_search $search Search parameters.
     * @return message[] Found messages, ordered from newer to older and indexed by ID.
     */
    protected static function search_result(array $messages, message_search $search): array {
        $courseids = $search->course ? [$search->course->id] : array_keys(course::get_by_user($search->user));

        $result = [];

        foreach (array_reverse($messages) as $message) {
            if (
                !in_array($message->courseid, $courseids) ||
                $search->user->id != $message->get_sender()->id && !$message->has_recipient($search->user) ||
                $search->user->id != $message->get_sender()->id && $message->draft ||
                $search->label && !$message->has_label($search->label) ||
                $search->draft !== null && $search->draft != $message->draft ||
                $search->roles && !in_array($message->role($search->user), $search->roles) ||
                $search->unread !== null && $message->unread($search->user) != $search->unread ||
                $search->starred !== null && $message->starred($search->user) != $search->starred ||
                !$search->deleted && $message->deleted($search->user) != message::NOT_DELETED ||
                $search->deleted && $message->deleted($search->user) != message::DELETED ||
                $search->withfilesonly && $message->attachments == 0 ||
                $search->maxtime && $message->time > $search->maxtime ||
                $search->start && !$search->reverse && $message->id >= $search->start->id ||
                $search->start && $search->reverse && $message->id <= $search->start->id ||
                $search->stop && !$search->reverse && $message->id <= $search->stop->id ||
                $search->stop && $search->reverse && $message->id >= $search->stop->id
            ) {
                continue;
            }
            if ($search->content != '') {
                $found = false;
                $pattern = message::normalize_text($search->content, FORMAT_PLAIN);
                if (\core_text::strpos(message::normalize_text($message->subject, FORMAT_PLAIN), $pattern) !== false) {
                    $found = true;
                }
                if (\core_text::strpos(message::normalize_text($message->content, FORMAT_PLAIN), $pattern) !== false) {
                    $found = true;
                }
                foreach ([$message->get_sender(), ...$message->get_recipients(message::ROLE_TO, message::ROLE_CC)] as $user) {
                    if (\core_text::strpos($user->fullname(), $pattern) !== false) {
                        $found = true;
                    }
                }
                if (!$found) {
                    continue;
                }
            }
            if ($search->sendername != '') {
                $pattern = message::normalize_text($search->sendername, FORMAT_PLAIN);
                if (\core_text::strpos($message->get_sender()->fullname(), $pattern) === false) {
                    continue;
                }
            }
            if ($search->recipientname != '') {
                $found = false;
                $pattern = message::normalize_text($search->recipientname, FORMAT_PLAIN);
                foreach ($message->get_recipients(message::ROLE_TO, message::ROLE_CC) as $user) {
                    if (\core_text::strpos($user->fullname(), $pattern) !== false) {
                        $found = true;
                    }
                }
                if (!$found) {
                    continue;
                }
            }

            $result[$message->id] = $message;
        }

        if ($search->reverse) {
            $result = array_reverse($result, true);
        }

        return $result;
    }
}
