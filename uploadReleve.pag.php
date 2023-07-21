<?php
/**
 * 0 ID
 * 1 Date DD/MM/YYYY
 * 2 Projet (vide)
 * 3 Catégorie, Sous-catégorie (Catégories préremplies)
 * 4 Libellé (libellé court de l'opération)
 * 5 Libellé complet (libellé entier)
 * 6 Etat (Pointé ou non)
 * 7 Débit (les moins)
 * 8 Crédit (les plus)
 */

require_once 'controller/DB/cla_PDOMySQL.class.php';
require_once 'model/cla_Utilisateur.class.php';

use MaBanque\DB\cla_PDOMySQL;

session_start();

// Vérification de la connexion
if (!isset($_SESSION['ab_isConnecte']) || !$_SESSION['ab_isConnecte']) header('Location: ./');
$so_utilisateur = new cla_Utilisateur();
$so_utilisateur->fct_setUtilisateurJson($_SESSION['as_utilisateur']);

$lo_bdd = new cla_PDOMySQL();
$lo_bdd->fct_setConnexionRapide();
$lo_bdd->fct_setErrorMode();

if (isset($_POST['us_validForm'])) {
	$la_dataInsertion = array();
	$lr_fichierCsv = fopen($_FILES['ur_fichierCSV']['tmp_name'], 'r');
	$lb_isEnteteLigne = true;
	$lf_balanceReleve = 0;
	while ($la_contenuCsv = fgetcsv($lr_fichierCsv, 1000, ';')) {
		if ($lb_isEnteteLigne) {
			if (count($la_contenuCsv) == 9) {
				$la_indexCsv = array(
					"ai_dateOperation" => 1,
					"ai_debitOperation" => 7,
					"ai_creditOperation" => 8,
					"ai_libelleOperation" => 4
				);
			}
			else if (count($la_contenuCsv) == 6){
				$la_indexCsv = array(
					"ai_dateOperation" => 0,
					"ai_debitOperation" => 2,
					"ai_creditOperation" => 3,
					"ai_libelleOperation" => 4
				);
			}
			else if (count($la_contenuCsv) == 5) {
				$la_indexCsv = array(
					"ai_dateOperation" => 0,
					"ai_debitOperation" => 1,
					"ai_creditOperation" => 2,
					"ai_libelleOperation" => 3
				);
			}
			else {
				/**
				 * @todo Faire un retour d'erreur sous forme de popup qui disparait tout seul en haut de l'écran.
				 */
			}
			$lb_isEnteteLigne = false;
		}
		else {
			$la_dateOperation = explode('/', $la_contenuCsv[$la_indexCsv['ai_dateOperation']]);
			$la_contenuCsv[$la_indexCsv['ai_debitOperation']] = floatval(str_replace(',', '.', $la_contenuCsv[$la_indexCsv['ai_debitOperation']]));
			$la_contenuCsv[$la_indexCsv['ai_creditOperation']] = floatval(str_replace(',', '.', $la_contenuCsv[$la_indexCsv['ai_creditOperation']]));

			if ($la_contenuCsv[$la_indexCsv['ai_debitOperation']] == 0) $la_contenuCsv[$la_indexCsv['ai_debitOperation']] = 'null';
			else $lf_balanceReleve -= $la_contenuCsv[$la_indexCsv['ai_debitOperation']];

			if ($la_contenuCsv[$la_indexCsv['ai_creditOperation']] == 0) $la_contenuCsv[$la_indexCsv['ai_creditOperation']] = 'null';
			else $lf_balanceReleve += $la_contenuCsv[$la_indexCsv['ai_creditOperation']];
			/*$la_contenuCsv[$la_indexCsv['ai_debitOperation']] = (($la_contenuCsv[$la_indexCsv['ai_debitOperation']] == 0) ? 'null' : $la_contenuCsv[$la_indexCsv['ai_debitOperation']]);
			$la_contenuCsv[$la_indexCsv['ai_creditOperation']] = (($la_contenuCsv[$la_indexCsv['ai_creditOperation']] == 0) ? 'null' : $la_contenuCsv[$la_indexCsv['ai_creditOperation']]);*/

			$ls_query = 'INSERT INTO mb_operation (bs_libelleOperation, bd_dateOperation, bf_debitOperation, bf_creditOperation, bi_idCompteOperation) VALUES ("' . mb_convert_encoding($la_contenuCsv[$la_indexCsv['ai_libelleOperation']], 'UTF-8', mb_detect_encoding($la_contenuCsv[$la_indexCsv['ai_libelleOperation']])) . '", "' . $la_dateOperation[2] . '-' . $la_dateOperation[1] . '-' . $la_dateOperation[0] . '", ' . $la_contenuCsv[$la_indexCsv['ai_debitOperation']] . ', ' . $la_contenuCsv[$la_indexCsv['ai_creditOperation']] . ', ' . $_POST['ui_compte'] . ')';
			$lo_bdd->fct_requeteExecute_i($ls_query);
		}
	}
}

$ls_query = "SELECT * FROM mb_compte WHERE bi_idUtilisateurCompte = " . $so_utilisateur->fct_getIdUtilisateur();
$la_compte = $lo_bdd->fct_requeteQueryInstant_a($ls_query);
$ls_selectHtmlCompte = '';
foreach ($la_compte as $la_data) {
	$ls_selectHtmlCompte .= '<option value="' . $la_data['bi_idCompte'] . '">' . $la_data['bs_nomCompte'] . '</option>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload CSV</title>
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		<label for="ur_fichierCSV">Uploader un fichier CSV</label>
		<input type="file" name="ur_fichierCSV" id="ur_fichierCSV">
		
		<label for="ui_compte">Sélectionner un compte</label>
		<select name="ui_compte" id="ui_compte">
			<?= $ls_selectHtmlCompte ?>
		</select>

		<input type="submit" name="us_validForm" id="us_validForm" value="Envoyer le fichier">
	</form>
</body>
</html>