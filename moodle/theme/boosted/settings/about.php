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

// About heading.
$page = new admin_settingpage('theme_boosted_about', get_string('aboutsettings', 'theme_boosted'));


// About text.
    $output = '<h5><b>Moodle version: </b>'.$CFG->release.'</h5>'.
              '<h5><b>'.get_string('pluginname', 'theme_boosted').
              ' version:</b> 1.3.0 (Build: '.get_config('theme_boosted', 'version').
              ')</h5>';

    $output .= '<br><br>';

    $output .= get_string('choosereadme', 'theme_boosted');

    $output .= '<br><br>';

    $output .= get_string('support', 'theme_boosted');
    $output .= get_string('information', 'theme_boosted');

    $output .= '<br><h4>Licenses</h4>';

    $output .= '<p><b>Boosted is licensed under:</b><br>
                GPL v3 (GNU General Public License) - <a href="https://www.gnu.org/licenses" target="_blank">
                https://www.gnu.org/licenses</a></p>';

    $output .= '<p><b>The Google Fonts included are licensed under:</b><br>
                SIL Open Font License v1.1 - <a href="https://scripts.sil.org/OFL" target="_blank">
                https://scripts.sil.org/OFL</a><br></p>';

    $output .= '<br><p><span style="font-weight: bolder;">Boosted<br>&copy;2022-'.date("Y").' koditik</p>';
    $output .= '<p><span style="font-weight: bolder;">
                Boosted and Koditik</span> are not affiliated with or endorsed by Moodle.</p>';
    $output .= '<div class="boostedbanner">'.get_string('demo', 'theme_boosted').'<br><br>
                <a href="https://koditik.com/demo/moodle" target="_blank" style="color: #fff;">
                https://koditik.com/demo/moodle
                </a></div>';

    $page->add(new admin_setting_heading('theme_boosted_about',
                                         get_string('about', 'theme_boosted'),
                                         format_text($output, FORMAT_MARKDOWN)));

    $settings->add($page);
