<?php
/*
 * SPDX-FileCopyrightText: 2012-2014 Institut Obert de Catalunya <https://ioc.gencat.cat>
 * SPDX-FileCopyrightText: 2014-2021 Marc Català <reskit@gmail.com>
 * SPDX-FileCopyrightText: 2016-2017 Albert Gasset <albertgasset@fsfe.org>
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

namespace local_mail;

class message {
    // Deleted stataus constants.
    const NOT_DELETED = 0;
    const DELETED = 1;
    const DELETED_FOREVER = 2;

    // Role constants.
    const ROLE_FROM = 1;
    const ROLE_TO = 2;
    const ROLE_CC = 3;
    const ROLE_BCC = 4;

    /** @var int Message ID. */
    public int $id;

    /** @var int Course ID. */
    public int $courseid;

    /** @var string Subject. */
    public string $subject;

    /** @var string Body content. */
    public string $content;

    /** @var int Body format. */
    public int $format;

    /** @var int Number of attachments. */
    public int $attachments;

    /** @var bool Draft status. */
    public bool $draft;

    /** @var int Timestamp. */
    public int $time;

    /** @var int[] Roles, indexed by user ID. */
    private array $roles = [];

    /** @var bool[] Unread status, indexed by user ID. */
    private array $unread = [];

    /** @var bool[] Starred status, indexed by user ID. */
    private array $starred = [];

    /** @var int[] Deleted status, indexed by user ID. */
    private array $deleted = [];

    /** @var int[][] Labels IDs, indexed by user ID and label ID. */
    private array $labelids = [];

    /**
     * Constructs a message instance from a database record.
     *
     * @param \stdClass $record Record of local_mail_messages.
     */
    private function __construct(\stdClass $record) {
        $this->id = (int) $record->id;
        $this->courseid = (int) $record->courseid;
        $this->subject = $record->subject;
        $this->content = $record->content;
        $this->format = (int) $record->format;
        $this->attachments = (int) $record->attachments;
        $this->draft = (bool) $record->draft;
        $this->time = (int) $record->time;
    }

    /**
     * Cache of messages, indexed by ID.
     *
     * @return \cache
     */
    public static function cache(): \cache {
        return \cache::make('local_mail', 'messages');
    }

    /**
     * Creates a new empty draft.
     *
     * @param message_data $data Message data.
     * @return self Created message.
     */
    public static function create(message_data $data): self {
        global $DB;

        assert(!$data->reference || isset($data->reference->roles[$data->sender->id]));
        assert(!$data->reference || $data->course->id == $data->reference->courseid);

        $transaction = $DB->start_delegated_transaction();

        $messagerecord = new \stdClass();
        $messagerecord->courseid = $data->course->id;
        $messagerecord->subject = '';
        $messagerecord->content = '';
        $messagerecord->format = FORMAT_HTML;
        $messagerecord->attachments = 0;
        $messagerecord->draft = 1;
        $messagerecord->time = 0;
        $messagerecord->normalizedsubject = '';
        $messagerecord->normalizedcontent = '';
        $messagerecord->id = $DB->insert_record('local_mail_messages', $messagerecord);
        $message = new self($messagerecord);

        // Sender.
        $message->roles[$data->sender->id] = self::ROLE_FROM;
        $message->unread[$data->sender->id] = false;
        $message->starred[$data->sender->id] = false;
        $message->deleted[$data->sender->id] = self::NOT_DELETED;
        $message->labelids[$data->sender->id] = [];
        $userrecord = new \stdClass();
        $userrecord->messageid = $message->id;
        $userrecord->courseid = $data->course->id;
        $userrecord->draft = 1;
        $userrecord->time = 0;
        $userrecord->userid = $data->sender->id;
        $userrecord->role = self::ROLE_FROM;
        $userrecord->unread = 0;
        $userrecord->starred = 0;
        $userrecord->deleted = self::NOT_DELETED;
        $DB->insert_record('local_mail_message_users', $userrecord);

        // References.
        if ($data->reference) {
            $records = [['messageid' => $message->id, 'reference' => $data->reference->id]];
            foreach ($data->reference->get_references() as $reference) {
                $records[] = ['messageid' => $message->id, 'reference' => $reference->id];
            }
            $DB->insert_records('local_mail_message_refs', $records);
        }

        // Labels.
        if ($data->reference) {
            $labels = label::get_many($data->reference->labelids[$data->sender->id]);
            $message->set_labels($data->sender, $labels);
        }

        $message->update($data);

        $transaction->allow_commit();

        return $message;
    }

    /**
     * Deletes all messages from a course.
     *
     * @param \context_course $context Context of the course.
     */
    public static function delete_course(\context_course $context): void {
        global $DB;

        $transaction = $DB->start_delegated_transaction();

        $DB->delete_records('local_mail_message_labels', ['courseid' => $context->instanceid]);

        $DB->delete_records('local_mail_message_users', ['courseid' => $context->instanceid]);

        $select = 'messageid IN (SELECT id FROM {local_mail_messages} WHERE courseid = :courseid)';
        $DB->delete_records_select('local_mail_message_refs', $select, ['courseid' => $context->instanceid]);

        $DB->delete_records('local_mail_messages', ['courseid' => $context->instanceid]);

        $transaction->allow_commit();

        $fs = get_file_storage();
        $fs->delete_area_files($context->id, 'local_mail');

        self::cache()->purge();
    }

    /**
     * Gets a message from the database.
     *
     * @param int $id ID of the message to get.
     * @param int $strictness MUST_EXIST or IGNORE_MISSING.
     * @return ?self
     */
    public static function get(int $id, int $strictness = MUST_EXIST): ?self {
        $messages = self::get_many([$id], $strictness);

        return $messages[$id] ?? null;
    }

    /**
     * Gets messages from the database.
     *
     * @param int[] $ids IDs of the messages to get.
     * @param int $strictness MUST_EXIST or IGNORE_MISSING.
     * @return self[] Array of messages ordered from newer to older and indexed by ID.
     */
    public static function get_many(array $ids, int $strictness = MUST_EXIST): array {
        global $DB;

        $messages = self::cache()->get_many($ids);
        $missingids = array_filter($ids, fn ($id) => !$messages[$id]);

        if ($missingids) {
            // Get message records.
            [$sqlid, $params] = $DB->get_in_or_equal($missingids);
            $fields = 'id, courseid, subject, content, format, attachments, draft, time';
            $messagerecords = $DB->get_records_select('local_mail_messages', "id $sqlid", $params, '', $fields);

            // Construct messages.
            foreach ($missingids as $id) {
                if (isset($messagerecords[$id])) {
                    $messages[$id] = new self($messagerecords[$id]);
                } else if ($strictness == MUST_EXIST) {
                    throw new exception('errormessagenotfound', $id);
                }
            }

            // Get message users.
            $fields = 'id, messageid, userid, role, unread, starred, deleted';
            $messageuserrecords = $DB->get_records_select('local_mail_message_users', "messageid $sqlid", $params, '', $fields);
            foreach ($messageuserrecords as $r) {
                $messages[$r->messageid]->roles[$r->userid] = (int) $r->role;
                $messages[$r->messageid]->unread[$r->userid] = (bool) $r->unread;
                $messages[$r->messageid]->starred[$r->userid] = (bool) $r->starred;
                $messages[$r->messageid]->deleted[$r->userid] = (int) $r->deleted;
                $messages[$r->messageid]->labelids[$r->userid] = [];
            }

            // Get message labels.
            $sql = 'SELECT ml.id, ml.messageid, ml.labelid, l.userid'
                . ' FROM {local_mail_message_labels} ml'
                . ' JOIN {local_mail_labels} l ON l.id = ml.labelid'
                . ' WHERE ml.messageid ' . $sqlid;
            foreach ($DB->get_records_sql($sql, $params) as $r) {
                $messages[$r->messageid]->labelids[$r->userid][$r->labelid] = $r->labelid;
            }

            // Prefetch courses and users.
            course::get_many(array_column($messagerecords, 'courseid'));
            user::get_many(array_column($messageuserrecords, 'userid'));

            // Save messages to cache.
            foreach ($missingids as $id) {
                self::cache()->set($id, $messages[$id]);
            }
        }

        // Sort messages by ascending time and ascending ID.
        $messages = array_filter($messages);
        uasort($messages, fn ($a, $b) => $a->time == $b->time ? $b->id - $a->id : $b->time - $a->time);

        return $messages;
    }

    /**
     * Normalizes text for searching.
     *
     * Converts to plain text and replaces non-alphanumeric characters with a space.
     *
     * @param string $text Text to normalize.
     * @param int $format Format of the text to normalize.
     * @return string
     */
    public static function normalize_text(string $text, int $format): string {
        // Removes @@PLUGINFILE@@/ from text.
        $text = str_replace('@@PLUGINFILE@@/', '', $text);

        // Formats text and converts HTML to plain text.
        $text = format_text($text, $format, ['filter' => false, 'para' => false]);
        $text = html_to_text($text, 0, false);

        // Replaces non-alphanumeric characters with a space.
        return trim(preg_replace('/(*UTF8)[^\p{L}\p{N}]+/', ' ', $text));
    }

    /**
     * Returns all the role names.
     *
     * @return string[] Array of role names indexed by value.
     */
    public static function role_names(): array {
        return [
            self::ROLE_FROM => 'from',
            self::ROLE_TO => 'to',
            self::ROLE_CC => 'cc',
            self::ROLE_BCC => 'bcc',
        ];
    }

    /**
     * Returns the deleted status of the message.
     *
     * @param user $user User.
     * @return int
     */
    public function deleted(user $user): int {
        assert(isset($this->roles[$user->id]));

        return $this->deleted[$user->id];
    }

    /**
     * Gets the course of the message.
     *
     * @return course
     */
    public function get_course(): course {
        return course::get($this->courseid);
    }

    /**
     * Gets the user labels of the message.
     *
     * @param user $user User.
     * @return label[] Array of labels sorted by name.
     */
    public function get_labels(user $user): array {
        assert(isset($this->roles[$user->id]));

        $labels = label::get_many($this->labelids[$user->id]);

        \core_collator::asort_objects_by_property($labels, 'name', \core_collator::SORT_NATURAL);

        return array_values($labels);
    }

    /**
     * Gets the recipients of the message.
     *
     * @param int $roles Roles to include. Defaults to all roles.
     * @return user[] Array of sorted users indexed by ID.
     */
    public function get_recipients(int ...$roles): array {
        foreach ($roles as $role) {
            assert(in_array($role, [self::ROLE_TO, self::ROLE_CC, self::ROLE_BCC]));
        }

        $userids = [];
        foreach ($this->roles as $userid => $role) {
            if ($role != self::ROLE_FROM && (!$roles || in_array($role, $roles))) {
                $userids[] = $userid;
            }
        }

        $recipients = user::get_many($userids);

        \core_collator::asort_objects_by_method($recipients, 'sortorder');

        return array_values($recipients);
    }

    /**
     * Gets the references of the message.
     *
     * @param bool $reverse Return forward references instead of backward references.
     * @return self[] Array of references indexed by ID.
     */
    public function get_references(bool $forward = false): array {
        global $DB;

        if ($forward) {
            $conditions = ['reference' => $this->id];
            $field = 'messageid';
        } else {
            $conditions = ['messageid' => $this->id];
            $field = 'reference';
        }

        $records = $DB->get_records('local_mail_message_refs', $conditions, '', $field);

        return self::get_many(array_keys($records));
    }

    /**
     * Gets the sender of the message.
     *
     * @return user
     */
    public function get_sender(): user {
        $userid = array_search(self::ROLE_FROM, $this->roles);

        return user::get($userid);
    }

    /**
     * Returns whether the given label is set for the message.
     *
     * @param label $label Label.
     * @return bool
     */
    public function has_label(label $label): bool {
        assert(isset($this->roles[$label->userid]));

        return isset($this->labelids[$label->userid][$label->id]);
    }

    /**
     * Returns whether the given user is a recipient of a message.
     *
     * @param user $user User.
     * @return bool
     */
    public function has_recipient(user $user): bool {
        $recipientroles = [self::ROLE_TO, self::ROLE_CC, self::ROLE_BCC];
        return isset($this->roles[$user->id]) && in_array($this->roles[$user->id], $recipientroles);
    }

    /**
     * Returns the role of a user.
     *
     * @param user $user User.
     * @return int message::ROLE_FROM, message::ROLE_TO, message::ROLE_CC or message::ROLE_BCC
     */
    public function role(user $user): int {
        assert(isset($this->roles[$user->id]));

        return $this->roles[$user->id];
    }

    /**
     * Sends the message.
     *
     * @param int $time Timestamp.
     */
    public function send(int $time): void {
        global $DB;

        assert($this->draft);
        assert(\core_text::strlen($this->subject) > 0);
        assert(count($this->roles) >= 2);

        $transaction = $DB->start_delegated_transaction();

        $DB->set_field('local_mail_messages', 'draft', 0, ['id' => $this->id]);
        $DB->set_field('local_mail_messages', 'time', $time, ['id' => $this->id]);
        $DB->set_field('local_mail_message_users', 'draft', 0, ['messageid' => $this->id]);
        $DB->set_field('local_mail_message_users', 'time', $time, ['messageid' => $this->id]);
        $DB->set_field('local_mail_message_labels', 'draft', 0, ['messageid' => $this->id]);
        $DB->set_field('local_mail_message_labels', 'time', $time, ['messageid' => $this->id]);

        $this->draft = false;
        $this->time = $time;

        // Set labels from first reference.
        foreach ($this->get_references() as $ref) {
            foreach ($this->get_recipients() as $user) {
                if (isset($ref->labelids[$user->id])) {
                    $this->set_labels($user, label::get_many($ref->labelids[$user->id]));
                }
            }
            break;
        }

        $transaction->allow_commit();

        self::cache()->set($this->id, $this);
    }

    /**
     * Set the delete status of the message.
     *
     * Drafts are always removed from the database.
     *
     * @param user $user User.
     * @param int $status New deleted status.
     */
    public function set_deleted(user $user, int $status): void {
        global $DB;

        assert(isset($this->roles[$user->id]));
        assert(in_array($status, [self::NOT_DELETED, self::DELETED, self::DELETED_FOREVER]));
        assert(!$this->draft || $this->roles[$user->id] == self::ROLE_FROM);

        $transaction = $DB->start_delegated_transaction();

        if ($this->draft && $status == self::DELETED_FOREVER) {
            $DB->delete_records('local_mail_messages', ['id' => $this->id]);
            $DB->delete_records('local_mail_message_refs', ['messageid' => $this->id]);
            $DB->delete_records('local_mail_message_users', ['messageid' => $this->id]);
            $DB->delete_records('local_mail_message_labels', ['messageid' => $this->id]);
        } else {
            $conditions = ['messageid' => $this->id, 'userid' => $user->id];
            $DB->set_field('local_mail_message_users', 'deleted', $status, $conditions);

            foreach ($this->labelids[$user->id] as $labelid) {
                $conditions = ['messageid' => $this->id, 'labelid' => $labelid];
                if ($status == self::DELETED_FOREVER) {
                    $DB->delete_records('local_mail_message_labels', $conditions);
                } else {
                    $DB->set_field('local_mail_message_labels', 'deleted', $status, $conditions);
                }
            }
        }

        $transaction->allow_commit();

        if ($this->draft && $status == self::DELETED_FOREVER) {
            // Delete files after the transaction, in case it is rolled back.
            $fs = get_file_storage();
            $context = \context_course::instance($this->courseid);
            $fs->delete_area_files($context->id, 'local_mail', 'message', $this->id);
        }

        $this->deleted[$user->id] = $status;
        if ($status == self::DELETED_FOREVER) {
            $this->labelids[$user->id] = [];
        }

        if ($this->draft && $status == self::DELETED_FOREVER) {
            self::cache()->delete($this->id);
        } else {
            self::cache()->set($this->id, $this);
        }
    }

    /**
     * Sets the labels for a user.
     *
     * @param user $user User.
     * @param label[] $labels Labels.
     */
    public function set_labels(user $user, array $labels): void {
        global $DB;

        assert(isset($this->roles[$user->id]));
        assert(!$this->draft || $this->roles[$user->id] == self::ROLE_FROM);
        assert($this->deleted[$user->id] != self::DELETED_FOREVER);
        foreach ($labels as $label) {
            assert($label->userid == $user->id);
        }

        $transaction = $DB->start_delegated_transaction();

        $labelids = array_column($labels, 'id');
        foreach ($this->labelids[$user->id] as $id) {
            if (!in_array($id, $labelids)) {
                $DB->delete_records('local_mail_message_labels', ['messageid' => $this->id, 'labelid' => $id]);
            }
        }

        foreach ($labels as $label) {
            if (!isset($this->labelids[$user->id][$label->id])) {
                $record = new \stdClass();
                $record->messageid = $this->id;
                $record->courseid = $this->courseid;
                $record->draft = $this->draft;
                $record->time = $this->time;
                $record->labelid = $label->id;
                $record->role = $this->roles[$label->userid];
                $record->unread = $this->unread[$label->userid];
                $record->starred = $this->starred[$label->userid];
                $record->deleted = $this->deleted[$label->userid];
                $DB->insert_record('local_mail_message_labels', $record);
            }
        }

        $transaction->allow_commit();

        $this->labelids[$user->id] = [];
        foreach ($labels as $label) {
            $this->labelids[$user->id][$label->id] = $label->id;
        }

        self::cache()->set($this->id, $this);
    }

    /**
     * Set the starred status of the message.
     *
     * @param user $user User.
     * @param bool $status New starred status.
     */
    public function set_starred(user $user, bool $status): void {
        global $DB;

        assert(isset($this->roles[$user->id]));
        assert(!$this->draft || $this->roles[$user->id] == self::ROLE_FROM);
        assert($this->deleted[$user->id] != self::DELETED_FOREVER);

        $transaction = $DB->start_delegated_transaction();

        $conditions = ['messageid' => $this->id, 'userid' => $user->id];
        $DB->set_field('local_mail_message_users', 'starred', $status, $conditions);

        foreach ($this->labelids[$user->id] as $labelid) {
            $conditions = ['messageid' => $this->id, 'labelid' => $labelid];
            $DB->set_field('local_mail_message_labels', 'starred', $status, $conditions);
        }

        $transaction->allow_commit();

        $this->starred[$user->id] = $status;

        self::cache()->set($this->id, $this);
    }

    /**
     * Sets the unread status of the message.
     *
     * @param user $user User.
     * @param bool $status New unread status.
     */
    public function set_unread(user $user, bool $status): void {
        global $DB;

        assert(isset($this->roles[$user->id]));
        assert(!$this->draft || $this->roles[$user->id] == self::ROLE_FROM);
        assert($this->deleted[$user->id] != self::DELETED_FOREVER);

        $transaction = $DB->start_delegated_transaction();

        $conditions = ['messageid' => $this->id, 'userid' => $user->id];
        $DB->set_field('local_mail_message_users', 'unread', $status, $conditions);

        foreach ($this->labelids[$user->id] as $labelid) {
            $conditions = ['messageid' => $this->id, 'labelid' => $labelid];
            $DB->set_field('local_mail_message_labels', 'unread', $status, $conditions);
        }

        $transaction->allow_commit();

        $this->unread[$user->id] = $status;

        self::cache()->set($this->id, $this);
    }

    /**
     * Returns the starred status of the message.
     *
     * @param user $user User.
     * @return bool
     */
    public function starred(user $user): bool {
        assert(isset($this->roles[$user->id]));

        return $this->starred[$user->id];
    }

    /**
     * Returns the unread status of the message.
     *
     * @param user $user User.
     * @return bool
     */
    public function unread(user $user): bool {
        assert(isset($this->roles[$user->id]));

        return $this->unread[$user->id];
    }

    /**
     * Updates the message.
     *
     * @param message_data $data Message data.
     */
    public function update(message_data $data): void {
        global $DB;

        assert($this->draft);

        $transaction = $DB->start_delegated_transaction();

        $fs = get_file_storage();

        $oldcontext = $this->get_course()->get_context();
        $newcontext = $data->course->get_context();

        // Course.
        $this->courseid = $data->course->id;

        // Subject.
        $this->subject = trim($data->subject);
        if (\core_text::strlen($this->subject) > 100) {
            $this->subject = \core_text::substr($this->subject, 0, 97) . '...';
        }

        // Content and attachments.
        $this->content = file_save_draft_area_files(
            $data->draftitemid,
            $newcontext->id,
            'local_mail',
            'message',
            $this->id,
            message_data::file_options(),
            $data->content
        );
        $this->format = $data->format;
        $this->attachments = count($fs->get_area_files($newcontext->id, 'local_mail', 'message', $this->id, '', false));

        // Time.
        $this->time = (int) $data->time;

        // Message record.
        $messagerecord = new \stdClass();
        $messagerecord->id = $this->id;
        $messagerecord->courseid = $this->courseid;
        $messagerecord->subject = $this->subject;
        $messagerecord->content = $this->content;
        $messagerecord->format = $this->format;
        $messagerecord->attachments = $this->attachments;
        $messagerecord->time = $this->time;
        $messagerecord->normalizedsubject = self::normalize_text($this->subject, FORMAT_PLAIN);
        $messagerecord->normalizedcontent = self::normalize_text($this->content, $data->format);
        $DB->update_record('local_mail_messages', $messagerecord);

        // User records.
        foreach (array_keys($this->roles) as $userid) {
            $this->deleted[$userid] = self::NOT_DELETED;
        }
        $sql = 'UPDATE {local_mail_message_users}'
            . ' SET courseid = :courseid, deleted = :deleted, time = :time'
            . ' WHERE messageid = :messageid';
        $params = [
            'messageid' => $this->id,
            'courseid' => $this->courseid,
            'deleted' => self::NOT_DELETED,
            'time' => $this->time,
        ];
        $DB->execute($sql, $params);

        // Label records.
        $sql = 'UPDATE {local_mail_message_labels}'
            . ' SET courseid = :courseid, deleted = :deleted, time = :time'
            . ' WHERE messageid = :messageid';
        $params = [
            'messageid' => $this->id,
            'courseid' => $this->courseid,
            'deleted' => self::NOT_DELETED,
            'time' => $this->time,
        ];
        $DB->execute($sql, $params);

        // Added and modified recipients.
        $ignored = [$this->get_sender()->id => true];
        foreach (['to', 'cc', 'bcc'] as $rolename) {
            $role = $rolename == 'to' ? self::ROLE_TO : ($rolename == 'cc' ? self::ROLE_CC : self::ROLE_BCC);

            foreach ($data->$rolename as $user) {
                if (!empty($ignored[$user->id])) {
                    // Ignore duplicated user.
                    continue;
                }

                $ignored[$user->id] = true;

                if (!isset($this->roles[$user->id])) {
                    $this->roles[$user->id] = $role;
                    $this->unread[$user->id] = true;
                    $this->starred[$user->id] = false;
                    $this->deleted[$user->id] = self::NOT_DELETED;
                    $this->labelids[$user->id] = [];

                    $userrecord = new \stdClass();
                    $userrecord->messageid = $this->id;
                    $userrecord->courseid = $this->courseid;
                    $userrecord->draft = 1;
                    $userrecord->time = $this->time;
                    $userrecord->userid = $user->id;
                    $userrecord->role = $role;
                    $userrecord->unread = 1;
                    $userrecord->starred = 0;
                    $userrecord->deleted = self::NOT_DELETED;
                    $DB->insert_record('local_mail_message_users', $userrecord);
                } else if ($role != $this->roles[$user->id]) {
                    $this->roles[$user->id] = $role;

                    $sql = 'UPDATE {local_mail_message_users}'
                        . ' SET role = :role'
                        . ' WHERE messageid = :messageid AND userid = :userid';
                    $params = [
                        'messageid' => $this->id,
                        'userid' => $user->id,
                        'role' => $role,
                    ];
                    $DB->execute($sql, $params);
                }
            }
        }

        // Removed recipients.
        foreach (array_keys($this->roles) as $userid) {
            if ($this->roles[$userid] != self::ROLE_FROM && empty($ignored[$userid])) {
                unset($this->roles[$userid]);
                unset($this->unread[$userid]);
                unset($this->starred[$userid]);
                unset($this->deleted[$userid]);
                unset($this->labelids[$userid]);
                $DB->delete_records('local_mail_message_users', ['messageid' => $this->id, 'userid' => $userid]);
            }
        }

        // Delete old files.
        if ($newcontext->id != $oldcontext->id) {
            $fs->delete_area_files($oldcontext->id, 'local_mail', 'message', $this->id);
        }

        $transaction->allow_commit();

        self::cache()->set($this->id, $this);
    }
}
