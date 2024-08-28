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
 * Boosted version file.
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// The theme name.
$plugin->component = 'theme_boosted';

// Boosted version date (YYYYMMDDrr where rr is the release number).
$plugin->version   = 2023100100;

// Moodle 4.0 required.
$plugin->requires  = 2022041200;

// Moodle versions supported (4.0 to 4.2).
$plugin->supported = [400, 430];

// Boosted version using SemVer (https://semver.org).
$plugin->release = '1.3.0';

// Boosted maturity.
$plugin->maturity = MATURITY_STABLE;

// Boosted dependency of Boost.
$plugin->dependencies = array('theme_boost' => 2022041200);
