Moodle UCA - Local enrol users plugin
==================================
Local plugin which permits to enrol users in a course or to add users to groups with a .csv file.

Requirements
------------
- Moodle 3.9 or later.<br/>
  -> Tests made on Moodle 3.9 to 3.11.3 versions.


Installation
------------
1. Local plugin installation

- Git way:
> git clone https://github.com/andurif/moodle-local_import_users.git local/import_users

- Download way:
> Télécharger le zip depuis <a href="https://github.com/andurif/moodle-local_import_users/archive/refs/heads/main.zip">https://github.com/andurif/moodle-local_import_users/archive/refs/heads/main.zip</a>, dézipper l'archive dans le dossier local/ et renommer le si besoin le dossier en "import_users".

You can of course change the destination folder but this action will need you do changes in plugins and calles urls.

2. Then visit your Admin Notifications page to complete the installation.


Description / Working
------

This plugin gives 3 features:
<ul>
<li>enrol users to a cours with a .csv file.</li>
<li>users' massive add to a course group with a .csv file.</li>
<li>users' massive add to multiple course groups' with a .csv file with the possibility to create the missing groups.</li>
</ul>

#### => Enrol users to a course with a .csv file:
Accessible on: https://mymoodle.com/local/import_users/import.php?id=[COURSE_ID]

Thil page will permit to enrol users to a course with a .csv file and with the role defined in the plugin form.<br/>
The match with database's users will be made with the "idnumber" field and then on the "email" field if the previous is not in the given file.

#### => Add users to a group with a .csv file:
Accessible on: https://mymoodle.com/local/import_users/import_users_group.php?id=[COURSE_ID]

This page will permit to massively add users with a .csv file to a group selected in the list of the course groups.<br/>
The match with database's users will be made with the "idnumber" field and then on the "email" field if the previous is not in the given file.

#### => Massively add users to group(s) with a .csv file:
Accessible on: https://mymoodle.com/local/import_users/group_multienrol.php?id=[COURSE_ID]

This pasge will permit to massively add with a .csv file users to course groups.<br/>
The form also gives the possibility to enrol users not enrolled yet on this course and to create groups which are in the file and not in the course.<br>
The match with database's users will be made with the "idnumber" field and then on the "email" field if the previous is not in the given file and on the group name for these.

About us
------
<a href="https://www.uca.fr">Université Clermont Auvergne</a> - 2021
