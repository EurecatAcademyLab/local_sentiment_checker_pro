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
 * Connected before plugins.
 *
 * @package     local_survey_intelligence
 * @author      2023 Aina Palacios, Laia Subirats, Magali Lescano, Alvaro Martin, JuanCarlo Castillo, Santi Fort
 * @copyright   2022 Eurecat.org <dev.academy@eurecat.org>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$page = new moodle_page();
$page->requires->js('/local/survey_intelligence/amd/woocomerceintelligence.js');

/**
 * This function get data from config settings and connect with js function.
 * @return Void.
 */
function call_woocomerce_intelligence() {

    $apikey = get_config('local_survey_intelligence', 'apikey');
    $productid = get_config('local_survey_intelligence', 'productid');
    $email = get_config('local_survey_intelligence', 'email');

    $data = array("apikey" => $apikey, "productid" => $productid, 'email' => $email);
    global $PAGE;
    $PAGE->requires->js('/local/survey_intelligence/amd/woocomerceintelligence.js');
    $PAGE->requires->js_init_call('woocommerce_api_active_intelligence', $data);
    call_woocomerce_status_intelligence();
    call_woocomerce_status_intelligence();
}

/**
 * This function get data from config settings and confirm the status.
 * @return Void.
 */
function call_woocomerce_status_intelligence() {
    global $DB;

    $apikey = get_config('local_survey_intelligence', 'apikey');
    $productid = get_config('local_survey_intelligence', 'productid');
    $email = get_config('local_survey_intelligence', 'email');
    $privacysurvey = get_config('local_survey_intelligence', 'privacy');
    $plugin = 'survey_intelligence';

    $data = array(
        "apikey" => $apikey,
        "productid" => $productid,
        'email' => $email,
        'plugin' => $plugin,
        'privacy' => $privacysurvey,
    );
    global $PAGE;
    $PAGE->requires->js('/local/survey_intelligence/amd/woocomerceintelligence.js');
    $PAGE->requires->js_init_call('woocommerce_api_status_intelligence', $data);
}

/**
 * This function get data the table config plugins and get some values
 * @return Array $data with most of the get config data.
 */
function get_headers_call_intelligence() {
    return   $data = [
        'name' => get_config('local_survey_intelligence', 'name'),
        'email' => get_config('local_survey_intelligence', 'email'),
        'apikey' => get_config('local_survey_intelligence', 'apikey'),
        'productid' => get_config('local_survey_intelligence', 'productid'),
        'privacy' => get_config('local_survey_intelligence', 'privacy'),
        'hash' => get_config('local_survey_intelligence', 'hash'),
        'url' => get_config('local_survey_intelligence', 'url'),
        'status' => get_config('local_survey_intelligence', 'status'),
        'plugin' => 'survey_intelligence',
    ];
}

