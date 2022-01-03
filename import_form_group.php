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
 * import_form_group Form class.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir.'/formslib.php');

/**
 * Form class to import users into course groups.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 */
class import_form_group extends moodleform
{
    public function definition()
    {
        global $COURSE;
        $mform = $this->_form;

        $coursecontext = context_course::instance($COURSE->id);
        $groups = groups_get_all_groups($COURSE->id);
        //$groups=getCourseGroups($COURSE->id);

        $groupslist = array();
        if ($groups != null) {
            foreach($groups as $group) {
                $groupslist[$group->id] = $group->name;
            }
        }

        $mform->addElement('select', 'groupid', get_string('select_group', 'local_import_users'), $groupslist);
        //$mform->setDefault('roleid', enrol_get_plugin('cohort')->get_config('roleid'));
        $mform->addElement('filepicker', 'importfile', get_string('select_file', 'local_import_users'), null, array(
            'maxbytes'          => 0,
            'accepted_types'    => array('.csv', '.txt'),
            'trusttext'         => false,
        ));
        $mform->addHelpButton('importfile', 'select_file', 'local_import_users', '', null);
        $mform->addHelpButton('groupid', 'select_group', 'local_import_users', '', null);
        $mform->addRule('groupid', null, 'required', null, 'client');

        $link = html_writer::link(new moodle_url('examples/example.csv'), 'example.csv');
        $mform->addElement('static', 'examplecsv', get_string('download_example_csv', 'local_import_users'), $link);
        $mform->addHelpButton('examplecsv', 'download_example_csv', 'local_import_users');

        $this->add_action_buttons();
    }

    function validation($data, $files)
    {
        return array();
    }
}

?>