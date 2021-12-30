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
 * import_form Form class.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("$CFG->libdir/formslib.php");

/**
 * Form class to import users in the course.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 */
class import_form extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG, $COURSE;
        $mform = $this->_form;

        $coursecontext = context_course::instance($COURSE->id);
        $roles = get_assignable_roles($coursecontext);
        $roles = array_reverse($roles, true); // Descending default sortorder.

        $mform->addElement('select', 'roleid', get_string('import:select_role', 'local_import_users'), $roles);
        $mform->setDefault('roleid', get_config('enrol_cohort', 'roleid'));

        $link = html_writer::link(new moodle_url('examples/example.csv'), 'exemple.csv');
        $mform->addElement('static', 'examplecsv', get_string('download_example_csv', 'local_import_users'), $link);
        $mform->addHelpButton('examplecsv', 'download_example_csv', 'local_import_users');

        $mform->addElement('filepicker', 'importfile', get_string('import:select_file', 'local_import_users'), null, array(
            'maxbytes'          => 0,
            'accepted_types'    => array('.csv', '.txt'),
            'trusttext'         => false,
        ));
        $mform->addHelpButton('importfile', 'select_file', 'local_import_users', '', null);
        $mform->addHelpButton('roleid', 'select_role', 'local_import_users', '', null);

        $this->add_action_buttons();
    }

    function validation($data, $files)
    {
        return array();
    }
}