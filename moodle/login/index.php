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
 * Main login page.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once('lib.php');
require_once($CFG->dirroot.'/login/login_form.php'); // Incluye el archivo de definición del formulario


redirect_if_major_upgrade_required();

$testsession = optional_param('testsession', 0, PARAM_INT); // test session works properly
$anchor      = optional_param('anchor', '', PARAM_RAW);     // Used to restore hash anchor to wantsurl.

$resendconfirmemail = optional_param('resendconfirmemail', false, PARAM_BOOL);

// It might be safe to do this for non-Behat sites, or there might
// be a security risk. For now we only allow it on Behat sites.
// If you wants to do the analysis, you may be able to remove the
// if (BEHAT_SITE_RUNNING).
if (defined('BEHAT_SITE_RUNNING') && BEHAT_SITE_RUNNING) {
    $wantsurl    = optional_param('wantsurl', '', PARAM_LOCALURL);   // Overrides $SESSION->wantsurl if given.
    if ($wantsurl !== '') {
        $SESSION->wantsurl = (new moodle_url($wantsurl))->out(false);
    }
}

$context = context_system::instance();
$PAGE->set_url("$CFG->wwwroot/login/index.php");
$PAGE->set_context($context);
$PAGE->set_pagelayout('login');

// Incluyendo el archivo CSS personalizado
$PAGE->requires->css('/login/css/styles.css');

/// Initialize variables
$errormsg = '';
$errorcode = 0;

// login page requested session test
if ($testsession) {
    if ($testsession == $USER->id) {
        if (isset($SESSION->wantsurl)) {
            $urltogo = $SESSION->wantsurl;
        } else {
            $urltogo = $CFG->wwwroot.'/';
        }
        unset($SESSION->wantsurl);
        redirect($urltogo);
    } else {
        // TODO: try to find out what is the exact reason why sessions do not work
        $errormsg = get_string("cookiesnotenabled");
        $errorcode = 1;
    }
}

/// Check for timed out sessions
if (!empty($SESSION->has_timed_out)) {
    $session_has_timed_out = true;
    unset($SESSION->has_timed_out);
} else {
    $session_has_timed_out = false;
}

$frm  = false;
$user = false;

$authsequence = get_enabled_auth_plugins(); // Auths, in sequence.
foreach($authsequence as $authname) {
    $authplugin = get_auth_plugin($authname);
    // The auth plugin's loginpage_hook() can eventually set $frm and/or $user.
    $authplugin->loginpage_hook();
}


/// Define variables used in page
$site = get_site();

// Ignore any active pages in the navigation/settings.
// We do this because there won't be an active page there, and by ignoring the active pages the
// navigation and settings won't be initialised unless something else needs them.
$PAGE->navbar->ignore_active();
$loginsite = get_string("loginsite");
$PAGE->navbar->add($loginsite);

if ($user !== false or $frm !== false or $errormsg !== '') {
    // some auth plugin already supplied full user, fake form data or prevented user login with error message

} else if (!empty($SESSION->wantsurl) && file_exists($CFG->dirroot.'/login/weblinkauth.php')) {
    // Handles the case of another Moodle site linking into a page on this site
    //TODO: move weblink into own auth plugin
    include($CFG->dirroot.'/login/weblinkauth.php');
    if (function_exists('weblink_auth')) {
        $user = weblink_auth($SESSION->wantsurl);
    }
    if ($user) {
        $frm->username = $user->username;
    } else {
        $frm = data_submitted();
    }

} else {
    $frm = data_submitted();
}

// Restore the #anchor to the original wantsurl. Note that this
// will only work for internal auth plugins, SSO plugins such as
// SAML / CAS / OIDC will have to handle this correctly directly.
if ($anchor && isset($SESSION->wantsurl) && strpos($SESSION->wantsurl, '#') === false) {
    $wantsurl = new moodle_url($SESSION->wantsurl);
    $wantsurl->set_anchor(substr($anchor, 1));
    $SESSION->wantsurl = $wantsurl->out();
}

/// Check if the user has actually submitted login data to us

