<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Handles displaying the rumbletalk group chat block.
 *
 * @package    block_rumbletalk_chat
 * @copyright  2021 RumbleTalk, LTD {@link https://www.rumbletalk.com/}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$services = array(
      'mypluginservice' => array(
          'functions' => array ('create_account'),
          'requiredcapability' => '',
          'restrictedusers' => 0,
          'enabled' => 1,
          'shortname' => 'create_account'
       )
  );

$functions = array(
    'create_account_function' => array(
        'classname' => 'create_account_external',
        'methodname' => 'account_create',
        'classpath' => 'blocks/rumbletalk_chat/externallib.php',
        'description' => 'Create a new account in RumbleTalk',
        'type' => 'write',
        'ajax' => true,
        'loginrequired' => false
    )
);