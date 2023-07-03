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
 * Index.
 *
 * @package     local_sentiment_checker
 * @author      2023 Aina Palacios, Laia Subirats, Magali Lescano, Alvaro Martin, JuanCarlo Castillo, Santi Fort
 * @copyright   2022 Eurecat.org <dev.academy@eurecat.org>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include config.php.
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once('./forumposts.php');
require_once('./showpost.php');
require_once('./selectorforms.php');
require_once('./sqlquery.php');
require_once('./header.php');
require_once('./graphs.php');

require_once($CFG->dirroot. '/local/sentiment_checker/classes/form/premiumformsentiment.php');
require_once($CFG->dirroot. '/local/sentiment_checker/classes/form/noactivesentiment.php');
require_once($CFG->dirroot. '/local/sentiment_checker/classes/form/about.php');
require_once($CFG->dirroot. '/local/sentiment_checker/classes/connected/query.php');

require_login();


// Globals.
global $CFG, $OUTPUT, $USER, $SITE, $PAGE;

$PAGE->requires->js(new moodle_url('/local/sentiment_checker/amd/getpremium.js'));
$PAGE->requires->css( new moodle_url($CFG->wwwroot . '/local/sentiment_checker/css/style.css'));

// Include our function library.
$pluginname = 'sentiment_checker';

$homeurl = new moodle_url('/');
require_login();

if (!is_siteadmin() && $datos->teacher == 0) {
    redirect($homeurl, "This feature is only available for site administrators.", 5);
}

// URL Parameters.
// There are none.

// Heading.
// --------------------------------------------.

$title = get_string('pluginname', 'local_'.$pluginname);
$heading = get_string('pluginname', 'local_'.$pluginname) . " " . get_string('pluginnameextra', 'local_'.$pluginname);
$url = new moodle_url('/local/'.$pluginname.'/');
if ($CFG->version >= 2013051400) { // Moodle 2.5+.
    $context = context_system::instance();
} else {
    $context = get_system_context();
}

$PAGE->set_pagelayout('admin');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading($heading);

if (!$site = get_site()) {
    error("Site isn't defined!");
}

if (!empty($USER->newadminuser)) {
    ignore_user_abort(true);
    $PAGE->set_course($SITE);
    $PAGE->set_pagelayout('maintenance');
} else {
    $PAGE->set_context(context_system::instance());
    $PAGE->set_pagelayout('admin');
}

$renderer = $PAGE->get_renderer('core_enrol');
$allowpremium = has_capability('local/sentiment_checker:view', $context);

$dform = new select_course();
$premium = new si_premium_form();
$about = new si_about_form();
$noactivesurvey = new noactive_survey_form();

$privacysurvey = $DB->get_record('config_plugins', array('plugin' => 'local_sentiment_checker', 'name' => 'privacy'));
$apikeychecksurvey = $DB->get_record('config_plugins', array('plugin' => 'local_sentiment_checker', 'name' => 'apikey'));
$emailsurvey = $DB->get_record('config_plugins', array('plugin' => 'local_sentiment_checker', 'name' => 'email'));
$productsurvey = $DB->get_record('config_plugins', array('plugin' => 'local_sentiment_checker', 'name' => 'productid'));


if (empty($emailsurvey) || strlen($emailsurvey->value) == 0 ||
$emailsurvey->value == '' || $emailsurvey->value == null || !$emailsurvey) {
    redirect (new moodle_url('/admin/settings.php?section=managelocalsentiment_checker'));
}
if (!$productsurvey || $productsurvey->value != 142 ) {
    redirect (new moodle_url('/admin/settings.php?section=managelocalsentiment_checker'));
}
if (!$privacysurvey || $privacysurvey->value == false) {
    redirect (new moodle_url('/admin/settings.php?section=managelocalsentiment_checker'));
}
if ( !$apikeychecksurvey || $apikeychecksurvey->value != 'aa7cda56d137325b560dc9d1136e5474d08ff5b9') {
    redirect (new moodle_url('/admin/settings.php?section=managelocalsentiment_checker'));
}

echo $OUTPUT->header();

