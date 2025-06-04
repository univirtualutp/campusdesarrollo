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
 *
 * @package   theme_mb2mclmain
 * @copyright 2020 - 2022 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */


defined('MOODLE_INTERNAL') || die();


$temp = new admin_settingpage('theme_mb2mclmain_settingsfeatures',  get_string('settingsfeatures', 'theme_mb2mclmain'));
$yesNoOptions = array('1'=>get_string('yes','theme_mb2mclmain'), '0'=>get_string('no','theme_mb2mclmain'));

$bgPositionOpt = array(
	'center center'=>'center center',
	'left top'=>'left top',
	'left center'=>'left center',
	'left bottom'=>'left bottom',
	'right top'=>'right top',
	'right center'=>'right center',
	'right bottom'=>'right bottom',
	'center top'=>'center top',
	'center bottom'=>'center bottom'
);


$bgRepearOpt = array(
	'no-repeat'=>'no-repeat',
	'repeat'=>'repeat',
	'repeat-x'=>'repeat-x',
	'repeat-y'=>'repeat-y'
);


$bgSizeOpt = array(
	'cover'=>'cover',
	'auto'=>'auto',
	'contain'=>'contain'
);


$bgAttOpt = array(
	'scroll'=>'scroll',
	'fixed'=>'fixed',
	'local'=>'local'
);


$bgPredefinedOpt = array(
	''=>get_string('none','theme_mb2mclmain'),
	'default' => get_string('imgdefault','theme_mb2mclmain'),
	'strip1'=>get_string('strip1','theme_mb2mclmain'),
	'strip2'=>get_string('strip2','theme_mb2mclmain'),
);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startaccessibility', get_string('accessibility','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/fontsizer';
	$title = get_string('fontsizer','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endaccessibility');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startbookmarks', get_string('bookmarks','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/bookmarks';
	$title = get_string('bookmarks','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/bookmarkslimit';
	$title = get_string('bookmarkslimit','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, '', 15);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endbookmarks');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startcoursepanel', get_string('coursepanel','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/coursepanel';
	$title = get_string('coursepanel','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/roleshortname';
	$title = get_string('roleshortname','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name,$title,'','editingteacher');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/teacheremail';
	$title = get_string('teacheremail','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/teachermessage';
	$title = get_string('teachermessage','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/cpaneldesclimit';
	$title = get_string('cpaneldesclimit','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name,$title,'',24);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endcoursepanel');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startloading', get_string('loadingscreen','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/loadingscr';
	$title = get_string('loadingscreen','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, get_string('loadingscrdesc', 'theme_mb2mclmain'), 0);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/loadinghide';
	$title = get_string('loadinghide','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, '', 600);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/spinnerw';
	$title = get_string('spinnerw','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, '', 50);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/lbgcolor';
	$title = get_string('bgcolor','theme_mb2mclmain');
	$setting = new admin_setting_configmb2color($name, $title, '', '');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/loadinglogo';
	$title = get_string('logoimg','theme_mb2mclmain');
	$setting = new admin_setting_configstoredfile($name, $title, get_string('loadinglogodesc','theme_mb2mclmain'), 'loadinglogo');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/loadinglogoh';
	$title = get_string('logoh','theme_mb2mclmain');
	$desc = get_string('logohdesc', 'theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, $desc, '');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endloading');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startloginform', get_string('loginsearchform','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/loginlinktopage';
	$title = get_string('loginlinktopage','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/loginlinks';
	$title = get_string('loginlinks','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title, get_string('loginlinksdesc','theme_mb2mclmain'), '');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/loginsocial';
	$title = get_string('loginsocial','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/loginsearchspacer';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/searchlinks';
	$title = get_string('searchlinks','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name,$title,get_string('staticmenudesc','theme_mb2mclmain'),'');
	$temp->add($setting);



$setting = new admin_setting_configmb2end('theme_mb2mclmain/endloginform');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startlogin', get_string('pagelogin','theme_mb2mclmain'));
$temp->add($setting);




		$name = 'theme_mb2mclmain/cloginpage';
		$title = get_string('cloginpage','theme_mb2mclmain');
		$setting = new admin_setting_configcheckbox($name, $title, '', 0);
		$temp->add($setting);


		$name = 'theme_mb2mclmain/loginlogo';
		$title = get_string('logoimg','theme_mb2mclmain');
		$desc = get_string('loginlogodesc','theme_mb2mclmain');
		$setting = new admin_setting_configstoredfile($name, $title, $desc, 'loginlogo');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mclmain/loginlogoh';
		$title = get_string('logoh','theme_mb2mclmain');
		$desc = get_string('logohdesc', 'theme_mb2mclmain');
		$setting = new admin_setting_configtext($name, $title, $desc, '');
		$temp->add($setting);


		$name = 'theme_mb2mclmain/loginpgespacer';
		$setting = new admin_setting_configmb2spacer($name);
		$temp->add($setting);


		$name = 'theme_mb2mclmain/loginbgcolor';
		$title = get_string('bgcolor','theme_mb2mclmain');
		$setting = new admin_setting_configmb2color($name, $title, get_string('pbgdesc','theme_mb2mclmain'), '');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mclmain/loginbgpre';
		$title = get_string('pbgpre','theme_mb2mclmain');
		$setting = new admin_setting_configselect($name, $title, '', 'default', $bgPredefinedOpt);
		$temp->add($setting);


		$name = 'theme_mb2mclmain/loginbgimage';
		$title = get_string('bgimage','theme_mb2mclmain');
		$setting = new admin_setting_configstoredfile($name, $title, get_string('pbgdesc','theme_mb2mclmain'), 'loginbgimage');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		// $name = 'theme_mb2mclmain/loginbgrepeat';
		// $title = get_string('bgrepeat','theme_mb2mclmain');
		// $setting = new admin_setting_configselect($name, $title, '', 'no-repeat', $bgRepearOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2mclmain/loginbgpos';
		// $title = get_string('bgpos','theme_mb2mclmain');
		// $setting = new admin_setting_configselect($name, $title, '', 'center bottom', $bgPositionOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2mclmain/loginbgattach';
		// $title = get_string('bgattachment','theme_mb2mclmain');
		// $setting = new admin_setting_configselect($name, $title, '', 'fixed', $bgAttOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2mclmain/loginbgsize';
		// $title = get_string('bgsize','theme_mb2mclmain');
		// $setting = new admin_setting_configselect($name, $title, '', 'cover', $bgSizeOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endlogin');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startscrolltt', get_string('scrolltt','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/scrolltt';
	$title = get_string('scrolltt','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title,'', 1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/scrollspeed';
	$title = get_string('scrollspeed','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, '', 400);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endscrolltt');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startsitemenu', get_string('sitemenu','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/sitemnu';
	$title = get_string('sitemenu','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/sitemnuitems';
	$title = get_string('sitemnuitems','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title,get_string('sitemnuitemsdesc','theme_mb2mclmain'),'dashboard,frontpage,calendar,badges,mycourses,courses');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endsitemenu');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startganalitycs', get_string('ganatitle','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/ganaid';
	$title = get_string('ganaid','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title,$title = get_string('ganaiddesc','theme_mb2mclmain'), '');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/ganaasync';
	$title = get_string('ganaasync','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endganalitycs');
$temp->add($setting);


$ADMIN->add('theme_mb2mclmain', $temp);
