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

namespace gradeexport_ods\event;

/**
 * ODS grade export events test cases.
 *
 * @package    gradeexport_ods
 * @copyright  2016 Zane Karl zkarl@oid.ucla.edu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class events_test extends \advanced_testcase {

    /**
     * Setup is called before calling test case.
     */
    public function setUp(): void {
        $this->resetAfterTest();
    }

    /**
     * Test course_module_instance_list_viewed event.
     */
    public function test_logging() {
        // There is no proper API to call to trigger this event, so what we are
        // doing here is simply making sure that the events returns the right information.
        $course = $this->getDataGenerator()->create_course();
        $params = array(
            'context' => \context_course::instance($course->id)
        );
        $event = \gradeexport_ods\event\grade_exported::create($params);
        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);
        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\gradeexport_ods\event\grade_exported', $event);
        $this->assertEquals(\context_course::instance($course->id), $event->get_context());
        $this->assertEquals('ods', $event->get_export_type());
    }
}
