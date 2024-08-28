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
 * Course renderer for boosted theme.
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace theme_boosted\output\core;

use moodle_url;
use lang_string;
use coursecat_helper;
use core_course_category;
use stdClass;
use core_course_list_element;
use context_course;
use context_system;
use pix_url;
use html_writer;
use heading;
use pix_icon;
use image_url;
use single_select;

/**
 * Course renderer class.
 *
 * @package    theme_boosted
 * @copyright  2022-2023 koditik.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


class course_renderer extends \core_course_renderer {
    protected $countcategories = 0;

    public function view_available_courses($id = 0, $courses = null, $totalcount = null) {
        global $CFG;
        require_once($CFG->dirroot . '/course/renderer.php');

        $titletooltip = '';
        $trimtitle = 60;
        $trimsummary = 150;

        $kcourseid = array_keys($courses);
        $acourseid = array_chunk($kcourseid, 3);

        if ($id != 0) {
            $newcourse = get_string('availablecourses');
        } else {
            $newcourse = '';
        }

        $rowcontent = '
            <div id="category-course-list">
                <div class="courses category-course-list-all">
                    <div class="class-list">
                        <h3>' . $newcourse . '</h3>
                    </div>';

        if (count($kcourseid) > 0) {
            // Course Row *********************************.
            $rowcontent .= '<div class="row courses-list">';
            foreach ($acourseid as $courseids) {
                foreach ($courseids as $courseid) {
                    // Get course information.
                    $course = get_course($courseid);
                    if (($course->visible) || is_siteadmin()) {
                        $coursesummary = mb_strimwidth(format_string($course->summary), 0, $trimsummary, '...', 'utf-8');
                        $coursetitle   = mb_strimwidth(format_string($course->fullname), 0, $trimtitle, '...', 'utf-8');
                        $courseurl     = new moodle_url('/course/view.php', array('id' => $courseid));
                        $systemcontext = $this->page->bodyid;

                        if ($course instanceof stdClass) {
                            $course = new core_course_list_element($course);
                        }

                        // Enrolment icons.
                        $pixcontent = '';

                        if ($icons = enrol_get_course_info_icons($course)) {
                            $pixcontent .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
                            foreach ($icons as $pixicon) {
                                $pixcontent .= $this->render($pixicon);
                            }
                            $pixcontent .= html_writer::end_tag('div');
                        }

                        // Course category.
                        $catcontent = '';
                        if ($cat = core_course_category::get($course->category, IGNORE_MISSING)) {
                            $catcontent .= html_writer::link(new moodle_url('/course/index.php',
                                            array('categoryid' => $cat->id)), $cat->get_formatted_name(),
                                            array('class' => $cat->visible ? 'text-decoration-none' : 'dimmed'));
                        }

                        $context  = context_course::instance($course->id);

                        // Course Image.
                        // Default image. It can be replaced in the /pix directory.
                        $imgurl = $CFG->wwwroot . "/theme/boosted/pix/noimage.jpg";

                        foreach ($course->get_course_overviewfiles() as $file) {
                            $isimage = $file->is_valid_image();
                            if ($isimage) {
                                $imgurl = file_encode_url("$CFG->wwwroot/pluginfile.php", '/' . $file->get_contextid() . '/'
                                                                                              . $file->get_component() . '/'
                                                                                              . $file->get_filearea()
                                                                                              . $file->get_filepath()
                                                                                              . $file->get_filename(),
                                                                                              !$isimage
                                );
                            }
                        }

                        if ($titletooltip) {
                            $tooltiptext = 'data-toggle="tooltip" data-placement= "top" title="'
                                        . format_string($course->fullname) . '"';
                        } else {
                            $tooltiptext = '';
                        }

                        // Col Card *****************************************************************************************************************.
                        $rowcontent .= '<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3">';
                        // Course Card.
                        $rowcontent .= '<div class="card text-center h-100 shadow shadow-intensity-sm course-tile">';
                        $rowcontent .= '<a ' . $tooltiptext . ' href="' . $courseurl .
                                    '" class="course-link card-block text-decoration-none">';

                        // Course Image.
                        $rowcontent .= '<div class="card-image course-image-overlay">
                                            <img class="card-img-top course-image h80"
                                                 src="'.$imgurl. '" loading="lazy" alt="'.$coursetitle.'">
                                        </div>';

                        // Card Body.
                        $rowcontent .= '<div class="card-body">
                                            <h3 class="card-title course-title">' . $coursetitle . '</h3>
                                            <p class="card-text course-summary">' . $coursesummary . '</p>
                                        </div>
                                        </a>';

                        // Card Footer.
                        $rowcontent .= '<div class="card-footer">
                                            <div class="float-left badge badge-primary badge-pill course-category">'
                                            . $catcontent .
                                            '</div>
                                            <div class="float-right">' . $pixcontent . '</div>
                                        </div>';

                        $rowcontent .= '</div>';
                        // End Card.

                        $rowcontent .= '</div>';
                        // End Col Card ********************************************************************************************************************.
                    }   // Course visible.
                }
            }
        }

        $rowcontent .= '</div>';
        return $rowcontent;
    }

    protected function coursecat_courses(coursecat_helper $chelper, $courses, $totalcount = null) {
        global $CFG;
        if ($totalcount === null) {
            $totalcount = count($courses);
        }
        if (!$totalcount) {
            // Courses count is cached during courses retrieval.
            return '';
        }
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_AUTO) {
            if ($totalcount <= $CFG->courseswithsummarieslimit) {
                $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);
            } else {
                $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED);
            }
        }
        $paginationurl = $chelper->get_courses_display_option('paginationurl');
        $paginationallowall = $chelper->get_courses_display_option('paginationallowall');
        if ($totalcount > count($courses)) {
            if ($paginationurl) {
                $perpage = $chelper->get_courses_display_option('limit', $CFG->coursesperpage);
                $page = $chelper->get_courses_display_option('offset') / $perpage;
                $pagingbar = $this->paging_bar($totalcount, $page, $perpage, $paginationurl->out(false, array(
                    'perpage' => $perpage
                )));
                if ($paginationallowall) {
                    $pagingbar .= html_writer::tag('div', html_writer::link($paginationurl->out(false, array(
                        'perpage' => 'all'
                    )) , get_string('showall', '', $totalcount)) , array(
                        'class' => 'paging paging-showall'
                    ));
                }
            } else if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
                $viewmoretext = $chelper->get_courses_display_option('viewmoretext', new lang_string('viewmore'));
                $morelink = html_writer::tag('div', html_writer::tag('a', html_writer::start_tag('i', array(
                    'class' => 'fa-graduation-cap' . ' fa fa-fw'
                )) . html_writer::end_tag('i') . $viewmoretext, array(
                    'href' => $viewmoreurl,
                    'class' => 'btn btn-primary coursesmorelink'
                )) , array(
                    'class' => 'paging paging-morelink'
                ));
            }
        } else if (($totalcount > $CFG->coursesperpage) && $paginationurl && $paginationallowall) {
            $pagingbar = html_writer::tag('div', html_writer::link($paginationurl->out(false, array(
                'perpage' => $CFG->coursesperpage
            )) , get_string('showperpage', '', $CFG->coursesperpage)) , array(
                'class' => 'paging paging-showperpage'
            ));
        }

        $attributes = $chelper->get_and_erase_attributes('courses');
        $content = html_writer::start_tag('div', $attributes);

        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }

        $categoryid = optional_param('categoryid', 0, PARAM_INT);
        $coursecount = 0;
        $content .= $this->view_available_courses($categoryid, $courses, $totalcount);

        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }
        if (!empty($morelink)) {
            $content .= $morelink;
        }
        $content .= html_writer::end_tag('div');
        $content .= '<div class="clearfix"></div>';

        return $content;
    }

    protected static function timeaccesscompare($start, $end) {
        // Compare time end entry and time start entry.
        if ((!empty($start->timeaccess)) && (!empty($end->timeaccess))) {
            // Both last access.
            if ($start->timeaccess == $end->timeaccess) {
                return 0;
            }
            return ($start->timeaccess > $end->timeaccess) ? -1 : 1;
        } else if ((!empty($start->timestart)) && (!empty($end->timestart))) {
            // Both enrol.
            if ($start->timestart == $end->timestart) {
                return 0;
            }
            return ($start->timestart > $end->timestart) ? -1 : 1;
        }

        if (!empty($start->timestart)) {
            return -1;
        }
        return 1;
    }

    public function frontpage_my_courses() {
        global $USER, $CFG, $DB;

        if (!isloggedin() || isguestuser()) {
            return '';
        }

        $nomycourses = '<div class="alert alert-info alert-block">' . get_string('nomycourses', 'theme_boosted') . '</div>';
        $lastaccess = '';
        $output = '';
        $showbylastaccess = 1;

        if ($showbylastaccess == 1) {
            $courses = enrol_get_my_courses(null, 'sortorder ASC');
            if ($courses) {
                // We have something to work with.  Get the last accessed information for the user and populate.
                global $DB, $USER;
                $lastaccess = $DB->get_records('user_lastaccess', array('userid' => $USER->id) , '', 'courseid, timeaccess');
                if ($lastaccess) {
                    foreach ($courses as $course) {
                        if (!empty($lastaccess[$course->id])) {
                            $course->timeaccess = $lastaccess[$course->id]->timeaccess;
                        }
                    }
                }
                // Determine if we need to query the enrolment and user enrolment tables.
                $enrolquery = false;
                foreach ($courses as $course) {
                    if (empty($course->timeaccess)) {
                        $enrolquery = true;
                        break;
                    }
                }
                if ($enrolquery) {
                    // We do.
                    $params = array(
                        'userid' => $USER->id
                    );
                    $sql = "SELECT ue.id, e.courseid, ue.timestart
                        FROM {enrol} e
                        JOIN {user_enrolments} ue ON (ue.enrolid = e.id AND ue.userid = :userid)";
                    $enrolments = $DB->get_records_sql($sql, $params, 0, 0);
                    if ($enrolments) {
                        // Sort out any multiple enrolments on the same course.
                        $userenrolments = array();
                        foreach ($enrolments as $enrolment) {
                            if (!empty($userenrolments[$enrolment->courseid])) {
                                if ($userenrolments[$enrolment->courseid] < $enrolment->timestart) {
                                    // Replace.
                                    $userenrolments[$enrolment->courseid] = $enrolment->timestart;
                                }
                            } else {
                                $userenrolments[$enrolment->courseid] = $enrolment->timestart;
                            }
                        }
                        // We don't need to worry about timeend etc. as our course list will be valid for the user from above.
                        foreach ($courses as $course) {
                            if (empty($course->timeaccess)) {
                                $course->timestart = $userenrolments[$course->id];
                            }
                        }
                    }
                }
                uasort($courses, array($this, 'timeaccesscompare'));
            } else {
                return $nomycourses;
            }
            $sortorder = $lastaccess;
        } else if (!empty($CFG->navsortmycoursessort)) {
            $sortorder = 'visible DESC,' . $CFG->navsortmycoursessort . ' ASC';
            $courses = enrol_get_my_courses('summary, summaryformat', $sortorder);
            if (!$courses) {
                return $nomycourses;
            }
        } else {
            $sortorder = 'visible DESC,sortorder ASC';
            $courses = enrol_get_my_courses('summary, summaryformat', $sortorder);
            if (!$courses) {
                return $nomycourses;
            }
        }

        $rhosts = array();
        $rcourses = array();

        if (!empty($CFG->mnet_dispatcher_mode) && $CFG->mnet_dispatcher_mode === 'strict') {
            $rcourses = get_my_remotecourses($USER->id);
            $rhosts = get_my_remotehosts();
        }

        if (!empty($courses) || !empty($rcourses) || !empty($rhosts)) {
            $chelper = new coursecat_helper();
            if (count($courses) > $CFG->frontpagecourselimit) {
                // There are more enrolled courses than we can display, display link to 'My courses'.
                $totalcount = count($courses);
                $courses = array_slice($courses, 0, $CFG->frontpagecourselimit, true);
                $chelper->set_courses_display_options(array(
                    'viewmoreurl' => new moodle_url('/my/') ,
                    'viewmoretext' => new lang_string('mycourses')
                ));
            } else {
                // All enrolled courses are displayed, display link to 'All courses' if there are more courses in system.
                $chelper->set_courses_display_options(array(
                    'viewmoreurl' => new moodle_url('/course/index.php') ,
                    'viewmoretext' => new lang_string('fulllistofcourses')
                ));
                $totalcount = $DB->count_records('course') - 1;
            }

            $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->set_attributes(array(
                'class' => 'frontpage-course-list-enrolled'
            ));

            $output .= $this->coursecat_courses($chelper, $courses, $totalcount);

            // MNET.
            if (!empty($rcourses)) {
                $output .= html_writer::start_tag('div', array(
                    'class' => 'courses'
                ));
                foreach ($rcourses as $course) {
                    $output .= $this->frontpage_remote_course($course);
                }
                $output .= html_writer::end_tag('div');
            } else if (!empty($rhosts)) {
                $output .= html_writer::start_tag('div', array(
                    'class' => 'courses'
                ));
                foreach ($rhosts as $host) {
                    $output .= $this->frontpage_remote_host($host);
                }
                // End courses.
                $output .= html_writer::end_tag('div');
            }
        }
        return $output;
    }
    // End if.
}
