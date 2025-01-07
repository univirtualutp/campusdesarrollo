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



/*
 *
 * Method to get course banner
 *
 */
function theme_mb2mclmain_course_banner()
{

	global $CFG, $COURSE, $PAGE, $OUTPUT;

	$output = '';
	$banner = theme_mb2mclmain_theme_setting( $PAGE, 'banner' );
	$course_image = theme_mb2mclmain_course_image_url( $COURSE->id );
	$imgurl = '';

	if ( $course_image )
	{
		$imgurl = $course_image;
	}
	elseif ( $banner )
	{
		$bannerimages = theme_mb2mclmain_get_fileareaimages( 'bannerimg' );

		if ( count( $bannerimages ) > 0 )
		{
			$key = array_rand( $bannerimages, 1 );
			$imgurl = $bannerimages[$key];
		}
		else
		{
			$imgurl = $OUTPUT->image_url('header-defult','theme');
		}
	}

	if ( ! $imgurl )
	{
		return;
	}

	$cls = ' isimage';
	$banner_style = ' style="background-image:url(\'' . $imgurl  . '\');"';

	$output .= '<div class="theme-banner' . $cls . '"' . $banner_style . '>';
	$output .= '</div>';

	return $output;

}





/*
 *
 * Method to get image from course summary files
 *
 */
function theme_mb2mclmain_course_image_url( $courseid = null )
{
	global $CFG, $PAGE;

	$iscourse = ( $courseid > 1 );

	if ( ! $courseid || ! theme_mb2mclmain_theme_setting( $PAGE, 'cbannerimg' ) || ! $iscourse )
	{
		return;
	}

	require_once( $CFG->libdir . '/filelib.php' );

	$url = '';
	$context = context_course::instance( $courseid );
	$fs = get_file_storage();
	$files = $fs->get_area_files( $context->id, 'course', 'overviewfiles', 0 );

	foreach ( $files as $f )
	{
		if ( $f->is_valid_image() )
		{
			$url = moodle_url::make_pluginfile_url(
				$f->get_contextid(), $f->get_component(), $f->get_filearea(), null, $f->get_filepath(), $f->get_filename(), false );
		}
	}

	return $url;

}





/*
 *
 * Method to set block class
 *
 *
 */
function theme_mb2mclmain_page_cls($page, $course = false)
{

	$output = '';

	$isPage = $page->pagetype === 'mod-page-view';

	if ( ! isset( $page->cm->id ) )
	{
		return;
	}

	if ($course)
	{
		$pageId = $isPage ? $page->course->id : 0;
		$output .= theme_mb2mclmain_line_classes(theme_mb2mclmain_theme_setting($page, 'coursecls'), $pageId);
	}
	else
	{
		$pageId = $isPage ? $page->cm->id : 0;
		$output .= theme_mb2mclmain_line_classes(theme_mb2mclmain_theme_setting($page, 'pagecls'), $pageId);
	}


	return $output;

}







/*
 *
 * Method to set block class
 *
 *
 */
function theme_mb2mclmain_course_cls($page)
{

	$output = '';

	$output .= theme_mb2mclmain_line_classes(theme_mb2mclmain_theme_setting($page, 'coursescls'), $page->course->id);

	return $output;

}





/*
 *
 * Method to set body class for course category theme
 *
 */
function theme_mb2mclmain_courselist_cls($page)
{

	$output = '';

	$isCourse = $page->pagetype === 'course-index';
	$isCourseCat = $page->pagetype === 'course-index-category';
	$catId = ($isCourseCat && isset($page->category->id)) ? $page->category->id : 0;
	$clsPreff = 'coursetheme-';

	if ($catId > 0)
	{
		$output .= $clsPreff . theme_mb2mclmain_line_classes(theme_mb2mclmain_theme_setting($page, 'coursecattheme'), $catId);
	}
	else
	{
		$output .= $clsPreff . theme_mb2mclmain_theme_setting($page, 'coursetheme');
	}

	return $output;

}






/*
 *
 * Method to get activity header in Moodle 4
 *
 */
