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
 * File to potentially enrol users to several course groups.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once '../../config.php';
require_once './lib.php';
require_once $CFG->dirroot . '/enrol/locallib.php';
require_once "group_multienrol_form.php";

$id = required_param('id', PARAM_INT); // Course id.
$course = get_course($id);
$context = context_course::instance($course->id, MUST_EXIST);
$manager = new course_enrolment_manager($PAGE, $course);
$submit_url = new moodle_url('/local/import_users/group_multienrol.php', array('id' => $course->id));

require_login($course);
require_capability('moodle/course:managegroups', $context);
require_capability('local/import_users:multienrolgroup', $context);

$PAGE->requires->jquery();
$PAGE->set_pagelayout('course');
$PAGE->set_url(new moodle_url('/local/import_users/group_multienrol.php', array('id' => $course->id)));
$PAGE->set_title(get_string('coursetitle', 'moodle', array('course' => $course->fullname)));
$PAGE->set_heading($PAGE->title);
$PAGE->navbar->add(get_string('group_multienrol:title', 'local_import_users'));

$form = new group_multienrol_form($submit_url);

echo $OUTPUT->header();

if ($form->is_cancelled()) {
    // Cancel the form.
    redirect($submit_url);
    exit;
} else {
    if ($datas = $form->get_data()) {
        // Get the from datas.
        if ($datas->submitbutton) {
            $content = $form->get_file_content('importfile');
            $csv = str_getcsv($content, "\n");
            $userList = array("ok" => array(), "ko" => array());
            $index = 0;

            if ($datas->target == "all") {
                $enrol_plugin = enrol_get_plugin('manual');
                $enrolid = $DB->get_record('enrol', array('enrol' => 'manual', 'courseid' => $course->id), '*', MUST_EXIST);
            }

            foreach ($csv as $row) {
                $row = str_getcsv($row, $datas->delimiter);
                $index++;

                if (!is_numeric($row[2]) && !empty($row[2])) {
                    // We pass to the next line if the given idnumber is not correct.
                    continue;
                }

                if (empty($row[4])) {
                    // We pass to the next line if there is no given group in this line.
                    continue;
                } else {
                    // Explode the datas to get all the groups.
                    $groups = explode($datas->delimiter_group, $row[4]);
                }

                $user = false;
                if (is_numeric($row[2])) {
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
                } elseif (!empty($row[3])) {
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

                if (is_enrolled($context, $user)) {
                    group_multienrol($groups, $user, $course, $datas->create_groups_not_existing != false);
                } else {
                    if ($datas->target == "all") {
                        try {
                            $enrol_plugin->enrol_user($enrolid, $user->id, $datas->roleid);
                            echo '<div id="flashbag" class="alert alert-success alert-dismissible" role="alert">' . sprintf(get_string('group_multienrol:user_enrolled', 'local_import_users'), fullname($user)) . '</div>';
                            group_multienrol($groups, $user, $course, $datas->create_groups_not_existing != false);
                            continue;
                        } catch (Exception $exc) {
                            echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . $exc->getMessage() . '</div>';
                            continue;
                        }
                    } else {
                        echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . sprintf(get_string('group_multienrol:user_unenrolled', 'local_import_users'), fullname($user)) . '</div>';
                    }
                }
            }

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
