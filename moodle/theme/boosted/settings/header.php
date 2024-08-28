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
 * Colors settings
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die;

    // Colors section.
    $page = new admin_settingpage('theme_boosted_header', get_string('headersettings', 'theme_boosted'));

    $page->add(new admin_setting_heading('theme_boosted_header', get_string('headersettings', 'theme_boosted'),
                   format_text(get_string('headerdesc', 'theme_boosted'), FORMAT_MARKDOWN)));

    // Header colors heading.
    $name = 'theme_boosted/settingsheadercolors';
    $heading = get_string('settingsheadercolors', 'theme_boosted');
    $setting = new admin_setting_heading($name, $heading, '');
    $page->add($setting);

    $name = 'theme_boosted/headerbgcolor';
    $title = get_string('headerbgcolor', 'theme_boosted');
    $description = get_string('headerbgcolordesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#fff', $previewconfig);
    $page->add($setting);

    $name = 'theme_boosted/headertextcolor';
    $title = get_string('headertextcolor', 'theme_boosted');
    $description = get_string('headertextcolordesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#333', $previewconfig);
    $page->add($setting);

    // End settings.
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($page);
