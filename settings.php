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
 * Settings.
 *
 * @package     local_survey_intelligence
 * @author      2023 Aina Palacios, Laia Subirats, Magali Lescano, Alvaro Martin, JuanCarlo Castillo, Santi Fort
 * @copyright   2022 Eurecat.org <dev.academy@eurecat.org>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/local/survey_intelligence/classes/connected/query.php');
require_once($CFG->libdir.'/adminlib.php');

// $hassiteconfig = true;

// if ($hassiteconfig) {
//     $ADMIN->add(
//         'localplugins',
//         new admin_category(
//             'local_survey_intelligence_settings',
//             new lang_string('pluginname', 'local_survey_intelligence')
//         )
//     );
//     $settingspage = new admin_settingpage(
//         'managelocalsurvey_intelligence',
//         new lang_string('manage', 'local_survey_intelligence')
//     );

//     if ($ADMIN->fulltree) {

//         // Show in navigation.
//         $settingspage->add(new admin_setting_configcheckbox(
//             'local_survey_intelligence/showinnavigation',
//             new lang_string('showinnavigation', 'local_survey_intelligence'),
//             new lang_string('showinnavigation_desc', 'local_survey_intelligence'),
//             1
//         ));

//         // User name.
//         $namesettingsintelligence = new admin_setting_configtext(
//             'local_survey_intelligence/name',
//             new lang_string('name', 'local_survey_intelligence'),
//             new lang_string('name_des', 'local_survey_intelligence'),
//             null,
//             PARAM_TEXT,
//             null,
//             [
//                 'pattern' => '/^\w([\w\.%+-]*@[\w.-]+\.[a-zA-Z]{2,}$)/',
//                 'required' => true
//             ]
//         );

//         if (!$namesettingsintelligence->get_setting()) {
//             // Show error on settings page.
//             $PAGE->navbar->add(get_string('manage', 'local_survey_intelligence'));
//         }

//         $settingspage->add($namesettingsintelligence);

//         // Email.
//         $emailsettingsintelligence = new admin_setting_configtext(
//             'local_survey_intelligence/email',
//             new lang_string('email', 'local_survey_intelligence'),
//             new lang_string('email_des', 'local_survey_intelligence'),
//             null,
//             PARAM_EMAIL,
//             null,
//             [
//                 'pattern' => '/^\w([\w\.%+-]*@[\w.-]+\.[a-zA-Z]{2,}$)/',
//                 'required' => true
//             ],
//             new lang_string('placeholder_text', 'local_survey_intelligence')
//         );

//         if (!$emailsettingsintelligence->get_setting()) {
//             // Show error on settings page.
//             $PAGE->navbar->add(get_string('manage', 'local_survey_intelligence'));
//         }

//         $settingspage->add($emailsettingsintelligence);

//         // Apikey Teams.
//         $apikeysettingsintelligence = new admin_setting_configtext(
//             'local_survey_intelligence/apikey',
//             new lang_string('apikey', 'local_survey_intelligence'),
//             new lang_string('apikey_des', 'local_survey_intelligence'),
//             'aa7cda56d137325b560dc9d1136e5474d08ff5b9',
//             PARAM_TEXT,
//             50,
//             'maxlength="50"readonly'
//         );

//         $apikeysettingsintelligence->set_updatedcallback(call_woocomerce_intelligence());
//         $settingspage->add( $apikeysettingsintelligence );

//         // Product id.
//         $productidsettingsintelligence = new admin_setting_configtext(
//         'local_survey_intelligence/productid',
//         new lang_string('productid', 'local_survey_intelligence'),
//         new lang_string('productid_des', 'local_survey_intelligence'),
//         142,
//         PARAM_INT);

//         $settingspage->add($productidsettingsintelligence);

//         $privacyurl = new moodle_url('https://lab.eurecatacademy.org/privacy-policy-2');
//         $privacylink = \html_writer::link($privacyurl, get_string('privacy_policy', 'local_survey_intelligence'));
//         $settingspage->add(new admin_setting_configcheckbox(
//             'local_survey_intelligence/privacy',
//             new lang_string('privacy', 'local_survey_intelligence'),
//             new lang_string('privacy_des', 'local_survey_intelligence') . ' ' . $privacylink,
//             1
//         ));
//     }

//     $ADMIN->add('localplugins', $settingspage);
// }

