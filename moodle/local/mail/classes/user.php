<?php
/*
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 * SPDX-FileCopyrightText: 2024 Albert Gasset <albertgasset@fsfe.org>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

namespace local_mail;

class user {
    /** @var int User ID. */
    public int $id;

    /** @var string First name. */
    public string $firstname;

    /** @var string Last name. */
    public string $lastname;

    /** @var string Email address. */
    public string $email;

    /** @var int Picture file ID. */
    public int $picture;

    /** @var ?string Picture description. */
    public ?string $imagealt;

    /** @var string Phonetic spelling of first name. */
    public string $firstnamephonetic;

    /** @var string Phonetic spelling of last name. */
    public string $lastnamephonetic;

    /** @var string Middle name. */
    public string $middlename;

    /** @var string Alternate name. */
    public string $alternatename;

    /**
     * Constructs a user instance from a database record.
     *
     * @param \stdClass $record Database record from table user.
     */
    public function __construct(\stdClass $record) {
        $this->id = (int) $record->id;
        $this->firstname = $record->firstname;
        $this->lastname = $record->lastname;
        $this->email = $record->email;
        $this->picture = (int) $record->picture;
        $this->imagealt = $record->imagealt ?? '';
        $this->firstnamephonetic = $record->firstnamephonetic ?? '';
        $this->lastnamephonetic = $record->lastnamephonetic ?? '';
        $this->middlename = $record->middlename ?? '';
        $this->alternatename = $record->alternatename ?? '';
    }

    /**
     * Cache of users, indexed by ID.
     *
     * @return \cache
     */
    public static function cache(): \cache {
        return \cache::make('local_mail', 'users');
    }

    /**
     * Returns the current logged in user.
     *
     * @return ?self The current or null if not logged in or is guest.
     */
    public static function current(): ?self {
        global $USER;

        if (!isloggedin() || isguestuser() || \core_user::awaiting_action()) {
            return null;
        }

        $user = new self($USER);
        self::cache()->set($user->id, $user);

        return $user;
    }

    /**
     * Gets a user from the database.
     *
     * @param int $strictness MUST_EXIST or IGNORE_MISSING.
     * @param int $id ID of the user to get.
     * @return ?self
     */
    public static function get(int $id, int $strictness = MUST_EXIST): ?self {
        $users = self::get_many([$id], $strictness);

        return $users[$id] ?? null;
    }

    /**
     * Gets multiple users from the database.
     *
     * @param int[] $ids IDs of the users to get.
     * @param int $strictness MUST_EXIST or IGNORE_MISSING.
     * @return self[] Array of users indexed by ID.
     */
    public static function get_many(array $ids, int $strictness = MUST_EXIST): array {
        global $CFG, $DB;

        $users = self::cache()->get_many($ids);
        $missingids = array_filter($ids, fn($id) => !$users[$id]);

        if ($missingids) {
            [$sqlid, $params] = $DB->get_in_or_equal($missingids, SQL_PARAMS_NAMED, 'userid');
            $select = "id $sqlid AND id <> :guestid";
            $params['guestid'] = $CFG->siteguest;
            $fields = implode(',', \core_user\fields::get_picture_fields());
            $records = $DB->get_records_select('user', $select, $params, '', $fields);
            foreach ($missingids as $id) {
                if (isset($records[$id])) {
                    $users[$id] = new self($records[$id]);
                    self::cache()->set($id, $users[$id]);
                } else if ($strictness == MUST_EXIST) {
                    throw new exception('errorusernotfound', $id);
                }
            }
        }

        return array_filter($users);
    }

    /**
     * Returns whether the user can edit the message.
     *
     * @param message $message Message.
     * @return bool
     */
    public function can_edit_message(message $message): bool {
        return $message->draft &&
            $this->id == $message->get_sender()->id &&
            $message->deleted($this) != message::DELETED_FOREVER &&
            $this->can_use_mail($message->get_course());
    }

    /**
     * Returns whether the user can use mail in a course.
     *
     * @param course $course Course.
     * @return bool
     */
    public function can_use_mail(course $course) {
        return is_enrolled($course->get_context(), $this->id, 'local/mail:usemail', true) &&
            ($course->visible || has_capability('moodle/course:viewhiddencourses', $course->get_context(), $this->id, false));
    }

    /**
     * Returns whether the user can view the attachments of a message.
     *
     * @param message $message Message.
     * @return bool
     */
    public function can_view_files(message $message): bool {
        if ($this->can_view_message($message)) {
            return true;
        }
        foreach ($message->get_references(true) as $reference) {
            if ($this->can_view_message($reference)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns whether the user can view a group.
     *
     * @param course $course Course.
     * @param int $groupid ID of the group or 0 for all groups.
     * @return bool
     */
    public function can_view_group(course $course, int $groupid): bool {
        if (!$this->can_use_mail($course)) {
            return false;
        } else if ($course->groupmode == NOGROUPS) {
            return $groupid == 0;
        } else {
            return array_key_exists($groupid, $course->get_viewable_groups($this));
        }
    }

    /**
     * Returns whether the user can a message.
     *
     * @param message $message Message.
     * @return bool
     */
    public function can_view_message(message $message): bool {
        return ($message->get_sender()->id == $this->id || !$message->draft && $message->has_recipient($this)) &&
            $message->deleted($this) != message::DELETED_FOREVER &&
            $this->can_use_mail($message->get_course());
    }

    /**
     * Full name of the user.
     *
     * @return string
     */
    public function fullname(): string {
        return fullname((object) (array) $this);
    }

    /**
     * URL of the picture of the user.
     *
     * @return string
     */
    public function picture_url(): ?string {
        global $PAGE;
        $userpicture = new \user_picture((object) (array) $this);
        $url = $userpicture->get_url($PAGE)->out(false);
        $defaulturl = $PAGE->get_renderer('core')->image_url('u/f2')->out(false);
        return $url == $defaulturl ? '' : $url;
    }

    /**
     * URL of the profile of the user in a course.
     *
     * @param course $course Course.
     * @return string
     */
    public function profile_url(course $course): string {
        $params = ['id' => $this->id];
        if ($course) {
            $params['course'] = $course->id;
        }
        $url = new \moodle_url('/user/view.php', $params);
        return $url->out(false);
    }

    /**
     * Sort order of the user.
     *
     * @return string
     */
    public function sortorder(): string {
        return sprintf("%s\n%s\n%010d", $this->lastname, $this->firstname, $this->id);
    }
}
