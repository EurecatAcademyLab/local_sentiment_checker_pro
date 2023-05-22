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
 * @package     local_survey_intelligence
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
        $eurecat = '<a href="'.$lab.'" target="_blank">'.get_string('eurecat', 'local_survey_intelligence').'</a>';

        $output .= html_writer::start_tag('div', ['class' => 'mt-5 d-flex']);
            $output .= html_writer::tag('h4', get_string('developed', 'local_survey_intelligence').' '.$eurecat);
            $output .= html_writer::empty_tag('img', array('src' => "pix/eurecat_academy_logo.png", 'style' => 'width: 5%'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div');

            $output .= html_writer::tag('h5', get_string('Describ', 'local_survey_intelligence'), ['class' => 'mt-5']);
            $output .= html_writer::tag('p', get_string('Describtion', 'local_survey_intelligence'));

            $output .= html_writer::tag('h6', get_string('more', 'local_survey_intelligence'), ['class' => 'mt-3']);
            $output .= html_writer::tag('p', get_string('moreinfo', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('moreinfo1', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('moreinfo2', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('moreinfo3', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('moreinfo4', 'local_survey_intelligence'), ['class' => 'mb-3']);

            $output .= html_writer::tag('h5', get_string('userprivate', 'local_survey_intelligence'), ['class' => 'mt-5']);
            $output .= html_writer::tag('p', get_string('userprivate1', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('userprivate2', 'local_survey_intelligence'));
            $gs = get_string('information', 'local_survey_intelligence');
            $urlprivacity = 'https://eurecat.org/en/privacy-policy';
            $privacity = '<a href="'.$urlprivacity.'" target="_blank"><small>'.$gs.'</small></a>';
            $output .= html_writer::tag('p',
                get_string('userprivate3', 'local_survey_intelligence').' '.$privacity, ['class' => 'mb-3']);

            $output .= html_writer::tag('h5', get_string('regard', 'local_survey_intelligence'), ['class' => 'mt-5']);
            $urlmoderation = 'https://platform.openai.com/docs/models/moderation';
            $urlmoderation = '<a href="'.$urlmoderation.'" target="_blank"><small>'.
            get_string('moderation', 'local_survey_intelligence').'</small></a>';
            $output .= html_writer::tag('p',
            get_string('regarding',
                'local_survey_intelligence').' '.$urlmoderation .' '. get_string('regarding1', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('regarding2', 'local_survey_intelligence'));
            $urlguides = 'https://platform.openai.com/docs/models/moderation';
            $urlguides = '<a href="'.$urlguides.'" target="_blank"><small>'.
            get_string('guides', 'local_survey_intelligence').'</small></a>';
            $output .= html_writer::tag('p', get_string('regarding3', 'local_survey_intelligence').' '. $urlguides);
            $output .= html_writer::tag('p', get_string('regarding4', 'local_survey_intelligence'), ['class' => 'mb-3']);

            $urlorg = 'https://eurecatacademy.org';
            $urlorg = '<a href="'.$urlorg.'" target="_blank"><small>'.get_string('eurecatorg',
                'local_survey_intelligence').'</small></a>';
            $output .= html_writer::tag('h5', get_string('academytitle', 'local_survey_intelligence'), ['class' => 'mt-5']);
            $output .= html_writer::tag('p', get_string('aboutus', 'local_survey_intelligence').' '.$urlorg);
            $output .= html_writer::tag('p', get_string('aboutus1', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('aboutus2', 'local_survey_intelligence'));
            $output .= html_writer::tag('p', get_string('aboutus3', 'local_survey_intelligence'));

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