function theme_mb2mclmain_activityheader()
{
	global $CFG, $PAGE;

	$output = '';

	// Only for Moodle 4+
	if ( $CFG->version < 2022041900 )
	{
		return;
	}

	$header = $PAGE->activityheader;
	$headercontent = $header->export_for_template($PAGE->get_renderer('core'));

	if ( isset( $headercontent['title'] ) && $headercontent['title'] )
	{
		$output .= '<h2 class="activity-name">' . $headercontent['title'] . '</h2>';
	}

	$output .= '<div class="activity-header" data-for="page-activity-header">';

	if ( isset( $headercontent['completion'] ) && $headercontent['completion'] )
	{
		$output .= '<span class="sr-only">' . get_string('overallaggregation', 'completion') . '</span>';
		$output .= $headercontent['completion'];
	}

	if ( isset( $headercontent['description'] ) && $headercontent['description'] )
	{
		$output .= $headercontent['description'];
	}

	if ( isset( $headercontent['additional_items'] ) && $headercontent['additional_items'] )
	{
		$output .= $headercontent['additional_items'];
	}

	$output .= '</div>'; // activity-header

	return $output;

}



/*
 *
 * Method to get course sections array
 *
 */
function theme_mb2mclmain_get_course_sections( $ccourse = false, $sectionid = 0, $onlyvisible = false )
{
	global $COURSE;

	$csections = array();
	$courseobj = $ccourse ? $ccourse : $COURSE;
	$iscourse = $courseobj->id > 1;
	$coursecontext = context_course::instance($courseobj->id);

	if ( ! $iscourse )
	{
		return $csections;
	}

	$modinfo = get_fast_modinfo( $courseobj );
	$sections = $modinfo->get_section_info_all();

	foreach ( $sections as $section )
	{
		if ( ( ! $section->visible && ! has_capability('moodle/course:viewhiddensections', $coursecontext) && ! $onlyvisible ) || ! $section->sequence || ($sectionid > 0 && $sectionid != $section->id) )
		{
			continue;
		}

		$csections[] = array(
			'num' => $section->section,
			'id' => $section->id,
			'visible' => $section->visible,
			'name' => get_section_name( $courseobj, $section )
		);
	}

	return $csections;

}



/*
 *
 * Method to get section activities
 *
 */
function theme_mb2mclmain_get_section_activities( $sectionid = 0, $label = false, $onlyvisible = false, $onlyuservisible = true )
{

	global $CFG, $OUTPUT, $COURSE;

    $modinfo = get_fast_modinfo( $COURSE );
    $modules = array();

	foreach ( $modinfo->cms as $cm )
	{

		if ( $sectionid !== false && $cm->section != $sectionid )
		{
			continue;
		}

        if ( ! $cm->visible && $onlyvisible )
		{
            continue;
        }

		if ( $onlyuservisible && ! $cm->uservisible )
		{
            continue;
        }

		if ( ! $label && ! $cm->has_view() )
		{
			continue;
		}

		if ( $cm->deletioninprogress )
		{
			continue;
		}

		$mod = array();
		$archetype = plugin_supports('mod', $cm->modname, FEATURE_MOD_ARCHETYPE, MOD_ARCHETYPE_OTHER);

		$mod['id'] = $cm->id;
		$mod['name'] = $cm->name;
		$mod['modname'] = $cm->modname;
		$mod['icon'] = $OUTPUT->image_url( 'icon', $cm->modname );
		$mod['url'] = $cm->url;
		$mod['section'] = $cm->section;
		$mod['visible'] = $cm->visible;

		if ( $archetype == MOD_ARCHETYPE_RESOURCE )
		{
			$mod['isresource'] = 1;
		}
		else
		{
			$mod['isresource'] = 0;
		}

		$modules[] = $mod;
    }

    return $modules;

}




/*
 *
 * Method to get section complete percentage
 *
 */
function theme_mb2mclmain_section_complete( $section, $iscomplete = false )
{
	global $COURSE, $USER;

	$total = 0;
	$complete = 0;
	$modinfo = get_fast_modinfo( $COURSE );
	$completioninfo = new completion_info( $COURSE );
	$cancomplete = isloggedin() && ! isguestuser();

	if ( ! $cancomplete || ! $completioninfo->is_tracked_user( $USER->id ) )
	{
		return false;
	}

	foreach ( $modinfo->sections[$section] as $cmid )
	{
		$thismod = $modinfo->cms[$cmid];

		if ($thismod->uservisible)
		{
			if ( $cancomplete && $completioninfo->is_enabled($thismod) != COMPLETION_TRACKING_NONE )
			{
				$total++;
				$completiondata = $completioninfo->get_data($thismod, true);
				if ( $completiondata->completionstate == COMPLETION_COMPLETE || $completiondata->completionstate == COMPLETION_COMPLETE_PASS )
				{
					$complete++;
				}
			}
		}
	}

	if ( $iscomplete && $total > 0 && $total == $complete )
	{
		return true;
	}

	if ( ! $iscomplete && $total > 0 )
	{
		return round( ($complete/$total) * 100, 2 );
	}

	return false;

}