if ($frm and isset($frm->username)) {                             // Login WITH cookies

    $frm->username = trim(core_text::strtolower($frm->username));

    if (is_enabled_auth('none') ) {
        if ($frm->username !== core_user::clean_field($frm->username, 'username')) {
            $errormsg = get_string('username').': '.get_string("invalidusername");
            $errorcode = 2;
            $user = null;
        }
    }

    if ($user) {
        // The auth plugin has already provided the user via the loginpage_hook() called above.
    } else if (($frm->username == 'guest') and empty($CFG->guestloginbutton)) {
        $user = false;    /// Can't log in as guest if guest button is disabled
        $frm = false;
    } else {
        if (empty($errormsg)) {
            $logintoken = isset($frm->logintoken) ? $frm->logintoken : '';
            $user = authenticate_user_login($frm->username, $frm->password, false, $errorcode, $logintoken);
        }
    }

    // Intercept 'restored' users to provide them with info & reset password
    if (!$user and $frm and is_restored_user($frm->username)) {
        $PAGE->set_title(get_string('restoredaccount'));
        $PAGE->set_heading($site->fullname);
        echo $OUTPUT->header();
        echo $OUTPUT->heading(get_string('restoredaccount'));
        echo $OUTPUT->box(get_string('restoredaccountinfo'), 'generalbox boxaligncenter');
        require_once('restored_password_form.php'); // Use our "supplanter" login_forgot_password_form. MDL-20846
        $form = new login_forgot_password_form('forgot_password.php', array('username' => $frm->username));
        $form->display();
        echo $OUTPUT->footer();
        die;
    }

    if ($user) {

        // language setup
        if (isguestuser($user)) {
            // no predefined language for guests - use existing session or default site lang
            unset($user->lang);

        } else if (!empty($user->lang)) {
            // unset previous session language - use user preference instead
            unset($SESSION->lang);
        }

        if (empty($user->confirmed)) {       // This account was never confirmed
            $PAGE->set_title(get_string("mustconfirm"));
            $PAGE->set_heading($site->fullname);
            echo $OUTPUT->header();
            echo $OUTPUT->heading(get_string("mustconfirm"));
            if ($resendconfirmemail) {
                if (!send_confirmation_email($user)) {
                    echo $OUTPUT->notification(get_string('emailconfirmsentfailure'), \core\output\notification::NOTIFY_ERROR);
                } else {
                    echo $OUTPUT->notification(get_string('emailconfirmsentsuccess'), \core\output\notification::NOTIFY_SUCCESS);
                }
            }
            echo $OUTPUT->box(get_string("emailconfirmsent", "", s($user->email)), "generalbox boxaligncenter");
            $resendconfirmurl = new moodle_url('/login/index.php',
                [
                    'username' => $frm->username,
                    'password' => $frm->password,
                    'resendconfirmemail' => true,
                    'logintoken' => \core\session\manager::get_login_token()
                ]
            );
            echo $OUTPUT->single_button($resendconfirmurl, get_string('emailconfirmationresend'));
            echo $OUTPUT->footer();
            die;
        }

    /// Let's get them all set up.
        complete_user_login($user);

        \core\session\manager::apply_concurrent_login_limit($user->id, session_id());

        // sets the username cookie
        if (!empty($CFG->nolastloggedin)) {
            // do not store last logged in user in cookie
            // auth plugins can temporarily override this from loginpage_hook()
            // do not save $CFG->nolastloggedin = true in loginpage_hook()
            $frm->username = '';
        }
        set_moodle_cookie($frm->username);

        // Make sure the SESSION->wantsurl is not empty.
        if (empty($SESSION->wantsurl)) {
            $urltogo = $CFG->wwwroot.'/';
        } else {
            // Include sesskey in urltogo, so CSRF protection is not triggered.
            $urltogo = $SESSION->wantsurl;
            if (strpos($urltogo, '?') === false) {
                $urltogo .= '?';
            } else {
                $urltogo .= '&';
            }
            $urltogo .= 'sesskey='.sesskey();
        }
        unset($SESSION->wantsurl);

        // We cannot redirect to POST data.
        if (strpos($urltogo, 'login/change_password.php') === 0) {
            \core\session\manager::set_login_info($user);
            $PAGE->set_title(get_string('changepassword'));
            $PAGE->set_heading($site->fullname);
            echo $OUTPUT->header();
            echo $OUTPUT->footer();
            exit;
        }

        redirect($urltogo);
    } else {
        if (empty($errorcode)) {
            $errorcode = 2;
        }
        $errormsg = get_string("invalidlogin");
        $frm = false;
    }
}

/// Print the login page itself

if (empty($user) && empty($frm) && $session_has_timed_out) {
    $frm = new stdClass();
    $frm->username = get_moodle_cookie();
    $errormsg = get_string('sessionerroruser2', 'error');
}

$site = get_site();
$PAGE->set_title($loginsite);
$PAGE->set_heading($site->fullname);

echo $OUTPUT->header();
echo $OUTPUT->box_start('loginbox clearfix');

// Si hay un mensaje de error, lo mostramos.
if (!empty($errormsg)) {
    echo $OUTPUT->error_text($errormsg);
}

$loginform = new login_form(null, ['anchor' => $anchor]);

if (empty($frm->username)) {
    $frm->username = get_moodle_cookie();
}

$loginform->set_data($frm);
$loginform->display();

echo $OUTPUT->box_end();

// Añadir el bloque personalizado
echo $OUTPUT->box_start('custom-login-block');
echo html_writer::tag('h3', 'Información importante');
echo html_writer::start_tag('ol');
echo html_writer::tag('li', 'Item 1');
echo html_writer::tag('li', 'Item 2');
echo html_writer::tag('li', 'Item 3');
echo html_writer::tag('li', 'Item 4');
echo html_writer::end_tag('ol');
echo $OUTPUT->box_end();

echo $OUTPUT->footer();

