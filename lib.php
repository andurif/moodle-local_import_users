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
 * Module functions definitions.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Search users in the database from the given .csv file content.
 * @param $content the content of the .csv file.
 * @return array array with an "ok" entry with users found in the database and
 *              with an "ko" entry with users not found in the database.
 */
function process_users_from_file($content)
{
    global $DB;

    $csv = str_getcsv($content, "\n");
    $userList = ["ok" => [], "ko" => []];
    $index = 0;
    foreach ($csv as $row) {
        $row = str_getcsv($row, ";");
        $index++;

        if ($index == 1) {
            continue;
        }

        $user = false;

        if (is_numeric($row[2])) {
            // We search the user with this idnumber. We only take active users (suspended = 0).
            $user = $DB->get_record('user', array('idnumber' => $row[2], 'suspended' => 0), '*', IGNORE_MISSING);
        } elseif (!empty($row[3])) {
            // We search the user with this email address. We only take active users (suspended = 0).
            $user = $DB->get_record('user', array('email' => $row[3], 'suspended' => 0), '*', IGNORE_MISSING);
        }

        if ($user == false) {
            $userList["ko"][] = $index;
        } else {
            $userList['ok'][] = $user;
        }
    }

    return $userList;
}

/**
 * Function to enrol the given user to several course groups.
 * @param $groups the list of groups.
 * @param $user the user to add/enrol to the course.
 * @param $course the course.
 * @param $create_group_not_existing boolean indicate if we need to create the group if it is not exists in the course.
 */
function group_multienrol($groups, $user, $course, $create_group_not_existing = false)
{
    global $DB;
    foreach ($groups as $gr) {
        try {
            enrol_user($gr, $user, $course->id, $create_group_not_existing);
        } catch (Exception $exc) {
            echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . $exc->getMessage() . '</div>';
            continue;
        }
    }
}

/**
 * Function to add the given user in the group with the given name.
 * @param $group_name the group name.
 * @param $user the user.
 * @param $course_id the course id
 * @param $create_groupe_not_existing boolean indicate if we need to create the group if it is not exists in the course.
 * @throws Exception
 */
function enrol_user($group_name, $user, $course_id, $create_groupe_not_existing)
{
    global $DB;
    try {
        if (!empty($group_name)) {
            $group = $DB->get_record('groups', array('courseid' => $course_id, 'name' => utf8_encode($group_name)), '*', MUST_EXIST);
            if (groups_add_member($group->id, $user->id)) {
                echo '<div id="flashbag" class="alert alert-success alert-dismissible" role="alert">' . sprintf(get_string('group_multienrol:ok', 'local_import_users'), fullname($user), $group->name) . '</div>';
            } else {
                echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert">' . sprintf(get_string('group_multienrol:ko', 'local_import_users'), fullname($user), $group->name) . '</div>';
            }
        }

    } catch (Exception $exc) {
        if (groups_get_group_by_name($course_id, $group_name) === false) {
            if ($create_groupe_not_existing) {
                $data = new stdClass();
                $data->name = $group_name;
                $data->courseid = $course_id;
                try {
                    $groupId = groups_create_group($data);

                } catch (Exception $exc) {
                    throw $exc;
                }
                if ($groupId) {
                    echo '<div id="flashbag" class="alert alert-success alert-dismissible" role="alert"> ' . sprintf(get_string('group_multienrol:group_create_ok', 'local_import_users'), $group_name) . '</div>';
                    enrol_user($group_name, $user, $course_id, $create_groupe_not_existing);
                } else {
                    echo '<div id="flashbag" class="alert alert-danger alert-dismissible" role="alert"> ' . sprintf(get_string('group_multienrol:group_create_ko', 'local_import_users'), $group_name) . '</div>';
                    throw $exc;
                }
            } else {
                throw new Exception(sprintf(get_string('group_multienrol:group_ko', 'local_import_users'), $group_name));
            }

        } else {
            throw $exc;
        }

    }
}

/**
 * Function to add actions links in the course administration menu.
 * @param settings_navigation $settingsnav the navigation.
 * @param context $context the context.
 * @throws coding_exception
 * @throws moodle_exception
 */
function local_import_users_extend_settings_navigation(settings_navigation $settingsnav, context $context)
{
    $addnode = $context->contextlevel === 50;
    $courseid = $context->instanceid;
    // Find the course settings node using the 'courseadmin' key.
    $coursesettingsnode = $settingsnav->find('courseadmin', null);

    $addnodeimport = $addnode && has_capability('moodle/course:managegroups', $context)
        && has_capability('local/import_users:import', $context);
    if ($addnodeimport) {
        $urltext = get_string('import', 'local_import_users');
        $url = new moodle_url('/local/import_users/import.php', ['id' => $courseid] );

        $node = $coursesettingsnode->create(
            $urltext,
            $url,
            navigation_node::NODETYPE_LEAF,
            null,
            'localimportusers',
            null
        );

        $coursesettingsnode->add_node($node);
    }

    $groups = groups_get_course_data($courseid);
    $addnodeimportgroup = $addnode && count($groups->groups) > 0 && has_capability('moodle/course:managegroups', $context)
        && has_capability('local/import_users:importusersgroup', $context);
    if ($addnodeimportgroup) {
        $urltext = get_string('import_users_group:title', 'local_import_users');
        $url = new moodle_url('/local/import_users/import_users_group.php', ['id' => $courseid] );

        $node = $coursesettingsnode->create(
            $urltext,
            $url,
            navigation_node::NODETYPE_LEAF,
            null,
            'localimportusersgroup',
            null
        );

        $coursesettingsnode->add_node($node);
    }

    $addnodemultienrol = $addnode && count($groups->groups) > 0 && has_capability('moodle/course:managegroups', $context)
        && has_capability('local/import_users:multienrolgroup', $context);
    if ($addnodemultienrol) {
        $urltext = get_string('group_multienrol:title', 'local_import_users');
        $url = new moodle_url('/local/import_users/group_multienrol.php', ['id' => $courseid] );

        $node = $coursesettingsnode->create(
            $urltext,
            $url,
            navigation_node::NODETYPE_LEAF,
            null,
            'localimportusersmulti',
            null
        );

        $coursesettingsnode->add_node($node);
    }
}