/*
 *
 * Method to get section activities
 *
 */
function theme_mb2mclmain_section_module_list( $sectionid, $link = false, $active = false, $visible = false, $uservisible = true )
{
	global $PAGE;
	$output = '';
	$modules = theme_mb2mclmain_get_section_activities( $sectionid, true, $visible, $uservisible );

	if ( ! count( theme_mb2mclmain_get_section_activities( $sectionid, false, $visible, $uservisible ) ) )
	{
		return;
	}

	$output .= '<ul class="section-modules">';

	foreach ( $modules as $k=>$m )
	{
		$modlink = new moodle_url( $m['url'], array('forceview'=>1) );
		$modactive = $active && is_object( $PAGE->cm ) && $PAGE->cm->id == $m['id'] ? ' active' : '';
		$modcomplete = theme_mb2mclmain_module_complete($m['id']) ? ' complete' . theme_mb2mclmain_module_complete($m['id']) : '';

		// Display lable a separator
		// Only between other activities
		if ( $m['modname'] === 'label' && isset( $modules[$k+1] ) && isset( $modules[$k-1] ) )
		{
			$output .= '<li class="separator">';
			$output .= '<hr>';
			$output .= '</li>';
		}
		elseif ($m['modname'] !== 'label')
		{

			$hiddenicon = '';
			$hiddencls = '';

			if ( ! $m['visible'] )
			{
				$hiddencls = ' hiddenmodule';
				$hiddenicon .= '<span class="hiddenicon" aria-hidden="true"><i class="fa fa-eye-slash"></i></span>';
				$hiddenicon .= '<span class="sr-only">' . get_string('hiddenfromstudents') . '</span>';
			}

			$output .= '<li class="module-' . $m['modname'] . $modactive . $modcomplete . $hiddencls . '">';
			$output .= $link ? '<a href="' . $modlink . '">' : '';
			$output .= '<span class="itemimage" aria-hidden="true"><img class="activityicon" src="' . $m['icon'] . '" alt="' . $m['name'] . '"></span>';
			$output .= '<span class="itemname">' . $m['name'] . $hiddenicon . '</span>';
			$output .= $link ? '</a>' : '';
			$output .= '</li>';
		}
	}

	$output .= '</ul>';

	return $output;

}




/*
 *
 * Method to check if toc appears
 *
 */
function theme_mb2mclmain_is_toc()
{
	global $PAGE, $COURSE, $SITE;

	$coursetoc = theme_mb2mclmain_theme_setting($PAGE, 'coursetoc');
	$sections = theme_mb2mclmain_get_course_sections();
	$ismodule = theme_mb2mclmain_is_module_context();
	$editing = $PAGE->user_is_editing();

	if ( $COURSE->format === 'singleactivity' || ! $coursetoc || ! count($sections) || $COURSE->id == $SITE->id || $editing )
	{
		return false;
	}

	if ( $ismodule || preg_match( '@course-view@', $PAGE->pagetype ) )
	{
		return true;
	}

	return false;

}





/*
 *
 * Method to get course sections
 *
 */
