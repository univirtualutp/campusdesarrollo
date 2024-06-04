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


$temp = new admin_settingpage('theme_mb2mclmain_settingstypography',  get_string('settingstypography', 'theme_mb2mclmain'));


$fontsGlobalOpt = array(
	'nfont1'=>get_string('nfont','theme_mb2mclmain') . ' #1',
	'nfont2'=>get_string('nfont','theme_mb2mclmain') . ' #2',
	'nfont3'=>get_string('nfont','theme_mb2mclmain') . ' #3',
	''=>'------------',
	'gfont1'=>get_string('gfont','theme_mb2mclmain') . ' #1',
	'gfont2'=>get_string('gfont','theme_mb2mclmain') . ' #2',
	'gfont3'=>get_string('gfont','theme_mb2mclmain') . ' #3',
);


$fontsOpt = array(
	'0'=>get_string('global','theme_mb2mclmain'),
	'nfont1'=>get_string('nfont','theme_mb2mclmain') . ' #1',
	'nfont2'=>get_string('nfont','theme_mb2mclmain') . ' #2',
	'nfont3'=>get_string('nfont','theme_mb2mclmain') . ' #3',
	''=>'------------',
	'gfont1'=>get_string('gfont','theme_mb2mclmain') . ' #1',
	'gfont2'=>get_string('gfont','theme_mb2mclmain') . ' #2',
	'gfont3'=>get_string('gfont','theme_mb2mclmain') . ' #3',
);


$fontsWeightOpt = array(
	'normal'=>get_string('normal','theme_mb2mclmain'),
	'bold'=>get_string('bold','theme_mb2mclmain'),
	'bolder'=>get_string('bolder','theme_mb2mclmain'),
	'lighter'=>get_string('lighter','theme_mb2mclmain'),
	'100'=>'100',
	'200'=>'200',
	'300'=>'300',
	'400'=>'400',
	'500'=>'500',
	'600'=>'600',
	'700'=>'700',
	'800'=>'800',
	'900'=>'900',
	'inherit'=>get_string('inherit','theme_mb2mclmain')
);


$ftextTransfromOpt = array(
	'none'=>get_string('none','theme_mb2mclmain'),
	'uppercase'=>get_string('uppercase','theme_mb2mclmain'),
	'capitalize'=>get_string('capitalize','theme_mb2mclmain'),
	'lowercase'=>get_string('lowercase','theme_mb2mclmain')
);


$fontStyleOpt = array(
	'normal'=>get_string('normal','theme_mb2mclmain'),
	'italic'=>get_string('italic','theme_mb2mclmain'),
	'oblique'=>get_string('oblique','theme_mb2mclmain')
);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startfgeneral', get_string('global','theme_mb2mclmain'));
$temp->add($setting);


	$name = 'theme_mb2mclmain/ffgeneral';
	$title = get_string('ffamily','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'gfont1', $fontsGlobalOpt);
	$temp->add($setting);


	$name = 'theme_mb2mclmain/typoblobalspacer0';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/fsbase';
	$title = get_string('fsbase','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name,$title,'',17);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fsbase2';
	$title = get_string('fsbase2','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name,$title,get_string('fsizepxdesc', 'theme_mb2mclmain'),19);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fsbase3';
	$title = get_string('fsbase3','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name,$title,get_string('fsizepxdesc', 'theme_mb2mclmain'),20);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/typoblobalspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fwgeneral';
	$title = get_string('fweight','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 400, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/typoblobalspacer';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/fwbold';
	$title = get_string('fwbold','theme_mb2mclmain');
	$setting = new admin_setting_configselect($name, $title, '', 'bold', $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endfgeneral');
$temp->add($setting);





$setting = new admin_setting_configmb2start('theme_mb2mclmain/startfheadings', get_string('headings','theme_mb2mclmain'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mclmain/ffheadings';
	$title = get_string('ffamily','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, '0', $fontsOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mclmain/fheadingsspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	for ($i = 1; $i <= 6; $i++ )
	{
		$name = 'theme_mb2mclmain/fsheading' . $i;
		$title = get_string('hsize','theme_mb2mclmain', array( 'size'=>$i ) );
		$setting = new admin_setting_configtext($name,$title,'','');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);
	}

	$name = 'theme_mb2mclmain/fheadingsspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mclmain/fwheadings';
	$title = get_string('fweight','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 600, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/ttheadings';
	$title = get_string('ttransform','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'none', $ftextTransfromOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fstheadings';
	$title = get_string('fstyle','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'normal', $fontStyleOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endfheadings');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);






$setting = new admin_setting_configmb2start('theme_mb2mclmain/startfmenu', get_string('menu','theme_mb2mclmain'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mclmain/ffmenu';
	$title = get_string('ffamily','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, '0', $fontsOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fsmenu';
	$title = get_string('fsize','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title,'', 0.9);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fwmenu';
	$title = get_string('fweight','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 600, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/ttmenu';
	$title = get_string('ttransform','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'uppercase', $ftextTransfromOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fstmenu';
	$title = get_string('fstyle','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'normal', $fontStyleOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endfmenu');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2mclmain/startfddmenu', get_string('ddmenu','theme_mb2mclmain'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mclmain/ffddmenu';
	$title = get_string('ffamily','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc,'0', $fontsOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fsddmenu';
	$title = get_string('fsize','theme_mb2mclmain');
	$setting = new admin_setting_configtext($name, $title,'', 0.8);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fwddmenu';
	$title = get_string('fweight','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 600, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/ttddmenu';
	$title = get_string('ttransform','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'uppercase', $ftextTransfromOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mclmain/fstddmenu';
	$title = get_string('fstyle','theme_mb2mclmain');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'normal', $fontStyleOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mclmain/endfddmenu');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);




for ($i = 1; $i<=3; $i++)
{
	$setting = new admin_setting_configmb2start('theme_mb2mclmain/startceltypo' . $i, get_string('celtypo','theme_mb2mclmain') . ' #' . $i);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


		$name = 'theme_mb2mclmain/celsel' . $i;
		$title = get_string('celsel','theme_mb2mclmain');
		$setting = new admin_setting_configtextarea($name, $title, get_string('celseldesc','theme_mb2mclmain'),'');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mclmain/ffcel' . $i;
		$title = get_string('ffamily','theme_mb2mclmain');
		$setting = new admin_setting_configselect($name, $title, '', '0', $fontsOpt);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mclmain/fwcel' . $i;
		$title = get_string('fweight','theme_mb2mclmain');
		$setting = new admin_setting_configselect($name, $title, '', 'inherit', $fontsWeightOpt);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


	$setting = new admin_setting_configmb2end('theme_mb2mclmain/endceltypo' . $i);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
}






$ADMIN->add('theme_mb2mclmain', $temp);
