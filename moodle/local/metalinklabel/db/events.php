<?php
defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname'   => '\core\event\course_meta_link_created',
        'callback'    => 'local_metalinklabel_event_course_meta_link_created::handle',
        'includefile' => '/local/metalinklabel/classes/event/course_meta_link_created.php',
        'internal'    => false,
    ],
];