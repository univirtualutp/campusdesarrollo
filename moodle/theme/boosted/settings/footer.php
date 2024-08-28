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
 * Footer settings
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die;

    // Colors section.
    $page = new admin_settingpage('theme_boosted_footer', get_string('footersettings', 'theme_boosted'));

    $page->add(new admin_setting_heading('theme_boosted_footer', get_string('footersettings', 'theme_boosted'),
                   format_text(get_string('footerdesc', 'theme_boosted'), FORMAT_MARKDOWN)));

    $name = 'theme_boosted/footerbgcolor';
    $title = get_string('footerbgcolor', 'theme_boosted');
    $description = get_string('footerbgcolordesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#424242', $previewconfig);
    $page->add($setting);

    $name = 'theme_boosted/footertextcolor';
    $title = get_string('footertextcolor', 'theme_boosted');
    $description = get_string('footertextcolordesc', 'theme_boosted');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#fff', $previewconfig);
    $page->add($setting);

    // Footnote.
    $name = 'theme_boosted/footnote';
    $title = get_string('footnote', 'theme_boosted');
    $description = get_string('footnotedesc', 'theme_boosted');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $page->add($setting);


    // Social Icons.
    $page->add(new admin_setting_heading('theme_boosted_footer', get_string('footersettings', 'theme_boosted'),
                   format_text(get_string('footerdesc', 'theme_boosted'), FORMAT_MARKDOWN)));

    // Social icons list.
    $name = 'theme_boosted/socialiconslist';
    $title = get_string('socialiconslist', 'theme_boosted');
    $default = '';
    $description = get_string('socialiconslistdesc', 'theme_boosted');
    $setting = new admin_setting_configtextarea($name, $title, $description, '', PARAM_RAW, '50', '10');
    $page->add($setting);

    // Blocks.
    $page->add(new admin_setting_heading('theme_boosted_footerblocks',
                                          get_string('footerblocks',
                                          'theme_boosted'),
                                          format_text(get_string('footerblocksdesc', 'theme_boosted'),
                                          FORMAT_MARKDOWN)));

    // Block layout (number of blocks to show, 4 by default).
    $name = 'theme_boosted/footerlayout';
    $title = get_string('footerlayout', 'theme_boosted');
    $description = get_string('footerlayoutdesc', 'theme_boosted');
    $setting = new admin_setting_configselect($name, $title, $description, 4, $from1to4);
    $page->add($setting);

    // Block content.
    for ($i = 1; $i <= get_config('theme_boosted', 'footerlayout'); $i++) {
        $name = 'theme_boosted/footerblocktitle'.$i;
        $title = get_string('footerheader', 'theme_boosted') . ' ' . $i;
        $description = get_string('footerdesc', 'theme_boosted') . ' ' . $i;
        $setting = new admin_setting_configtext($name, $title, $description, '');
        $page->add($setting);

        $name = 'theme_boosted/footerblockcontent'.$i;
        $title = get_string('footercontent', 'theme_boosted') . ' ' . $i;
        $description = get_string('footercontentdesc', 'theme_boosted') . ' ' .$i;
        $setting = new admin_setting_confightmleditor($name, $title, $description, '');
        $page->add($setting);
    }

    // End settings.
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($page);
