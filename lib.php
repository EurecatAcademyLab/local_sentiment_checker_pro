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
 * Lib and auxiliar functions.
 *
 * @package     local_survey_intelligence
 * @author      2023 Aina Palacios, Laia Subirats, Magali Lescano, Alvaro Martin, JuanCarlo Castillo, Santi Fort
 * @copyright   2022 Eurecat.org <dev.academy@eurecat.org>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$isgest = isguestuser();


if (!$isgest && isloggedin()) {
    /**
     * Insert a link to index.php on the site front page navigation menu.
     * @param navigation_node $frontpage Node representing the front page in the navigation tree.
     */
    function local_survey_intelligence_extend_navigation_frontpage(navigation_node $frontpage) {
        $frontpage->add(
            get_string('pluginname', 'local_survey_intelligence'),
            new moodle_url('/local/survey_intelligence/index.php')
        );
    }
}

if (!$isgest && isloggedin()) {
    /**
     * Insert a link to index.php on the site front page navigation menu.
     * @param navigation_node $frontpage Node representing the front page in the navigation tree.
     */
    function local_survey_intelligence_extend_navigation_user(navigation_node $frontpage) {
        $frontpage->add(
            get_string('pluginname', 'local_survey_intelligence'),
            new moodle_url('/local/survey_intelligence/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            null,
            new pix_icon('t/message', '')
        );
    }
}

if (get_config('local_survey_intelligence', 'showinnavigation') && !$isgest && isloggedin()) {

    /**
     * Add link to index.php into navigation drawer.
     * Admin decide if show it or not.
     * @param global_navigation $root Node representing the global navigation tree.
     */
    function local_survey_intelligence_extend_navigation(global_navigation $root) {

        $node = navigation_node::create(
            get_string('pluginname', 'local_survey_intelligence'),
            new moodle_url('/local/survey_intelligence/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            null,
            new pix_icon('t/message', '')
        );
        $node->showinflatnavigation = true;

        $root->add_node($node);
    }

}
