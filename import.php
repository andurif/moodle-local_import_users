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
require_once './lib.php';
require_once "import_form.php";

$formatters = [
    'csv' => 'formatCSVFile',
    'txt' => 'formatCSVFile',
];

$id = required_param('id', PARAM_INT); // Course id.
$course = get_course($id);
$context = context_course::instance($course->id, MUST_EXIST);
$manager = new course_enrolment_manager($PAGE, $course);
$submit_url = new moodle_url('/local/import_users/import.php', array('id' => $course->id));

require_login($course);

$PAGE->requires->jquery();

$PAGE->set_pagelayout('course');
$PAGE->set_url(new moodle_url('/local/import_users/import.php', array('id' => $course->id)));
$PAGE->set_title(get_string('coursetitle', 'moodle', array('course' => $course->fullname)));
$PAGE->set_heading($PAGE->title);
$PAGE->navbar->add(get_string('import', 'local_import_users'));

$form = new import_form($submit_url);

echo $OUTPUT->header();

if ($form->is_cancelled()) {
    // Cancel the form.
    redirect($submit_url);
    exit;
} else {
    if ($datas = $form->get_data()) {
        if ($datas->submitbutton) {
            $extension = pathinfo($form->get_new_filename('importfile'), PATHINFO_EXTENSION);

            $data = [];
            $content = $form->get_file_content('importfile');
            $data = str_getcsv($content, "\n");
            $role = $DB->get_record('role', array('id' => $form->get_data()->roleid), '*', MUST_EXIST);
            $rolename = ($role->name) ? $role->name : $role->shortname;
            $nb = 0;
            foreach ($data as $row) {
                $row = str_getcsv($row, ";");
                if (!is_numeric($row[2]) && !empty($row[2])) {
                    // Next iteration if the ref column is not a numeric value.
                    continue;
                }
                if (!empty($row[2])) {
                    try {
                        // We search the user with this idnumber. We only take active users (suspended = 0).
                        $user = $DB->get_record('user', array('idnumber' => $row[2], 'suspended' => 0), '*');
                        if (!$user) {
                            echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . sprintf(get_string('user_not_found_idnumber', 'local_import_users'), $row[2]) . '</div>';
                            continue;
                        }
                    } catch (Exception $exc) {
                        echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . $exc->getMessage() . '</div>';
                        continue;
                    }
                } else {
                    try {
                        // We search the user with this email address. We only take active users (suspended = 0).
                        $user = $DB->get_record('user', array('email' => $row[3], 'suspended' => 0), '*');
                        if (!$user) {
                            echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . sprintf(get_string('user_not_found_email', 'local_import_users'), $row[3]) . '</div>';
                            continue;
                        }
                    } catch (Exception $exc) {
                        echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . $exc->getMessage() . '</div>';
                        continue;
                    }
                }

                if ($user != null && $user->id != 0) {
                    try {
                        // We check if the user is already enrolled on the course.
                        if (!is_enrolled($context, $user)) {
                            // Get the enrol manual plugin and the enrol instance.
                            $enrol_plugin = enrol_get_plugin('manual');
                            $enrolid = $DB->get_record('enrol', array('enrol' => 'manual', 'courseid' => $course->id), '*', MUST_EXIST);
                            // We add an user_enrolment line which corresponds to the enrol instance.
                            $enrol_plugin->enrol_user($enrolid, $user->id, $role->id);
                            $nb++;

                            echo '<div id="flashbag" class="alert alert-success alert-dismissible" role="alert">' . sprintf(get_string('confirm_enrol_msg', 'local_import_users'), fullname($user), $rolename) . '</div>';
                        } else {
                            echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . sprintf(get_string('already_enrol_msg', 'local_import_users'), fullname($user), $rolename) . '</div>';
                        }
                    } catch (Exception $exc) {
                        echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . $exc->getMessage() . '</div>';
                    }
                } else {
                    echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . get_string('no_user_found', 'local_import_users') . '</div>';
                }
            }

            // We displays a message with imports done or not.
            $msg = ($nb == 0) ? get_string('no_user_imported', 'local_uca_enrol') : sprintf(get_string('users_imported_count', 'local_import_users'), $nb);
            echo '<div id="flashbag" class="alert alert alert-dismissible" role="alert">' . $msg . '</div>';

            // Redirect buttons display.
            $course_url = new moodle_url('/course/view.php', array("id" => $course->id));
            $users_url = new moodle_url('/user/index.php', array("id" => $course->id));

            echo '<div style="text-align: center">
                <a href="' . $users_url . '" class="btn btn-secondary">' . get_string('enrolled_users', 'local_import_users') . '</a>
                <a href="' . $submit_url . '" class="btn btn-secondary">' . get_string('new_enrol', 'local_import_users') . '</a>
                <a href="' . $course_url . '" class="btn btn-secondary">' . get_string('returntocourse', 'block_completionstatus') . '</a>
            </div>';
        }
    } else {
        // Form display.
        $form->display();
    }
}

echo $OUTPUT->footer();
