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
 * Fonts settings
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die;

$page = new admin_settingpage('theme_boosted_fonts', get_string('fontsettings', 'theme_boosted'));

    $page->add(new admin_setting_heading('theme_boosted_font', get_string('fontsettings', 'theme_boosted'),
                                          format_text(get_string('fontdesc', 'theme_boosted'), FORMAT_MARKDOWN)));

    // Main Font.
    $name = 'theme_boosted/settingsmainfont';
    $heading = get_string('settingsmainfont', 'theme_boosted');
    $setting = new admin_setting_heading($name, $heading, '');
    $page->add($setting);

    // Main font.
    $name = 'theme_boosted/customfontmain';
    $title = get_string('customfontmain', 'theme_boosted');
    $description = get_string('customfontmaindesc', 'theme_boosted');
    $setting = new admin_setting_configselect($name, $title, $description, 'lexend-deca-v17-latin-regular.woff2', $mfonts);
    $page->add($setting);

    // Main Font size.
    $name = 'theme_boosted/fontsize';
    $title = get_string('fontsize', 'theme_boosted');
    $description = get_string('fontsizedesc', 'theme_boosted');
    $setting = new admin_setting_configselect($name, $title, $description, '1rem', $standardfontsize);
    $page->add($setting);

    // Main Font color.
    $name = 'theme_boosted/fontmaincolor';
    $title = get_string('fontmaincolor', 'theme_boosted');
    $description = get_string('fontmaincolordesc', 'theme_boosted');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#333', null);
    $page->add($setting);

    // Headers Font.
    $name = 'theme_boosted/settingsheaderfont';
    $heading = get_string('settingsheaderfont', 'theme_boosted');
    $setting = new admin_setting_heading($name, $heading, '');
    $page->add($setting);

    // Header font.
    $name = 'theme_boosted/customfontheader';
    $title = get_string('customfontheader', 'theme_boosted');
    $description = get_string('customfontheaderdesc', 'theme_boosted');
    $setting = new admin_setting_configselect($name, $title, $description, 'montserrat-v25-latin-700.woff2', $hfonts);
    $page->add($setting);

    // Header font color.
    $name = 'theme_boosted/fontheadercolor';
    $title = get_string('fontheadercolor', 'theme_boosted');
    $description = get_string('fontheadercolordesc', 'theme_boosted');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#e43a89', null);
    $page->add($setting);

    // End settings.
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($page);
