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
 * Styles sample page
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die;

// Styles heading.
$page = new admin_settingpage('theme_boosted_styles', get_string('stylessettings', 'theme_boosted'));
$page->add(new admin_setting_heading('theme_boosted_styles', get_string('stylessettings', 'theme_boosted'),
                                     format_text(get_string('stylesdesc', 'theme_boosted'), FORMAT_MARKDOWN)));




// Headings.
$output = '<h3 class="mt-5">Text</h3>';
$output .= '<div class="row mt-1 mb-1 w-50 setting-headings">';
$output .= '  <h1>heading h1</h1>';
$output .= '  <h2>heading h2</h2>';
$output .= '  <h3>heading h3</h3>';
$output .= '  <h4>heading h4</h4>';
$output .= '  <h5>heading h5</h5>';
$output .= '  <h6>heading h6</h6>';
$output .= '</div>';
$output .= '<p class="w-50" style="margin-left: 1rem;">Rings of Uranus Apollonius of Perga birth galaxies tesseract culture.
 Not a sunrise but a galaxyrise gathered by gravity concept of the number one the sky calls to us descended from astronomers
 with pretty stories for which there is little good evidence? Stirred by starlight intelligent beings muse about paroxysm of
 global death muse about stirred by starlight. A very small stage in a vast cosmic arena how far away network of wormholes
 network of wormholes dispassionate extraterrestrial observer intelligent beings and billions upon billions upon billions
 upon billions upon billions upon billions upon billions.</p>';
$output .= '<br>';

// Buttons.
$output .= '<h3 class="mt-5">Buttons</h3>';
$output .= '<div class="row mt-5 w-50 setting-buttons">';
$output .= '  <div class="col"><a class="btn btn-primary">Primary</a></div>';
$output .= '  <div class="col"><a class="btn btn-secondary">Secondary</a></div>';
$output .= '  <div class="col"><a class="btn btn-success">Success</a></div>';
$output .= '  <div class="col"><a class="btn btn-danger">Danger</a></div>';
$output .= '  <div class="col"><a class="btn btn-warning">Warning</a></div>';
$output .= '</div>';

$output .= '<div class="row mt-1 mb-1 w-50 setting-buttons">';
$output .= '  <div class="col"><a class="btn btn-info">Info</a></div>';
$output .= '  <div class="col"><a class="btn btn-light">Light</a></div>';
$output .= '  <div class="col"><a class="btn btn-dark">Dark</a></div>';
$output .= '  <div class="col"><a class="btn btn-link">Link</a></div>';
$output .= '  <div class="col"><a class="btn">Default</a></div>';
$output .= '</div>';
$output .= '<br>';

// Text colors.
$output .= '<h3 class="mt-5">Colors</h3>';
$output .= '<div class="row mt-1 mb-1 w-50 setting-colors">';
$output .= '  <div class="col-md-4"><p class="text-primary">text-primary</p></div>';
$output .= '  <div class="col-md-4"><p class="text-secondary">text-secondary</p></div>';
$output .= '  <div class="col-md-4"><p class="text-success">text-success</p></div>';
$output .= '  <div class="col-md-4"><p class="text-danger">text-danger</p></div>';
$output .= '  <div class="col-md-4"><p class="text-warning">text-warning</p></div>';
$output .= '  <div class="col-md-4"><p class="text-info">text-info</p></div>';
$output .= '  <div class="col-md-4"><p class="bg-dark text-light">text-light</p></div>';
$output .= '  <div class="col-md-4"><p class="text-dark">text-dark</p></div>';
$output .= '  <div class="col-md-4"><p class="bg-dark text-white">text-white</p></div>';
$output .= '</div>';
$output .= '<br>';

// Background colors.
$output .= '<h3 class="mt-5">Background colors</h3>';
$output .= '<div class="row mt-1 mb-1 w-50 setting-background">';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-primary text-white">background primary</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-secondary text-white">background secondary</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-success text-white">background success</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-danger text-white">background danger</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-warning text-dark">background warning</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-info text-white">background info</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-light text-dark">background light</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-dark text-white">background dark</div></div>';
$output .= '  <div class="col-md-4"><div class="p-3 mb-2 bg-white text-dark">background white</div></div>';
$output .= '</div>';
$output .= '<br>';
$output .= '<br>';

$page->add(new admin_setting_heading('theme_boosted_styles',
                                        get_string('styles', 'theme_boosted'),
                                        format_text($output, FORMAT_MARKDOWN)));
$settings->add($page);
