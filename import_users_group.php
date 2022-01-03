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
 * Creation of the course.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once '../../config.php';
require_once '../../enrol/locallib.php';
require_once('./lib.php');
require_once('../../group/lib.php');
require_once("import_form_group.php");

$courseid      = required_param('id', PARAM_INT); // Course id.
$course  = $DB->get_record('course', array('id'=>$courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('moodle/course:managegroups', $context);

$PAGE->set_pagelayout('admin');
$PAGE->set_url(new moodle_url('/local/import_users/import_users_group.php', array('id' => $course->id)));
$PAGE->set_title(get_string('coursetitle', 'moodle', array('course' => $course->fullname)));
$PAGE->set_heading($PAGE->title);
$PAGE->navbar->add(get_string('import_users_group_title','local_import_users'));


echo $OUTPUT->header();
echo $OUTPUT->heading(sprintf(get_string('import_users_group_title','local_import_users'), $course->fullname));

$submit_url = new moodle_url('/local/import_users/import_users_group.php', array('id' => $course->id))."";
$mform = new import_form_group($submit_url);

// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    // Cancel the form.
    redirect($submit_url);
    exit;
} else {
    if ($fromform = $mform->get_data()) {
        // Get the form datas (file content and role to give).
        $groupid = $mform->get_data()->groupid;
        $content = $mform->get_file_content('importfile');

        $users = process_users_from_file($content);
        $nb = 0;
        $msg = "";

        foreach ($users['ok'] as $user) {
            if (is_enrolled($context, $user)) {
                if (true === groups_add_member($groupid, $user)) {
                    $nb++;
                }
            } else {
                // log !enrol
                $msg .= "<br>$user->firstname $user->lastname ($user->email)" . get_string('is_not_registered_to_the_course','local_import_users');
            }
        }

        if (!empty($users['ko'])) {
            $msg .= '<hr/><img src="../../pix/i/completion-auto-n.png"> ' . get_string('csv_line_unknown_users', 'local_import_users') . implode(',', $users['ko']);
        }
        
        if ($nb > 0) {
            $msg = sprintf(get_string('users_group_imported_count', 'local_import_users'), $nb) . '<br/><br/>' . $msg;
        } else {
            $msg = get_string('no_user_imported','local_import_users') . '<br/><br/>' . $msg;
        }

        echo '<div id="flashbag" class="alert alert alert-dismissible" role="alert">' . $msg . '</div>' ;

        // Redirect buttons display.
        $course_url = new moodle_url('/course/view.php', array("id" => $course->id));
        $users_url  = new moodle_url('/user/index.php', array("id" => $course->id));

        echo '<div style="text-align: center">
            <a href="' . $users_url . '" class="btn btn-secondary">' . get_string('enrolled_users', 'local_import_users') . '</a>
            <a href="' . $submit_url . '" class="btn btn-secondary">' . get_string('new_enrol', 'local_import_users') . '</a>
        </div>';
    } else {
        // Form display.
        $mform->display();
    }
}

echo $OUTPUT->footer();

?>