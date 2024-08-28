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
 * Theme functions.
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_boosted_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;

    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boosted/scss/preset/default.scss');

    } else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boosted/scss/preset/plain.scss');

    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boosted/scss/preset/default.scss');
    }

    // Load boosted.scss.
    $scss .= file_get_contents($CFG->dirroot . '/theme/boosted/scss/boosted.scss');

    // Load post.scss.
    $scss .= file_get_contents($CFG->dirroot . '/theme/boosted/scss/boosted/post.scss');

    return $scss;
}


/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return array
 */
function theme_boosted_get_pre_scss($theme) {
    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
        'brandcolor' => ['brandcolor'],
        'pagebgcolor' => ['pagebgcolor'],

        'contentwidth'  => ['contentwidth'],
        'fontmain'      => ['fontmain'],
        'fontsize'      => ['fontsize'],
        'fontmaincolor' => ['fontmaincolor'],

        'fontheader'       => ['fontheader'],
        'fontheadercolor'  => ['fontheadercolor'],

        'headerbgcolor'   => ['headerbgcolor'],
        'headertextcolor' => ['headertextcolor'],

        'footerbgcolor'   => ['footerbgcolor'],
        'footertextcolor' => ['footertextcolor'],

        'selectiontext'   => ['selectiontext'],
        'selectionbg'     => ['selectionbg'],
        'focusborder'     => ['focusborder'],
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_boosted_get_extra_scss($theme) {
    global $CFG, $PAGE;
    $content = '';

    // Sets the background image, and its settings.
    $backgroundimageurl = $theme->setting_file_url('backgroundimage', 'backgroundimage');
    if (!empty($backgroundimageurl)) {
        $content .= '@media(min-width: 768px) {body {background-image: url('.$backgroundimageurl.'); background-size: cover;}}';
    }

    // Sets the login background image.
    $loginbackgroundimageurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
    if (!empty($loginbackgroundimageurl)) {
        $content .= '@media(min-width: 768px) {body.pagelayout-login #page {
                                                background-image: url('.$loginbackgroundimageurl.');
                                                background-repeat: no-repeat;
                                                background-size: cover;
                                                background-position: center center;}';

        $content .= '#region-main-box {background-color: transparent;}';
        $content .= '}';
    }

    // Sets the banner image.
    $bannerimageurl = $theme->setting_file_url('bannerimage', 'bannerimage');
    if (!empty($bannerimageurl)) {
        $content .= '#top-banner { ';
        $content .= 'background-image: url('.$bannerimageurl. ');
                     background-repeat: no-repeat;
                     background-size: cover;
                     background-position: center center;
                    ';
        $content .= '}';
    }

    // Load main font.
    $customfontmain = $CFG->wwwroot . '/theme/boosted/fonts/' . $theme->settings->customfontmain;
    if (!empty($customfontmain)) {
        $content .= '/* CustomMainFont */'.
        '@font-face {font-family: CustomMainFont;
                     font-display: swap;
                     font-style: normal;
                     font-weight: 400;
                     src: url('.$customfontmain.') format("woff2");}';

        $content .= 'body {font-family: CustomMainFont, sans-serif;}';
    }

    // Load headings font.
    $customfontheaderurl = $CFG->wwwroot . '/theme/boosted/fonts/' . $theme->settings->customfontheader;
    if (!empty($customfontheaderurl)) {
        $content .= '/* CustomHeadingFont */'.
        $content .= '@font-face {font-family: CustomHeadingFont;
                                 font-display: swap;
                                 font-style: normal;
                                 font-weight: 700;
                                 src: url('.$customfontheaderurl.') format("woff2");}';
        $content .= 'h1, h2, h3, h4, h5, h6 {font-family: CustomHeadingFont, sans-serif;}';
    }

    if (!empty($theme->settings->scss)) {
        $content .= $theme->settings->scss;
    }

    return $content;
}

/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_boosted_get_precompiled_css() {
    global $CFG;
    return file_get_contents($CFG->wwwroot . '/theme/boost/style/moodle.css');
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_boosted_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === 'logo') ||
                                                     ($filearea === 'favicon') ||
                                                     ($filearea === 'backgroundimage') ||
                                                     ($filearea === 'loginbackgroundimage') ||
                                                     ($filearea === 'bannerimage') ||
                                                     ($filearea === 'customfontmain') ||
                                                     ($filearea === 'customfontheader')) {
        $theme = theme_config::load('boosted');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}
