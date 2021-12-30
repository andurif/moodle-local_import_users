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
 * group_multienrol_form Form class.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once $CFG->libdir . '/formslib.php';

/**
 * Form class to potentially enrol users to several course groups.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 */
class group_multienrol_form extends moodleform
{
    public function definition()
    {
        global $COURSE;
        $mform = $this->_form;

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $targetslist = [
            'enrolled' => get_string('group_multienrol:target_enrolled', 'local_import_users'),
            'all' => get_string('allusers', 'core_search'),
        ];
        $mform->addElement('select', 'target', get_string('group_multienrol:target', 'local_import_users'), $targetslist);
        $mform->addHelpButton('target', 'group_multienrol:target', 'local_import_users');

        $coursecontext = context_course::instance($COURSE->id);
        $roles = get_assignable_roles($coursecontext);
        $roles = array_reverse($roles, true);
        $mform->addElement('select', 'roleid', get_string('import:select_role', 'local_import_users'), $roles);
        $mform->setDefault('roleid', get_config('enrol_cohort', 'roleid'));
        $mform->addHelpButton('roleid', 'group_multienrol:role', 'local_import_users', '', null);
        $mform->hideIf('roleid', 'target', 'neq', 'all');

        $mform->addElement('header', 'file_options', get_string('group_multienrol:options_file', 'local_import_users'));

        $delimiterslist = [';' => ';', ',' => ',', ':' => ':'];
        $mform->addElement('select', 'delimiter', get_string('separator', 'core_grades'), $delimiterslist);

        $delimitersgrouplist = ['|' => '|', '/t' => '/t'];
        $mform->addElement('select', 'delimiter_group', get_string('group_multienrol:delimiter', 'local_import_users'), $delimitersgrouplist);
        $mform->addHelpButton('delimiter_group', 'group_multienrol:delimiter', 'local_import_users');

        $mform->addElement('filepicker', 'importfile', get_string('select_file', 'local_import_users'), null, array(
            'maxbytes' => 0,
            'accepted_types' => array('.csv', '.txt'),
            'trusttext' => false,
        ));
        $mform->addHelpButton('importfile', 'select_file', 'local_import_users', '', null);
        $mform->addElement('advcheckbox', 'create_groups_not_existing', get_string('create_groups_not_existing', 'local_import_users'), ' ', [false, true]);
        $mform->addHelpButton('create_groups_not_existing', 'create_groups_not_existing', 'local_import_users', '', null);
        $mform->setDefault('create_groups_not_existing', false);

        $link = html_writer::link(new moodle_url('examples/example_gr.csv'), 'example.csv');
        $mform->addElement('static', 'examplecsv', get_string('download_example_csv', 'local_import_users'), $link);
        $mform->addHelpButton('examplecsv', 'download_example_csv', 'local_import_users');

        $this->add_action_buttons();
    }

    public function validation($data, $files)
    {
        return array();
    }
}