function theme_mb2mclmain_module_sections( $block = false )
{
	global $PAGE;
	$output = '';

	// AMD for toc in block on course main page
	user_preference_allow_ajax_update('coursetoc-toggleall', PARAM_ALPHA);
	$toggle = get_user_preferences('coursetoc-toggleall', 'close');
	$toggletext = $toggle === 'open' ? get_string('collapseall') : get_string('expandall');
	$collapsedcls = $toggle === 'close' ? ' collapsed' : '';
	$cmainpage = preg_match('@course-view@', $PAGE->pagetype);

	$sections = theme_mb2mclmain_get_course_sections();
	$blockstyle = 'default';

	if ( $block )
	{
		$output .= '<div class="style-' . $blockstyle . '">';
		$output .= '<div class="block block_coursetoc">';
		$output .= '<h5 class="header">' . get_string('coursetoc', 'theme_mb2mclmain') . '</h5>';

		if ( $cmainpage )
		{
			$output .= '<div class="coursetoc-tool"><button type="button" class="themereset coursetoc-toggleall' . $collapsedcls . '" data-collapseall="' .
			get_string('collapseall') . '" data-expandall="' . get_string('expandall') . '">' . $toggletext . '</button></div>';
			$PAGE->requires->js_call_amd( 'theme_mb2mclmain/toc', 'toggleAll' );
		}
	}

	$output .= '<div class="coursetoc-sectionlist">';

	foreach ( $sections as $section )
	{
		$modules = theme_mb2mclmain_get_section_activities( $section['id'] );

		if ( ! count( $modules ) )
		{
			continue;
		}

		$completepercentage = theme_mb2mclmain_section_complete( $section['num'] );
		$iscomplete = theme_mb2mclmain_section_complete( $section['num'], true );
		$completecls =  $iscomplete ? ' complete' : '';
		$hiddencls = '';
		$hiddenicon = '';
		$isactive = '';

		if ( ! $section['visible'] )
		{
			$hiddencls = ' hiddensection';
			$hiddenicon .= '<span class="hiddenicon" aria-hidden="true"><i class="fa fa-eye-slash"></i></span>';
			$hiddenicon .= '<span class="sr-only">' . get_string('hiddenfromstudents') . '</span>';
		}

		if ( $block && $toggle === 'open' && $cmainpage )
		{
			$isactive = ' active';
		}
		elseif ( is_object( $PAGE->cm ) && $PAGE->cm->section == $section['id'] )
		{
			$isactive = ' active';
		}

		$output .= '<div class="coursetoc-section coursetoc-section-' . $section['num'] . $completecls . $isactive . $hiddencls . '" data-id="' . $section['id'] . '">';
		$output .= '<div class="coursetoc-section-tite">';
		$output .= '<button type="button" class="coursetoc-section-toggle themereset" aria-controls="coursetoc-section-modules-' . $section['id'] . '" aria-label="' . $section['name'] . '">';
		$output .= '<span class="toggle-icon"></span>';
		$output .= '<span class="title-text">' . $section['name'] . $hiddenicon . '</span>';
		$output .= $completepercentage !== false ? '<span class="title-complete">(' . $completepercentage . '%)</span>' : '';
		$output .= '</button>';
		$output .= '</div>'; //coursetoc-section-tite
		$output .= '<div id="coursetoc-section-modules-' . $section['id'] . '" class="coursetoc-section-modules">';
		$output .= theme_mb2mclmain_section_module_list( $section['id'], true, true );
		$output .= '</div>'; //coursetoc-section-modules
		$output .= '</div>'; //coursetoc-section
	}

	$output .= '</div>'; // coursetoc-sectionlist

	if ( $block )
	{
		$output .= '</div>'; // block block_coursetoc
		$output .= '</div>'; // block
	}

	$PAGE->requires->js_call_amd( 'theme_mb2mclmain/toc', 'courseToc' );

	return $output;

}




/*
 *
 * Method to check if module is complete
 *
 */
function theme_mb2mclmain_module_complete( $mod )
{
	global $COURSE, $USER;
	$completioninfo = new completion_info( $COURSE );
	$cancomplete = isloggedin() && ! isguestuser();
	$modinfo = get_fast_modinfo( $COURSE );
	$thismod = $modinfo->cms[$mod];

	if ( ! $cancomplete || ! $completioninfo->is_tracked_user( $USER->id ) )
	{
		return;
	}

	if ( $thismod->uservisible )
	{
		if ( $cancomplete && $completioninfo->is_enabled($thismod) != COMPLETION_TRACKING_NONE )
		{
			$completiondata = $completioninfo->get_data($thismod, true);

			if ( $completiondata->completionstate == COMPLETION_COMPLETE || $completiondata->completionstate == COMPLETION_COMPLETE_PASS )
			{
				return 1;
			}
			else
			{
				return -1;
			}
		}
	}

	return 2;

}
