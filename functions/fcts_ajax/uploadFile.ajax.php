<?php

use MaBanque\DB\cla_PDOMySQL;

// Ejection si pas de POST
if (!isset($_POST)) exit;

// Retour en erreur si pas d'action en rapport avec un téléversement
if (empty($_POST['action']) || $_POST['action'] != 'uploadFile') {
	echo json_encode(array("aji_codeErreur" => 1));
	exit;
}

/**
 * @todo Faire une vérification de connexion pour ne pas que n'importe qui insère n'importe quoi
 */

// Traitement du téléversement en AJAX
switch ($_POST['us_typeUpload']) {
	case 'releveBancairePeriodique':
		/**
		 * On a besoin des champs suivants :
		 * - idCompte (identifier le compte lié aux opérations)
		 * - idUtilisateur (s'assurer que le compte appartient à la bonne personne)
		 * - le fichier en format csv
		 * 
		 * Le fichier doit contenir :
		 * - date de l'opération
		 * - libellé de l'opération (peut être vide)
		 * - montant de l'opération (- pour les débits et + pour les crédits)
		 * 
		 * La définition de règles pour le traitement des opérations peut permettre de lier automatiquement des catégories
		 */
		$lo_bdd = new cla_PDOMySQL();
		$lo_bdd->fct_setConnexionRapide();
		$lo_bdd->fct_setErrorMode();

		$la_dataInsertion = array();
		$lr_fichierCsv = fopen($_FILES['ur_fichierCSV']['tmp_name'], 'r');
		$lb_isEnteteLigne = true;
		while ($la_contenuCsv = fgetcsv($lr_fichierCsv, 1000, ';')) {
			if ($lb_isEnteteLigne) $lb_isEnteteLigne = false;
			else {
				$la_dateOperation = explode('/', $la_contenuCsv[1]);
				$la_contenuCsv[7] = floatval(str_replace(',', '.', $la_contenuCsv[7]));
				$la_contenuCsv[8] = floatval(str_replace(',', '.', $la_contenuCsv[8]));

				$ls_query = 'INSERT INTO mb_operation (bs_libelleOperation, bd_dateOperation, bf_debitOperation, bf_creditOperation) VALUES ("' . mb_convert_encoding($la_contenuCsv[4], 'UTF-8', mb_detect_encoding($la_contenuCsv[4])) . '", "' . $la_dateOperation[2] . '-' . $la_dateOperation[1] . '-' . $la_dateOperation[0] . '", ' . $la_contenuCsv[7] . ', ' . $la_contenuCsv[8] . ')';
				$lo_bdd->fct_requeteExecute_i($ls_query);
			}
		}
		break;

	case 'releveBancaireTransfert':
	
	default:
		# code...
		break;
}