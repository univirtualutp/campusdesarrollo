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

namespace qtype_ddwtos;

use question_answer;
use question_bank;
use question_hint_with_parts;
use question_possible_response;

defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot . '/question/engine/tests/helpers.php');
require_once($CFG->dirroot . '/question/type/ddwtos/tests/helper.php');


/**
 * Unit tests for the drag-and-drop words into sentences question definition class.
 *
 * @package   qtype_ddwtos
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class question_type_test extends \question_testcase {
    /** @var qtype_ddwtos instance of the question type class to test. */
    protected $qtype;

    protected function setUp(): void {
        $this->qtype = question_bank::get_qtype('ddwtos');;
    }

    protected function tearDown(): void {
        $this->qtype = null;
    }

    public function assert_same_xml($expectedxml, $xml) {
        $this->assertEquals(str_replace("\r\n", "\n", $expectedxml),
                str_replace("\r\n", "\n", $xml));
    }

    /**
     * Get some test question data.
     *
     * @return object the data to construct a question like
     * {@link qtype_ddwtos_test_helper::make_ddwtos_question_fox()}.
     */
    protected function get_test_question_data() {
        global $USER;

        $dd = new \stdClass();
        $dd->id = 0;
        $dd->category = 0;
        $dd->contextid = 0;
        $dd->parent = 0;
        $dd->questiontextformat = FORMAT_HTML;
        $dd->generalfeedbackformat = FORMAT_HTML;
        $dd->defaultmark = 1;
        $dd->penalty = 0.3333333;
        $dd->length = 1;
        $dd->stamp = make_unique_id_code();
        $dd->status = \core_question\local\bank\question_version_status::QUESTION_STATUS_READY;
        $dd->version = 1;
        $dd->versionid = 0;
        $dd->questionbankentryid = 0;
        $dd->idnumber = null;
        $dd->timecreated = time();
        $dd->timemodified = time();
        $dd->createdby = $USER->id;
        $dd->modifiedby = $USER->id;

        $dd->name = 'Drag-and-drop words into sentences question';
        $dd->questiontext = 'The [[1]] brown [[2]] jumped over the [[3]] dog.';
        $dd->generalfeedback = 'This sentence uses each letter of the alphabet.';
        $dd->qtype = 'ddwtos';

        $dd->options = new \stdClass();
        $dd->options->shuffleanswers = true;

        \test_question_maker::set_standard_combined_feedback_fields($dd->options);

        $dd->options->answers = array(
            (object) array('answer' => 'quick', 'feedback' =>
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"1";s:8:"infinite";i:0;}'),
            (object) array('answer' => 'fox', 'feedback' =>
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"2";s:8:"infinite";i:0;}'),
            (object) array('answer' => 'lazy', 'feedback' =>
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"3";s:8:"infinite";i:0;}'),
            (object) array('answer' => 'assiduous', 'feedback' =>
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"3";s:8:"infinite";i:0;}'),
            (object) array('answer' => 'dog', 'feedback' =>
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"2";s:8:"infinite";i:0;}'),
            (object) array('answer' => 'slow', 'feedback' =>
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"1";s:8:"infinite";i:0;}'),
        );

        return $dd;
    }

    public function test_name() {
        $this->assertEquals($this->qtype->name(), 'ddwtos');
    }

    public function test_can_analyse_responses() {
        $this->assertTrue($this->qtype->can_analyse_responses());
    }

    public function test_save_question() {
        $this->resetAfterTest();

        $syscontext = \context_system::instance();
        /** @var core_question_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $category = $generator->create_question_category(['contextid' => $syscontext->id]);

        $fromform = \test_question_maker::get_question_form_data('ddwtos', 'missingchoiceno');
        $fromform->category = $category->id . ',' . $syscontext->id;

        $question = new \stdClass();
        $question->category = $category->id;
        $question->qtype = 'ddwtos';
        $question->createdby = 0;

        $this->qtype->save_question($question, $fromform);
        $q = question_bank::load_question($question->id);
        // We just want to verify that this does not cause errors,
        // but also verify some of the outcome.
        $this->assertEquals('The [[1]] sat on the [[2]].', $q->questiontext);
        $this->assertEquals([1 => 1, 2 => 1], $q->places);
        $this->assertEquals([1 => 1, 2 => 2], $q->rightchoices);
    }

    public function test_initialise_question_instance() {
        $qdata = $this->get_test_question_data();

        $expected = \test_question_maker::make_question('ddwtos');
        $expected->stamp = $qdata->stamp;
        $expected->idnumber = null;

        $q = $this->qtype->make_question($qdata);

        $this->assertEquals($expected, $q);
    }

    public function test_get_random_guess_score() {
        $q = $this->get_test_question_data();
        $this->assertEqualsWithDelta(0.5, $this->qtype->get_random_guess_score($q), 0.0000001);
    }

    public function test_get_possible_responses() {
        $q = $this->get_test_question_data();

        $this->assertEquals(array(
            1 => array(
                1 => new question_possible_response('quick', 1 / 3),
                2 => new question_possible_response('slow', 0),
                null => question_possible_response::no_response()),
            2 => array(
                1 => new question_possible_response('fox', 1 / 3),
                2 => new question_possible_response('dog', 0),
                null => question_possible_response::no_response()),
            3 => array(
                1 => new question_possible_response('lazy', 1 / 3),
                2 => new question_possible_response('assiduous', 0),
                null => question_possible_response::no_response()),
        ), $this->qtype->get_possible_responses($q));
    }

    public function test_xml_import() {
        $xml = '  <question type="ddwtos">
    <name>
      <text>A drag-and-drop question</text>
    </name>
    <questiontext format="moodle_auto_format">
      <text>Put these in order: [[1]], [[2]], [[3]].</text>
    </questiontext>
    <generalfeedback>
      <text>The answer is Alpha, Beta, Gamma.</text>
    </generalfeedback>
    <defaultgrade>3</defaultgrade>
    <penalty>0.3333333</penalty>
    <hidden>0</hidden>
    <shuffleanswers>1</shuffleanswers>
    <correctfeedback>
      <text><![CDATA[<p>Your answer is correct.</p>]]></text>
    </correctfeedback>
    <partiallycorrectfeedback>
      <text><![CDATA[<p>Your answer is partially correct.</p>]]></text>
    </partiallycorrectfeedback>
    <incorrectfeedback>
      <text><![CDATA[<p>Your answer is incorrect.</p>]]></text>
    </incorrectfeedback>
    <shownumcorrect/>
    <dragbox>
      <text>Alpha</text>
      <group>1</group>
    </dragbox>
    <dragbox>
      <text>Beta</text>
      <group>1</group>
    </dragbox>
    <dragbox>
      <text>Gamma</text>
      <group>1</group>
      <infinite/>
    </dragbox>
    <hint>
      <text>Try again.</text>
      <shownumcorrect />
    </hint>
    <hint>
      <text>These are the first three letters of the Greek alphabet.</text>
      <shownumcorrect />
      <clearwrong />
    </hint>
  </question>';
        $xmldata = xmlize($xml);

        $importer = new \qformat_xml();
        $q = $importer->try_importing_using_qtypes(
                $xmldata['question'], null, null, 'ddwtos');

        $expectedq = new \stdClass();
        $expectedq->qtype = 'ddwtos';
        $expectedq->name = 'A drag-and-drop question';
        $expectedq->questiontext = 'Put these in order: [[1]], [[2]], [[3]].';
        $expectedq->questiontextformat = FORMAT_MOODLE;
        $expectedq->generalfeedback = 'The answer is Alpha, Beta, Gamma.';
        $expectedq->defaultmark = 3;
        $expectedq->length = 1;
        $expectedq->penalty = 0.3333333;

        $expectedq->shuffleanswers = 1;
        $expectedq->correctfeedback = array('text' => '<p>Your answer is correct.</p>',
                'format' => FORMAT_MOODLE);
        $expectedq->partiallycorrectfeedback = array(
                'text' => '<p>Your answer is partially correct.</p>',
                'format' => FORMAT_MOODLE);
        $expectedq->shownumcorrect = true;
        $expectedq->incorrectfeedback = array('text' => '<p>Your answer is incorrect.</p>',
                'format' => FORMAT_MOODLE);

        $expectedq->choices = array(
            array('answer' => 'Alpha', 'choicegroup' => 1, 'infinite' => false),
            array('answer' => 'Beta', 'choicegroup' => 1, 'infinite' => false),
            array('answer' => 'Gamma', 'choicegroup' => 1, 'infinite' => true),
        );

        $expectedq->hint = array(
                array('text' => 'Try again.', 'format' => FORMAT_MOODLE),
                array('text' => 'These are the first three letters of the Greek alphabet.',
                        'format' => FORMAT_MOODLE));
        $expectedq->hintshownumcorrect = array(true, true);
        $expectedq->hintclearwrong = array(false, true);

        $this->assert(new \question_check_specified_fields_expectation($expectedq), $q);
        $this->assertEquals($expectedq->hint, $q->hint);
    }

    public function test_xml_export() {
        $qdata = new \stdClass();
        $qdata->id = 123;
        $qdata->contextid = \context_system::instance()->id;
        $qdata->idnumber = null;
        $qdata->qtype = 'ddwtos';
        $qdata->name = 'A drag-and-drop question';
        $qdata->questiontext = 'Put these in order: [[1]], [[2]], [[3]].';
        $qdata->questiontextformat = FORMAT_MOODLE;
        $qdata->generalfeedback = 'The answer is Alpha, Beta, Gamma.';
        $qdata->generalfeedbackformat = FORMAT_MOODLE;
        $qdata->defaultmark = 3;
        $qdata->length = 1;
        $qdata->penalty = 0.3333333;
        $qdata->status = \core_question\local\bank\question_version_status::QUESTION_STATUS_READY;

        $qdata->options = new \stdClass();
        $qdata->options->shuffleanswers = 1;
        $qdata->options->correctfeedback = '<p>Your answer is correct.</p>';
        $qdata->options->correctfeedbackformat = FORMAT_MOODLE;
        $qdata->options->partiallycorrectfeedback = '<p>Your answer is partially correct.</p>';
        $qdata->options->partiallycorrectfeedbackformat = FORMAT_MOODLE;
        $qdata->options->shownumcorrect = 1;
        $qdata->options->incorrectfeedback = '<p>Your answer is incorrect.</p>';
        $qdata->options->incorrectfeedbackformat = FORMAT_MOODLE;

        $qdata->options->answers = array(
            13 => new question_answer(13, 'Alpha', 0,
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"1";s:8:"infinite";b:0;}',
                    FORMAT_MOODLE),
            14 => new question_answer(14, 'Beta', 0,
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"1";s:8:"infinite";b:0;}',
                    FORMAT_MOODLE),
            15 => new question_answer(15, 'Gamma', 0,
                    'O:8:"stdClass":2:{s:9:"draggroup";s:1:"1";s:8:"infinite";b:1;}',
                    FORMAT_MOODLE),
        );

        $qdata->hints = array(
            1 => new question_hint_with_parts(1, 'Try again.', FORMAT_MOODLE, true, false),
            2 => new question_hint_with_parts(2,
                    'These are the first three letters of the Greek alphabet.',
                    FORMAT_MOODLE, true, true),
        );

        $exporter = new \qformat_xml();
        $xml = $exporter->writequestion($qdata);

        $expectedxml = '<!-- question: 123  -->
  <question type="ddwtos">
    <name>
      <text>A drag-and-drop question</text>
    </name>
    <questiontext format="moodle_auto_format">
      <text>Put these in order: [[1]], [[2]], [[3]].</text>
    </questiontext>
    <generalfeedback format="moodle_auto_format">
      <text>The answer is Alpha, Beta, Gamma.</text>
    </generalfeedback>
    <defaultgrade>3</defaultgrade>
    <penalty>0.3333333</penalty>
    <hidden>0</hidden>
    <idnumber></idnumber>
    <shuffleanswers>1</shuffleanswers>
    <correctfeedback format="moodle_auto_format">
      <text><![CDATA[<p>Your answer is correct.</p>]]></text>
    </correctfeedback>
    <partiallycorrectfeedback format="moodle_auto_format">
      <text><![CDATA[<p>Your answer is partially correct.</p>]]></text>
    </partiallycorrectfeedback>
    <incorrectfeedback format="moodle_auto_format">
      <text><![CDATA[<p>Your answer is incorrect.</p>]]></text>
    </incorrectfeedback>
    <shownumcorrect/>
    <dragbox>
      <text>Alpha</text>
      <group>1</group>
    </dragbox>
    <dragbox>
      <text>Beta</text>
      <group>1</group>
    </dragbox>
    <dragbox>
      <text>Gamma</text>
      <group>1</group>
      <infinite/>
    </dragbox>
    <hint format="moodle_auto_format">
      <text>Try again.</text>
      <shownumcorrect/>
    </hint>
    <hint format="moodle_auto_format">
      <text>These are the first three letters of the Greek alphabet.</text>
      <shownumcorrect/>
      <clearwrong/>
    </hint>
  </question>
';

        $this->assert_same_xml($expectedxml, $xml);
    }
}
