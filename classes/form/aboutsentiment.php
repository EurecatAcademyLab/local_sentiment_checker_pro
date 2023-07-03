<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * About us - Eurecat dev
 *
 * @package     local_sentiment_checker
 * @author      2023 Aina Palacios, Laia Subirats, Magali Lescano, Alvaro Martin, JuanCarlo Castillo, Santi Fort
 * @copyright   2022 Eurecat.org <dev.academy@eurecat.org>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/lib/formslib.php');
require_once("$CFG->dirroot/enrol/locallib.php");

$idcourse = optional_param('idcourse', null, PARAM_INT);

/**
 * Class form to create a customisable filter or personal filter.
 */
class si_about_form extends moodleform {

    /**
     * Define the form.
     */
    public function definition() {
        global $OUTPUT;

        $output = '';
        // Start with the object form.
        $lab = 'https://lab.eurecatacademy.org';
        $eurecat = '<a href="'.$lab.'" target="_blank">'.get_string('eurecat', 'local_sentiment_checker').'</a>';

        $output .= html_writer::start_tag('div', ['class' => 'mt-5 d-flex']);
            $output .= html_writer::tag('h4', get_string('developed', 'local_sentiment_checker').' '.$eurecat);
            $output .= html_writer::empty_tag('img', array('src' => "pix/eurecat_academy_logo.png", 'style' => 'width: 5%'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div');

            $output .= html_writer::tag('h5', get_string('Describ', 'local_sentiment_checker'), ['class' => 'mt-5']);
            $output .= html_writer::tag('p', get_string('Describtion', 'local_sentiment_checker'));

            $output .= html_writer::tag('h6', get_string('more', 'local_sentiment_checker'), ['class' => 'mt-3']);
            $output .= html_writer::tag('p', get_string('moreinfo', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('moreinfo1', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('moreinfo2', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('moreinfo3', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('moreinfo4', 'local_sentiment_checker'), ['class' => 'mb-3']);

            $output .= html_writer::tag('h5', get_string('userprivate', 'local_sentiment_checker'), ['class' => 'mt-5']);
            $output .= html_writer::tag('p', get_string('userprivate1', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('userprivate2', 'local_sentiment_checker'));
            $gs = get_string('information', 'local_sentiment_checker');
            $urlprivacity = 'https://eurecat.org/en/privacy-policy';
            $privacity = '<a href="'.$urlprivacity.'" target="_blank"><small>'.$gs.'</small></a>';
            $output .= html_writer::tag('p',
                get_string('userprivate3', 'local_sentiment_checker').' '.$privacity, ['class' => 'mb-3']);

            $output .= html_writer::tag('h5', get_string('regard', 'local_sentiment_checker'), ['class' => 'mt-5']);
            $urlmoderation = 'https://platform.openai.com/docs/models/moderation';
            $urlmoderation = '<a href="'.$urlmoderation.'" target="_blank"><small>'.
            get_string('moderation', 'local_sentiment_checker').'</small></a>';
            $output .= html_writer::tag('p',
            get_string('regarding',
                'local_sentiment_checker').' '.$urlmoderation .' '. get_string('regarding1', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('regarding2', 'local_sentiment_checker'));
            $urlguides = 'https://platform.openai.com/docs/models/moderation';
            $urlguides = '<a href="'.$urlguides.'" target="_blank"><small>'.
            get_string('guides', 'local_sentiment_checker').'</small></a>';
            $output .= html_writer::tag('p', get_string('regarding3', 'local_sentiment_checker').' '. $urlguides);
            $output .= html_writer::tag('p', get_string('regarding4', 'local_sentiment_checker'), ['class' => 'mb-3']);

            $urlorg = 'https://eurecatacademy.org';
            $urlorg = '<a href="'.$urlorg.'" target="_blank"><small>'.get_string('eurecatorg',
                'local_sentiment_checker').'</small></a>';
            $output .= html_writer::tag('h5', get_string('academytitle', 'local_sentiment_checker'), ['class' => 'mt-5']);
            $output .= html_writer::tag('p', get_string('aboutus', 'local_sentiment_checker').' '.$urlorg);
            $output .= html_writer::tag('p', get_string('aboutus1', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('aboutus2', 'local_sentiment_checker'));
            $output .= html_writer::tag('p', get_string('aboutus3', 'local_sentiment_checker'));

        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Extend the form definition after data has been parsed.
     */
    public function definition_after_data() {
        global $USER, $CFG, $DB, $OUTPUT;
        $mform = $this->_form;
    }

    /**
     * Validate the form data.
     * @param array $usernew
     * @param array $files
     * @return array|bool
     */
    public function validation($usernew, $files) {
        global $CFG, $DB;
        return true;
    }
}

/**
 * You know.
 * @return String
 */
function get_api_sentiment() {
    return '1d7ff265efb59b5b12ad2b6716155c2f378afafa';
}
