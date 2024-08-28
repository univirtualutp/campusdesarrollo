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

$page = new admin_settingpage('theme_boosted_general', get_string('generalsettings', 'theme_boosted'));

    // Unaddable blocks.
    // Blocks to be excluded when this theme is enabled in the "Add a block" list: Administration, Navigation, Courses and
    // Section links.
    $default = 'navigation,settings,course_list,section_links';
    $setting = new admin_setting_configtext('theme_boosted/unaddableblocks',
        get_string('unaddableblocks', 'theme_boosted'), get_string('unaddableblocks_desc', 'theme_boosted'), $default, PARAM_TEXT);
    $page->add($setting);

    // Presets selection (fallback to default.scss).
    $name = 'theme_boosted/preset';
    $title = get_string('preset', 'theme_boosted');
    $description = get_string('preset_desc', 'theme_boosted');
    $default = 'default.scss';
    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_boosted', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configthemepreset($name, $title, $description, $default, $choices, 'boosted');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Favicon.
    $name = 'theme_boosted/favicon';
    $title = get_string('favicon', 'theme_boosted');
    $description = get_string('favicondesc', 'theme_boosted');
    $setting = new admin_setting_configstoredfile($name, $title, $description,
                                                    'favicon',
                                                    0,
                                                    array(
                                                        'maxfiles' => 1,
                                                        'accepted_types' => array('.png')));
    $page->add($setting);

    // Background image setting.
    $name = 'theme_boosted/backgroundimage';
    $title = get_string('backgroundimage', 'theme_boosted');
    $description = get_string('backgroundimage_desc', 'theme_boosted');
    $setting = new admin_setting_configstoredfile($name, $title, $description,
                                                 'backgroundimage',
                                                 0,
                                                 array('maxfiles' => 1,
                                                       'accepted_types' => array('.png, .jpg, .gif')));
    $page->add($setting);

    // Content page width.
    $name = 'theme_boosted/contentwidth';
    $title = get_string('contentwidth', 'theme_boosted');
    $description = get_string('contentwidthdesc', 'theme_boosted');
    $default = '80%';
    $choices = $from50to100percent;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // End settings.
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($page);
