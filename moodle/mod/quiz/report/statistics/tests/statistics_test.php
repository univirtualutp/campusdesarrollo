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
 * Unit tests for (some of) /question/engine/statistics.php
 *
 * @package   quiz_statistics
 * @category  test
 * @copyright 2008 Jamie Pratt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quiz_statistics;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/mod/quiz/report/reportlib.php');

class testable_all_calculated_for_qubaid_condition extends \core_question\statistics\questions\all_calculated_for_qubaid_condition {

    /**
     * Disabling caching in tests so we are always sure to force the calculation of stats right then and there.
     *
     * @param qubaid_condition $qubaids
     */
    public function cache($qubaids) {

    }
}

/**
 * Test helper subclass of question_statistics
 *
 * @copyright 2010 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class testable_question_statistics extends \core_question\statistics\questions\calculator {

    /**
     * @var stdClass[]
     */
    protected $lateststeps;

    protected $statscollectionclassname = '\quiz_statistics\testable_all_calculated_for_qubaid_condition';

    public function set_step_data($states) {
        $this->lateststeps = $states;
    }

    protected function get_random_guess_score($questiondata) {
        return 0;
    }

    /**
     * @param $qubaids qubaid_condition is ignored in this test
     * @return array with two items
     *              - $lateststeps array of latest step data for the question usages
     *              - $summarks    array of total marks for each usage, indexed by usage id
     */
    protected function get_latest_steps($qubaids) {
        $summarks = [];
        $fakeusageid = 0;
        foreach ($this->lateststeps as $step) {
            // The same 'sumgrades' field is available in step data for every slot, we will ignore all slots but slot 1.
            // The step for slot 1 is always the first one in the csv file for each usage, we will use that to separate steps from
            // each usage.
            if ($step->slot == 1) {
                $fakeusageid++;
                $summarks[$fakeusageid] = $step->sumgrades;
            }
            unset($step->sumgrades);
            $step->questionusageid = $fakeusageid;
        }

        return [$this->lateststeps, $summarks];
    }

    protected function cache_stats($qubaids) {
        // No caching wanted for tests.
    }
}
/**
 * Unit tests for (some of) question_statistics.
 *
 * @copyright 2008 Jamie Pratt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class statistics_test extends \basic_testcase {
    /** @var testable_all_calculated_for_qubaid_condition object created to test class. */
    protected $qstats;

    public function test_qstats() {
        global $CFG;
        // Data is taken from randomly generated attempts data generated by
        // contrib/tools/generators/qagenerator/.
        $steps = $this->get_records_from_csv(__DIR__.'/fixtures/mdl_question_states.csv');
        // Data is taken from questions mostly generated by
        // contrib/tools/generators/generator.php.
        $questions = $this->get_records_from_csv(__DIR__.'/fixtures/mdl_question.csv');
        $calculator = new testable_question_statistics($questions);
        $calculator->set_step_data($steps);
        $this->qstats = $calculator->calculate(null);

        // Values expected are taken from contrib/tools/quiz_tools/stats.xls.
        $facility = [0, 0, 0, 0, null, null, null, 41.19318182, 81.36363636,
            71.36363636, 65.45454545, 65.90909091, 36.36363636, 59.09090909, 50,
            59.09090909, 63.63636364, 45.45454545, 27.27272727, 50];
        $this->qstats_q_fields('facility', $facility, 100);
        $sd = [0, 0, 0, 0, null, null, null, 1912.733589, 251.2738111,
            322.6312277, 333.4199022, 337.5811591, 492.3659639, 503.2362797,
            511.7663157, 503.2362797, 492.3659639, 509.6471914, 455.8423058, 511.7663157];
        $this->qstats_q_fields('sd', $sd, 1000);
        $effectiveweight = [0, 0, 0, 0, 0, 0, 0, 26.58464457, 3.368456046,
            3.253955259, 7.584083694, 3.79658376, 3.183278505, 4.532356904,
            7.78856243, 10.08351572, 8.381139345, 8.727645713, 7.946277111, 4.769500946];
        $this->qstats_q_fields('effectiveweight', $effectiveweight);
        $discriminationindex = [null, null, null, null, null, null, null,
            25.88327077, 1.170256965, -4.207816809, 28.16930644, -2.513606859,
            -12.99017581, -8.900638238, 8.670004606, 29.63337745, 15.18945843,
            16.21079629, 15.52451404, -8.396734802];
        $this->qstats_q_fields('discriminationindex', $discriminationindex);
        $discriminativeefficiency = [null, null, null, null, null, null, null,
            27.23492723, 1.382386552, -4.691171307, 31.12404354, -2.877487579,
            -17.5074184, -10.27568922, 10.86956522, 34.58997279, 17.4790556,
            20.14359793, 22.06477733, -10];
        $this->qstats_q_fields('discriminativeefficiency', $discriminativeefficiency);
    }

    public function qstats_q_fields($fieldname, $values, $multiplier=1) {
        foreach ($this->qstats->get_all_slots() as $slot) {
            $value = array_shift($values);
            if ($value !== null) {
                $this->assertEqualsWithDelta($value, $this->qstats->for_slot($slot)->{$fieldname} * $multiplier, 1E-6);
            } else {
                $this->assertEquals($value, $this->qstats->for_slot($slot)->{$fieldname} * $multiplier);
            }
        }
    }

    public function get_fields_from_csv($line) {
        $line = trim($line);
        $items = preg_split('!,!', $line);
        $cnt = count($items);
        for ($key = 0; $key < $cnt; $key++) {
            if ($items[$key]!='') {
                if ($start = ($items[$key][0]=='"')) {
                    $items[$key] = substr($items[$key], 1);
                    while (!$end = ($items[$key][strlen($items[$key])-1]=='"')) {
                        $item = $items[$key];
                        unset($items[$key]);
                        $key++;
                        $items[$key] = $item . ',' . $items[$key];
                    }
                    $items[$key] = substr($items[$key], 0, strlen($items[$key])-1);
                }

            }
        }
        return $items;
    }

    public function get_records_from_csv($filename) {
        $filecontents = file($filename, FILE_IGNORE_NEW_LINES);
        $records = [];
        // Skip the first line containing field names.
        $keys = $this->get_fields_from_csv(array_shift($filecontents));
        while (null !== ($line = array_shift($filecontents))) {
            $data = $this->get_fields_from_csv($line);
            $arraykey = reset($data);
            $object = new \stdClass();
            foreach ($keys as $key) {
                $value = array_shift($data);
                if ($value !== null) {
                    $object->{$key} = $value;
                } else {
                    $object->{$key} = '';
                }
            }
            $records[$arraykey] = $object;
        }
        return $records;
    }
}
