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
 * Plugin lang file: French.
 *
 * @package    local_import_users
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2021 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Plugin local d\'import d\'utilisateurs';
$string['privacy:metadata'] = 'Le plugin local de création de cours custom n\'enregistre aucune donnée personnelle.';
$string['import'] = 'Inscrire des utilisateurs via un fichier';
$string['confirm_enrol_msg'] = 'L\'utilisateur %s a bien été incrit au cours avec le rôle "%s".';
$string['already_enrol_msg'] = 'L\'utilisateur %s est déjà inscrit au cours.';
$string['no_user_found'] = 'Impossible de retrouver l\'utilisateur en base.';
$string['users_imported_count'] = '%d utilisateurs viennent d\'être inscrits au cours.';
$string['enrolled_users'] = 'Voir les utilisateurs inscrits';
$string['new_enrol'] = 'Faire une nouvelle inscription';
$string['no_user_imported'] = 'Aucun utilisateur n\'a pu être ajouté au cours via ce fichier.';
$string['users_group_imported_count'] = '%d utilisateurs viennent d\'être ajoutés au groupe.';

$string['import:enrol'] = 'Importer des utilisateurs';
$string['import:select_role'] = 'Inscrire en tant que';
$string['select_role'] = 'le rôle à attribuer';
$string['select_role_help'] = 'Rôle que vous voulez attribuer aux utilisateurs dans le contexte du cours. Attention, ce rôle sera donné "manuellement" à TOUS les utilisateurs de votre liste présents dans la base.';
$string['import:select_file'] = 'Fichier listant les utilisateurs';
$string['select_file'] = 'Le fichier à uploader';
$string['select_file_help'] = 'Fichier (.csv, .txt) listant les utilisateurs que vous voulez inscrire à ce cours.
                                Votre fichier .csv devra respecter la structure suivante: <strong>Nom;Prénom;N°identification;AdresseMail;Autres champs</strong> (Le n° d\'identification correspond au numéro étudiant ou au numéro personnel, celui-ci permettra de faire la correspondance avec l\'utilisateur et à défaut cette correspondance sera faite grâce à l\'adresse email).';
$string['create_groups_not_existing'] = 'Créer les groupes qui n\'existent pas';
$string['create_groups_not_existing_help'] = 'Si la case est cochée et que des groupes qui apparaissent dans le fichier à uploader n\'existent pas, ceux-ci seront automatiquement créés. Sinon l\'ajout sera ignoré.';
$string['download_example_csv'] = 'Fichier .csv exemple';
$string['download_example_csv_help'] = 'Fichier .csv présentant un exemple de fichier attendu par le formulaire';

$string['import_users_group_title'] = 'Importer des utilisateurs à un groupe via un fichier';
$string['is_not_registered_to_the_course'] = " n'est pas inscrit au cours";
$string['csv_line_unknown_users'] = "Les lignes suivantes ne correspondent pas à des utilisateurs de la plateforme : ";
$string['select_group'] = "Choisir le groupe";
$string['select_group_help'] = "Groupe auquel les utilistateurs seront rattachés. Attention, les groupes doivent être crées et les utilistateurs inscrits au cours au préalable.";
$string['export_select_group'] = "Groupe à exporter";
$string['export_select_group_help'] = "Groupe dont vous voulez exportez les membres.";
$string['export_group_members'] = "Exporter les membres d'un groupe";
$string['no_members'] = "Export impossible: le groupe choisi n'a pas de membre.";
$string['groups_no_members'] = "Export impossible: aucun groupe de ce cours ne possède de membres.";
$string['export_filename'] = "Nom du fichier";
$string['export_filename_help'] = "Nom du fichier que vous voulez donner au fichier généré. Information obligatoire pour pouvoir générer l'export dans vos documents. Attention, l'extension .csv sera ajoutée au nom de fichier que vous aurez choisi et les espaces seront remplacés par des '_'.";

$string['group_multienrol:title'] = 'Inscriptions multiples aux groupes';
$string['group_multienrol:menu'] = 'Inscriptions multiples à des groupes via un fichier';
$string['group_multienrol:target'] = 'Population d\'utilisateurs ciblée';
$string['group_multienrol:target_help'] = 'Population d\'utilisateurs ciblée:<ul>
                                        <li>Utilisateurs inscrits: seuls les utilisateurs inscrits au cours présents dans votre fichier seront traités et affectés au(x) groupe(s) que vous avez défini.</li>
                                        <li>Tous les utilisateurs: si des utilisateurs présents dans votre fichier ne sont pas inscrits au cours, ils seront inscrits au cours avant d\'être traités et affectés au(x) groupe(s) que vous avez défini.</li>
                                        </ul>';
$string['group_multienrol:target_enrolled'] = 'Seulement les utilisateurs inscrits au cours';
$string['group_multienrol:role_help'] = 'Rôle que vous souhaitez donner dans le contexte du cours aux utilisateurs présents dans votre fichier et que ne sont pas encore inscrits au cours (attention, le rôle choisi ne sera pas donné aux utilisateurs déjà présents dans le cours).';
$string['group_multienrol:role'] = 'Rôle à attribuer aux nouveaux utilisteurs.';
$string['group_multienrol:options_file'] = 'Options du fichier d\'import';
$string['group_multienrol:delimiter'] = 'Séparateur de groupe';
$string['group_multienrol:delimiter_help'] = 'Séparateur utilisé dans votre  fichier pour délimiter les différents noms de groupe. Attention, si ce caractère figure dans le nom d\' un de groupe, celui-ci sera interprété et l\'import pourrait ne pas fonctionner.';
$string['group_multienrol:ok'] = '%s ajouté au groupe %s.';
$string['group_multienrol:ko'] = '%s n\'a pas pu être ajouté au groupe %s.';
$string['group_multienrol:group_create_ok'] = 'Le groupe %s a été créé.';
$string['group_multienrol:group_create_ko'] = 'Le groupe %s n\'a pas pu être créé.';
$string['group_multienrol:group_ko'] = 'Le groupe %s n\'existe pas.';
$string['group_multienrol:user_enrolled'] = '%s a été inscrit au cours.';
$string['group_multienrol:user_unenrolled'] = '%s n\'est pas inscrit au cours.';
