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
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require(dirname(__FILE__) . '/settings/definitions.php');

if ($ADMIN->fulltree) {
    // Theme settings page.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingboosted', get_string('configtitle', 'theme_boosted'));

    include(dirname(__FILE__) . '/settings/general.php');
    include(dirname(__FILE__) . '/settings/colors.php');
    include(dirname(__FILE__) . '/settings/fonts.php');
    include(dirname(__FILE__) . '/settings/header.php');
    include(dirname(__FILE__) . '/settings/footer.php');
    include(dirname(__FILE__) . '/settings/login.php');
    include(dirname(__FILE__) . '/settings/frontpage.php');
    include(dirname(__FILE__) . '/settings/advanced.php');
    include(dirname(__FILE__) . '/settings/styles.php');
    include(dirname(__FILE__) . '/settings/about.php');
}
