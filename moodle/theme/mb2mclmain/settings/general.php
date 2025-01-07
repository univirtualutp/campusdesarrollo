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


$temp = new admin_settingpage('theme_mb2mclmain_settingsgeneral',  get_string('settingsgeneral', 'theme_mb2mclmain'));

$headerStyleOpt = array(
	'light' => get_string('light','theme_mb2mclmain'),
	'color' => get_string('color','theme_mb2mclmain')
);

$setting = new admin_setting_configmb2start('theme_mb2mclmain/startlogo', get_string('logo','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/logo';
	$title = get_string('logoimg','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configstoredfile($name, $title, $desc, 'logo');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/logoh';
	$title = get_string('logoh','theme_mb2mclmain');
	$desc = get_string('logohdesc', 'theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, $desc, 2.9);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/logomtb';
	$title = get_string('logomtb','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, '', 1);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/logotitle';
	$title = get_string('logotitle','theme_mb2mclmain');
	$desc = get_string('logotitledesc', 'theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, $desc, 'Macro Learning Theme');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/logoalttext';
	$title = get_string('logoalttext','theme_mb2mclmain');
	$desc = get_string('logoalttextdesc', 'theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, $desc, 'Macro Learning Theme');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/logospacer';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/favicon';
	$title = get_string('favicon','theme_mb2mclmain');
	$desc = get_string('favicondesc', 'theme_mb2mclmain');
	$setting = new admin_setting_configstoredfile($name, $title, $desc, 'favicon', 0, array('accepted_types'=>array('.ico')));
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endlogo');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startlayout', get_string('layout','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/pagewidth';
	$title = get_string('pagewidth','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, '', 1320);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$layoutArr = array(
		'fw' => get_string('layoutfw','theme_mb2mclmain'),
		'fx' => get_string('layoutfx','theme_mb2mclmain')
	);
	$name = 'theme_mb2mclmain/layout';
	$title = get_string('layout','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'fw', $layoutArr);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/layoutspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$sidebarPosArr = array(
		'classic' => get_string('classic','theme_mb2mclmain'),
		'left' => get_string('left','theme_mb2mclmain'),
		'right' => get_string('right','theme_mb2mclmain')
	);

	$name = 'theme_mb2mclmain/sidebarpos';
	$title = get_string('sidebarpos','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'right', $sidebarPosArr);
	$temp->add($setting);

	$sidebarBtArr = array(
		0 => get_string('none','theme_mb2mclmain'),
		1 => get_string('sidebaryesshow','theme_mb2mclmain'),
		2 => get_string('sidebaryeshide','theme_mb2mclmain')
	);

	$name = 'theme_mb2mclmain/sidebarbtn';
	$title = get_string('sidebarbtn','theme_mb2mclmain');
	$setting = new admin_setting_configselect($name, $title, '', 0, $sidebarBtArr);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/layoutspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$pageSidebarArr = array(
		'none' => get_string('none','theme_mb2mclmain'),
		'left' => get_string('left','theme_mb2mclmain'),
		'right' => get_string('right','theme_mb2mclmain')
	);

	$name = 'theme_mb2mclmain/pagesidebar';
	$title = get_string('pagesidebar','theme_mb2mclmain');
	$setting = new admin_setting_configselect($name, $title, '', 'left', $pageSidebarArr);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/sidebarw';
	$title = get_string('sidebarw','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title, '', 345);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endlayout');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startheaderstyle', get_string('headerstyleheading','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/headerstyle';
	$title = get_string('headerstyle','theme_mb2mclmain');
	$setting = new admin_setting_configselect($name, $title, '', 'light', $headerStyleOpt);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/stickyheader';
	$title = get_string('stickyheader','theme_mb2mclmain');
	$setting = new admin_setting_configselect( $name, $title, '', 2, array(
		0 => get_string('none','theme_mb2mclmain'),
		1 => get_string('yes','theme_mb2mclmain'),
		2 => get_string('stickyheader2','theme_mb2mclmain')
	 ));
	$temp->add($setting);

	$name = 'theme_mb2mclmain/navbarplugin';
	$title = get_string('navbarplugin','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/headerspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/headerbtn';
	$title = get_string('headerbtn','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title, get_string('headerbtndesc','theme_mb2mclmain'),'');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/headerspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/banner';
	$title = get_string('banner','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/bannerimg';
	$title = get_string('bannerimg','theme_mb2mclmain');
	$desc = get_string('bannerimgdesc', 'theme_mb2mclmain');
	$setting = new admin_setting_configstoredfile($name, $title, $desc, 'bannerimg', 0, array( 'maxfiles'=> 5 ));
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endheaderstyle');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startslider', get_string('frontpage','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/slider';
	$title = get_string('slider','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endslider');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2mclmain/startcourse', get_string('coursesettings','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/coursegridfp';
	$title = get_string('coursegridfp','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/coursegridcat';
	$title = get_string('coursegridcat','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/courseswitchlayout';
	$title = get_string('courseswitchlayout','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/coursespacer3';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/coursetoc';
    $title = get_string('coursetoc','theme_mb2mclmain');
    $setting = new admin_setting_configcheckbox($name, $title, '', 1);
    $temp->add($setting);

	$name = 'theme_mb2mclmain/coursespacer17';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/cbannerimg';
	$title = get_string('cbannerstyle','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/courseplimg';
	$title = get_string('courseplimg','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/coursespacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/coursebtn';
	$title = get_string('coursebtn','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/coursestudentscount';
	$title = get_string('coursestudentscount','theme_mb2mclmain');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/studentsroleid';
	$title = get_string('studentsroleid','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name,$title,'',5);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endcourse');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startregions', get_string('regions','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/blockstyle';
	$title = get_string('blockstyle','theme_mb2mclmain');
	$desc = get_string('blockstyledesc','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title, $desc, '');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endregions');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startstatic', get_string('staticcontent','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/topinfo';
	$title = get_string('topinfo','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title, get_string('staticinfodesc','theme_mb2mclmain'),'');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/staticcontentspacer';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/btninfo';
	$title = get_string('btinfo','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title, get_string('staticinfodesc','theme_mb2mclmain'),'');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endstatic');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startfooter', get_string('footer','theme_mb2mclmain'));
$temp->add($setting);

	$name = 'theme_mb2mclmain/foottext';
	$title = get_string('foottext','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title,'', '');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/footmenu';
	$title = get_string('footmenu','theme_mb2mclmain');
	$setting = new admin_setting_configtextarea($name, $title, get_string('staticmenudesc','theme_mb2mclmain'),'');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/footlogin';
	$title = get_string('footlogin','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configcheckbox($name, $title, $desc, 0);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mclmain/endfooter');
$temp->add($setting);



$ADMIN->add('theme_mb2mclmain', $temp);
