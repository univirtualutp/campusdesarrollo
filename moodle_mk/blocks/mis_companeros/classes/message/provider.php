<?php

namespace block_mis_companeros;

defined('MOODLE_INTERNAL') || die();

use core_message\message_provider;
use core_message\message;

class message_provider {

    public static function send_message($message_data) {
        global $DB;

        // Procesa el mensaje
        $message = new message();
        $message->component = $message_data->component;
        $message->name = $message_data->name;
        $message->userfrom = $message_data->userfrom;
        $message->userto = $message_data->userto;
        $message->subject = $message_data->subject;
        $message->fullmessage = $message_data->fullmessage;
        $message->fullmessageformat = $message_data->fullmessageformat;
        $message->fullmessagehtml = $message_data->fullmessagehtml;
        $message->smallmessage = $message_data->smallmessage;
        $message->notification = $message_data->notification;

        message_send($message);
    }
}
