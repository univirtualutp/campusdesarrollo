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
 * Definitions for settings
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die;

// Fonts Regular list.
$mfonts = array(
    'lato-v23-latin-regular.woff2' => 'Lato',
    'lexend-deca-v17-latin-regular.woff2' => 'Lexend Deca',
    'montserrat-v25-latin-regular.woff2' => 'Montserrat',
    'noto-sans-v27-latin-regular.woff2' => 'Noto Sans',
    'open-sans-v29-latin-regular.woff2' => 'Open Sans',
    'oswald-v49-latin-regular.woff2' => 'Oswald',
    'pt-sans-v17-latin-regular.woff2' => 'PT Sans',
    'poppins-v20-latin-regular.woff2' => 'Poppins',
    'raleway-v28-latin-regular.woff2' => 'Raleway',
    'roboto-v30-latin-regular.woff2' => 'Roboto',
    'source-sans-pro-v21-latin-regular.woff2' => 'Source Sans Pro'
);

// Fonts Bold list.
$hfonts = array(
    'lato-v23-latin-700.woff2' => 'Lato',
    'lexend-deca-v17-latin-700.woff2' => 'Lexend Deca',
    'montserrat-v25-latin-700.woff2' => 'Montserrat',
    'noto-sans-v27-latin-700.woff2' => 'Noto Sans',
    'open-sans-v29-latin-700.woff2' => 'Open Sans',
    'oswald-v49-latin-700.woff2' => 'Oswald',
    'pt-sans-v17-latin-700.woff2' => 'PT Sans',
    'poppins-v20-latin-700.woff2' => 'Poppins',
    'raleway-v28-latin-700.woff2' => 'Raleway',
    'roboto-v30-latin-700.woff2' => 'Roboto',
    'source-sans-pro-v21-latin-700.woff2' => 'Source Sans Pro'
);

// Fonts.
$standardfontsize = array(
    '0.5rem' => '0.5rem',
    '0.6rem' => '0.6rem',
    '0.7rem' => '0.7rem',
    '0.8rem' => '0.8rem',
    '0.9rem' => '0.9rem',
    '1rem'   => '1rem',
    '1.1rem' => '1.1rem',
    '1.2rem' => '1.2rem',
    '1.3rem' => '1.3rem',
    '1.4rem' => '1.4rem',
    '1.5rem' => '1.5rem',
);

$from100to900  = array();
for ($i = 100; $i < 901; $i += 100) {
    $from100to900[$i] = $i;
}

// Numbers.
$from1to4 = array();
for ($i = 1; $i < 5; $i++) {
    $from1to4[$i] = $i;
}

// Percentages.
$from50to100percent = array();
for ($i = 50; $i < 101; $i += 10) {
    $from50to100percent[$i . '%'] = $i . '%';
}

// Text Horizontal Alignment.
$halignment = array(
    'left'   => get_string('left', 'theme_boosted'),
    'center' => get_string('centre', 'theme_boosted'),
    'right'  => get_string('right', 'theme_boosted'),
);

// Text Vertical Alignment.
$valignment = array(
    'start'   => get_string('top', 'theme_boosted'),
    'center' => get_string('centre', 'theme_boosted'),
    'end'  => get_string('bottom', 'theme_boosted'),
);
