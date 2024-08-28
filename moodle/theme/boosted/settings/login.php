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
 * Version details
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die;

// Login page section.
$page = new admin_settingpage('theme_boosted_login', get_string('loginsettings', 'theme_boosted'));

$page->add(new admin_setting_heading(
    'theme_boosted_login',
    get_string('loginsettings', 'theme_boosted'),
    format_text(get_string('logindesc', 'theme_boosted'), FORMAT_MARKDOWN)
));



    // Login Background image setting.
    $name = 'theme_boosted/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_boosted');
    $description = get_string('loginbackgroundimage_desc', 'theme_boosted');
    $setting = new admin_setting_configstoredfile($name,
                                                  $title,
                                                  $description,
                                                  'loginbackgroundimage',
                                                  0,
                                                  array('maxfiles' => 1, 'accepted_types' => array('.png, .jpg, .gif')));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login Box alignment.
    $name = 'theme_boosted/loginboxalign';
    $title = get_string('loginboxalign', 'theme_boosted');
    $description = get_string('loginboxaligndesc', 'theme_boosted');
    $choices = $halignment;
    $setting = new admin_setting_configselect($name, $title, $description, 'center', $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // End settings.
    $settings->add($page);
