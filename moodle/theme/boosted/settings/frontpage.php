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
 * Frontpage settings
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die;

// Colors section.
$page = new admin_settingpage('theme_boosted_frontpage', get_string('frontpagesettings', 'theme_boosted'));

$page->add(new admin_setting_heading(
    'theme_boosted_frontpage',
    get_string('frontpagesettings', 'theme_boosted'),
    format_text(get_string('frontpagedesc', 'theme_boosted'), FORMAT_MARKDOWN)
));

// Banner Image.
$name = 'theme_boosted/bannerimage';
$title = get_string('bannerimage', 'theme_boosted');
$description = get_string('bannerimagedesc', 'theme_boosted');
$setting = new admin_setting_configstoredfile(
    $name,
    $title,
    $description,
    'bannerimage',
    0,
    array(
        'maxfiles' => 1,
        'accepted_types' => array('.png,.jpg,.gif')
    )
);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Banner Text.
$name = 'theme_boosted/bannertext';
$title = get_string('bannertext', 'theme_boosted');
$description = get_string('bannertextdesc', 'theme_boosted');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Banner CTA Button.
$name = 'theme_boosted/bannerbutton';
$title = get_string('bannerbutton', 'theme_boosted');
$description = get_string('bannerbuttondesc', 'theme_boosted');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Banner CTA Button link.
$name = 'theme_boosted/bannerbuttonlink';
$title = get_string('bannerbuttonlink', 'theme_boosted');
$description = get_string('bannerbuttonlinkdesc', 'theme_boosted');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Banner Text Alignment.
$name = 'theme_boosted/bannertextvalign';
$title = get_string('bannertextvalign', 'theme_boosted');
$description = get_string('bannertextvaligndesc', 'theme_boosted');
$setting = new admin_setting_configselect($name, $title, $description, 'bottom', $valignment);
$page->add($setting);

// Blocks.
$page->add(new admin_setting_heading('theme_boosted_infoblocks',
                                        get_string('infoblock',
                                        'theme_boosted'),
                                        format_text(get_string('infoblockdesc', 'theme_boosted'),
                                        FORMAT_MARKDOWN)
                                    ));

// Block layout (number of blocks to show, 4 by default).
$name = 'theme_boosted/infoblockslayout';
$title = get_string('infoblockslayout', 'theme_boosted');
$description = get_string('infoblockslayoutdesc', 'theme_boosted');
$setting = new admin_setting_configselect($name, $title, $description, 4, $from1to4);
$page->add($setting);


// Block content.
for ($i = 1; $i <= get_config('theme_boosted', 'infoblockslayout'); $i++) {
    $name = 'theme_boosted/infoblockcontent'.$i;
    $title = get_string('infoblockcontent', 'theme_boosted') . ' ' . $i;
    $description = get_string('infoblockcontentdesc', 'theme_boosted');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $page->add($setting);
}

// End settings.
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($page);
