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
    $page = new admin_settingpage('theme_boosted_colors', get_string('colorsettings', 'theme_boosted'));

    $page->add(new admin_setting_heading('theme_boosted_color', get_string('colorsettings', 'theme_boosted'),
                   format_text(get_string('colordesc', 'theme_boosted'), FORMAT_MARKDOWN)));

    // Main colors heading.
    $name = 'theme_boosted/settingsmaincolors';
    $heading = get_string('settingsmaincolors', 'theme_boosted');
    $setting = new admin_setting_heading($name, $heading, '');
    $page->add($setting);

    // Variable $body-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_boosted/brandcolor';
    $title = get_string('brandcolor', 'theme_boosted');
    $description = get_string('brandcolor_desc', 'theme_boosted');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#3a89e4');
    $page->add($setting);

    // Site background color.
    $name = 'theme_boosted/pagebgcolor';
    $title = get_string('pagebgcolor', 'theme_boosted');
    $description = get_string('pagebgcolordesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#89e43a', $previewconfig);
    $page->add($setting);


    // Accessibility.
    $name = 'theme_boosted/settingsaccesscolors';
    $heading = get_string('settingsaccesscolors', 'theme_boosted');
    $setting = new admin_setting_heading($name, $heading, '');
    $page->add($setting);

    // Focus border.
    $name = 'theme_boosted/focusborder';
    $title = get_string('focusborder', 'theme_boosted');
    $description = get_string('focusborderdesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#3a89e4', $previewconfig);
    $page->add($setting);

    // Selection text color.
    $name = 'theme_boosted/selectiontext';
    $title = get_string('selectiontext', 'theme_boosted');
    $description = get_string('selectiontextdesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#000', $previewconfig);
    $page->add($setting);

    // Selection background color.
    $name = 'theme_boosted/selectionbg';
    $title = get_string('selectionbg', 'theme_boosted');
    $description = get_string('selectionbgdesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#fff000', $previewconfig);
    $page->add($setting);


    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($page);
