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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package   theme_boosted
 * @copyright 2022-2023 koditik.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace theme_boosted\output;

use moodle_url;
use moodle_page;
use html_writer;
use get_string;
use pix_icon;
use context_course;
use core_text;
use stdClass;
use action_menu;
use context_system;
use theme_config;

/**
 *
 * @package    theme_boosted
 * @copyright  2022 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \core_renderer {

    /**
     * Returns html to render socialicons in footer
     *
     * @return string
     */
    public function social_icons($list) {
        if (empty($list)) {
            return '';
        }

        $retval = '';
        $retval = '<div class="socialbox">';

        $lines = explode("\n", $list);

        foreach ($lines as $line) {
            if (strstr($line, '|')) {
                $fields = explode('|', $line);
                $val  = '<a target="_blank" title="' . $fields[1] . '" href="' . $fields[0] . '">';
                $val .= '<i class="fa fa-3x fa-fw ' . $fields[2] . '"></i>';
                $val .= '</a>';

                $retval .= $val;
            }
        }

        $retval .= '</div>';
        return $retval;
    }


    /**
     * See if this is the first view of the current cm in the session if it has fake blocks.
     *
     * (We track up to 100 cms so as not to overflow the session.)
     * This is done for drawer regions containing fake blocks so we can show blocks automatically.
     *
     * @return boolean true if the page has fakeblocks and this is the first visit.
     */
    public function firstview_fakeblocks(): bool {
        global $SESSION;

        $firstview = false;
        if ($this->page->cm) {
            if (!$this->page->blocks->region_has_fakeblocks('side-pre')) {
                return false;
            }
            if (!property_exists($SESSION, 'firstview_fakeblocks')) {
                $SESSION->firstview_fakeblocks = [];
            }
            if (array_key_exists($this->page->cm->id, $SESSION->firstview_fakeblocks)) {
                $firstview = false;
            } else {
                $SESSION->firstview_fakeblocks[$this->page->cm->id] = true;
                $firstview = true;
                if (count($SESSION->firstview_fakeblocks) > 100) {
                    array_shift($SESSION->firstview_fakeblocks);
                }
            }
        }
        return $firstview;
    }

    /**
     * Returns the url of the custom favicon.
     */
    public function favicon() {
        global $CFG;

        $favicon = $this->page->theme->setting_file_url('favicon', 'favicon');

        if (!empty($favicon)) {
            return $favicon;
        } else {
            return $CFG->wwwroot . '/theme/boosted/pix/favicon.png';
        }
    }


    /**
     * Device detection.
     */
    public function is_mobile() {
        $ismobile = false;
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        } else if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false // Many mobile devices (all iPhone, iPad, etc.).
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Silk/' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Kindle' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false
            || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' ) !== false ) {
                $ismobile = true;
        }
        return $ismobile;
    }

    // End.
}
