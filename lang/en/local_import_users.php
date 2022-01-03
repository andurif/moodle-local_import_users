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
 * Plugin lang file: English.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Local plugin "Import users"';
$string['privacy:metadata'] = 'Le plugin local de création de cours custom n\'enregistre aucune donnée personnelle.';
$string['import'] = 'Enrol users with a file';
$string['confirm_enrol_msg'] = 'The user %s has been correctly enrolled with the role "%s".';
$string['already_enrol_msg'] = 'The user %s has already been enrolled.';
$string['no_user_found'] = 'Impossible to find this user in database.';
$string['users_imported_count'] = '%d utilisateurs viennent d\'être inscrits au cours.';
$string['enrolled_users'] = 'See enrolled users';
$string['new_enrol'] = 'Make a new enrol';
$string['no_user_imported'] = 'No users imported from this file.';
$string['users_group_imported_count'] = '%d new group members.';
$string['user_not_found_idnumber'] = 'User with idnumber %s not found so the user has not been enrolled.';
$string['user_not_found_email'] = 'User with email %s not found so the user has not been enrolled.';

$string['import:enrol'] = 'Import users';
$string['import:select_role'] = 'Enrol users as';
$string['select_role'] = 'the role';
$string['select_role_help'] = 'Role which will be given to these users in this course context. Warning, this role will be "manually" given to ALL your list\'s users found in database.';
$string['import:select_file'] = 'File containing users list';
$string['select_file'] = 'The file to upload';
$string['select_file_help'] = 'Delimited file containing all users you want to enrol to your course. Your file must follow this format <strong>Firstname;Lastname;IdNumber;EmailAddress;Others</strong> (IdNumber equals student id or employee id and will be used to get the correct user, if it is empty this correspondence will use the email address).';
$string['create_groups_not_existing'] = 'Create groups that do not exist';
$string['create_groups_not_existing_help'] = 'If the box is checked and groups that appear in the file to be uploaded do not exist, these will be automatically created. Otherwise the addition will be ignored.';

$string['download_example_csv'] = 'Example .csv file';
$string['download_example_csv_help'] = 'Example .csv file with an expected structure example';

$string['import_users_group_title'] = 'Import users to a group with a file';
$string['is_not_registered_to_the_course'] = " is not enrolled in the course";
$string['csv_line_unknown_users'] = "The following lines do not match with valid users in the system : ";
$string['select_group'] = "Choose group";
$string['select_group_help'] = 'Select a group to enrol users in. Warning, groups have to be created and users enrolled in course.';
$string['export_select_group'] = "Group to export";
$string['export_select_group_help'] = "Group of which you want to export members.";
$string['export_group_members'] = "Export a group members";
$string['no_members'] = "Export not possible: the selected group has no member.";
$string['groups_no_members'] = "Export not possible: none of this course's groups has member.";
$string['export_filename'] = "Export name";
$string['export_filename_help'] = "Chosen name of the export file. Required information to upload the export in your personal files. Warning, the extension .csv will be added to the chosen filename and spaces will be replaced by '_'.";

$string['group_multienrol:title'] = 'Group multi enrol';
$string['group_multienrol:menu'] = 'Multi enrol in groups with file';
$string['group_multienrol:target'] = 'Targeted users population';
$string['group_multienrol:target_help'] = 'Targeted users population:<ul>
                                        <li>Enrolled users: only enrolled users present in your file will be added to selected group(s).</li>
                                        <li>All users: if there are users in your file which are not enrolled to the course, they will be enrolled first and added to selected group(s) then.</li>
                                        </ul>';
$string['group_multienrol:target_enrolled'] = 'Only enrolled users';
$string['group_multienrol:role_help'] = 'Role you want to give to not yet enrolled users which are in your file (warning, this role will not be given to users which are already enrolled in this course).';
$string['group_multienrol:role'] = 'Role to give to new users.';
$string['group_multienrol:options_file'] = 'Import file options';
$string['group_multienrol:delimiter'] = 'Group delimiter';
$string['group_multienrol:delimiter_help'] = 'Delimiter used in your to distinct group names. Be careful if this character is used in a group name, it will be interpreted and the import may not be functional.';
$string['group_multienrol:ok'] = '%s added to the group called %s.';
$string['group_multienrol:ko'] = '%s was not add to the group called %s.';
$string['group_multienrol:group_create_ok'] = '%s group created.';
$string['group_multienrol:group_create_ko'] = '%s group was not be able to be created.';
$string['group_multienrol:group_ko'] = '%s group does not exist.';
$string['group_multienrol:user_enrolled'] = '%s has been enrolled in the course.';
$string['group_multienrol:user_unenrolled'] = '%s is not enrolled in the course.';
