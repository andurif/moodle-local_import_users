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
 * Definition of the plugin capabilities.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$capabilities = array(
    'local/import_users:import' => array(
        'riskbitmask'   => RISK_SPAM,
        'captype'       => 'write',
        'contextlevel'  => CONTEXT_USER,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'teacher'        => CAP_ALLOW,
            'manager'        => CAP_ALLOW
        ),
    ),
    'local/import_users:importusersgroup' => array(
        'riskbitmask'   => RISK_SPAM,
        'captype'       => 'write',
        'contextlevel'  => CONTEXT_USER,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'teacher'        => CAP_ALLOW,
            'manager'        => CAP_ALLOW
        ),
    ),
    'local/import_users:multienrolgroup' => array(
        'riskbitmask'   => RISK_SPAM,
        'captype'       => 'write',
        'contextlevel'  => CONTEXT_USER,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'teacher'        => CAP_ALLOW,
            'manager'        => CAP_ALLOW
        ),
    )
);