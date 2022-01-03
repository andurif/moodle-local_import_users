Moodle UCA - Plugin local d'import d'utilisateurs
==================================
Plugin local permettant d'importer des utilisateurs via un fichier .csv pour les inscrire à un cours ou les ajouter à un ou plusieurs groupes d'un cours.

Pré-requis
------------
- Moodle en version 3.9 ou plus récente.<br/>
  -> Tests effectués sur des versions 3.9 à 3.11.3 et avec une installation basique de moodle.


Installation
------------
1. Installation du plugin

- Avec git:
> git clone https://github.com/andurif/moodle-local_import_users.git local/import_users

- En téléchargement:
> Télécharger le zip depuis <a href="https://github.com/andurif/moodle-local_import_users/archive/refs/heads/main.zip">https://github.com/andurif/moodle-local_import_users/archive/refs/heads/main.zip</a>, dézipper l'archive dans le dossier local/ et renommer le si besoin le dossier en "import_users".

Vous pouvez bien sur changer le dossier dans lequel déposer le projet ou le nom du projet lui-même mais ces changements seront à reporter dans le code du plugin (notamment les urls).

2. Aller sur la page de Notifications pour terminer l'installation du plugin.


Présentation / Utilisation
------

Ce plugin possède 3 fonctionnalités:
<ul>
<li>l'inscription d'utilisateurs à un cours via un fichier .csv.</li>
<li>l'ajout en masse d'utilisateurs à un groupe d'un cours via un fichier .csv.</li>
<li>l'ajout en masse d'utilisateurs à plusieurs groupes via un fichier .csv avec possibilité de créer automatiquement les groupes manquants.</li>
</ul>

#### => Inscription d'utilisateurs à un cours via fichier .csv:
Accessible à l'adresse: https://mymoodle.com/local/import_users/import.php?id=COURSE_ID

Cette page permet d'inscrire via un fichier .csv plusieurs utilisateurs à un cours et avec le rôle défini dans le formulaire.<br/>
La correspondance avec les utilisateurs de la plateforme se ferra d'abord sur le champ "numéro d'identification" puis sur le champ "email" si le champ précédent n'est pas présent dans le fichier.

#### => Ajout d'utilisateurs à un groupe via fichier .csv:
Accessible à l'adresse: https://mymoodle.com/local/import_users/import_users_group.php?id=COURSE_ID

Cette page permet d'ajouter en massse via un fichier .csv plusieurs utilisateurs à un groupe sélectionné parmi la liste des groupes existant dans ce cours.<br/>
La correspondance avec les utilisateurs de la plateforme se ferra d'abord sur le champ "numéro d'identification" puis sur le champ "email" si le champ précédent n'est pas présent dans le fichier.

#### => Ajout en masse d'utilisateurs à un/des groupes via fichier .csv:
Accessible à l'adresse: https://mymoodle.com/local/import_users/group_multienrol.php?id=COURSE_ID

Cette page permet d'ajouter en massse via un fichier .csv plusieurs utilisateurs à des groupes du cours.<br/>
Le formulaire donnera également la possibilité d'inscrire les utilisateurs qui ne seraient pas inscrits à ce cours ainsi que de créér les groupes figurant dans le fichier et qui n'existeraient pas encore dans ce cours.<br/>
La correspondance avec les utilisateurs de la plateforme se ferra d'abord sur le champ "numéro d'identification" puis sur le champ "email" si le champ précédent n'est pas présent dans le fichier et sur le nom du groupe pour la partie groupe.

A propos
------
<a href="https://www.uca.fr">Université Clermont Auvergne</a> - 2021