$output = "";
call_woocomerce_status_intelligence();
// $statussurvey = $DB->get_record('config_plugins', array('plugin' => 'local_sentiment_checker', 'name' => 'status'));

$statussurvey = 1;
if ( $statussurvey == 1 ) {
    updatepost();

    $output .= html_writer::start_tag('div', ['id' => 'statusintelligence', 'class' => 'mb-3']);
    $output .= html_writer::end_tag('div');

    $courseselected = null;
    $thresholdneg = -0.3;
    $thresholdpos = 0.3;
    $onlybad = 0;
    $translation = 0;

    if ($fromform = $dform->get_data()) {
        require_sesskey();
        $courseselected = $fromform->course;
        $onlybad = $fromform->only_bad;
        $translation = $fromform->show_en;
        $thresholdneg = $fromform->thresholdNeg;
        $thresholdpos = $fromform->thresholdPos;

        $dform->display();

    } else {
        $dform->display();
    }

    $output .= html_header($courseselected);

    $output .= html_writer::start_tag('div', ['class' => 'pt-2']);
        $output .= html_writer::start_tag('ul', ["class" => 'nav nav-tabs', 'role' => "tablist"]);

            $output .= html_writer::start_tag('li', ['class' => 'nav-item waves-effect waves-light']);
                $output .= html_writer::tag('a', get_string('Posts', 'local_sentiment_checker'), ['class' => 'nav-link active',
                'data-toggle' => "tab", 'href' => "#postsTab"]);
                $output .= html_writer::end_tag('li');

                $output .= html_writer::start_tag('li', ['class' => 'nav-item waves-effect waves-light']);
                $output .= html_writer::tag(
                    'a',
                    get_string('Analytics', 'local_sentiment_checker'),
                    ['class' => 'nav-link', 'data-toggle' => "tab", 'href' => "#si_graph"]);
                $output .= html_writer::end_tag('li');

                $output .= html_writer::start_tag('li', ['class' => 'nav-item waves-effect waves-light']);
                $output .= html_writer::tag(
                    'a',
                    get_string('about', 'local_sentiment_checker'),
                    ['class' => 'nav-link', 'data-toggle' => "tab", 'href' => "#si_about"]);
                $output .= html_writer::end_tag('li');

                $output .= html_writer::end_tag('ul');
                $output .= html_writer::end_tag('div');
                // $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', ['class' => 'tab-content']);

                $output .= html_writer::start_tag('div', ['class' => 'tab-pane fade show active', 'id' => 'postsTab']);
                $output .= html_writer::start_tag('div', ['class' => 'p-1']);
                    $post = new Post_view($thresholdneg, $thresholdpos, $courseselected, $onlybad, $translation);
                    $output .= utf8_decode($post->printar());
                $output .= html_writer::end_tag('div');

                $output .= $OUTPUT->download_dataformat_selector(
                    get_string('userbulkdownload', 'admin'),
                    'downloadposts.php',
                    'download',
                    array('thN' => $thresholdneg, 'curseSelected' => $courseselected, 'onlyB' => $onlybad));


                $output .= html_writer::end_tag('div');


                $output .= html_writer::start_tag('div', ['class' => 'tab-pane fade', 'id' => 'si_graph']);
                $outputgraphs = graphposts($thresholdneg, $thresholdpos , $courseselected);
                $output .= $outputgraphs;
                $output .= html_writer::tag('i', '', ['class' => 'fa fa-print']);
                $output .= html_writer::tag(
                    'a',
                    '  '.
                    get_string('printAnalysis', 'local_sentiment_checker'),
                    [
                        'href' => '#',
                        'class' => 'mt-3 ',
                        'onclick' => 'print()',
                        'role' => 'button',
                    ]
                );
                $output .= html_writer::end_tag('div');


                    $output .= html_writer::start_tag('div', ['class' => 'tab-pane fade', 'id' => 'si_about']);
                            $output .= $about->definition();
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::end_tag('div');
} else {
    $output .= html_writer::start_tag('div');
    $output .= $noactivesurvey->definition();
    $output .= html_writer::end_tag('div');
}
                echo $output;

                echo $OUTPUT->footer();


