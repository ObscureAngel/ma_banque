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
if (isset($_POST['us_validForm'])) {
	require_once('controller/cla_PDOMySQL.class.php');
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
			<option value="" disabled selected>Aucun</option>
			<option value="0">Compte courant</option>
		</select>

		<input type="submit" name="us_validForm" id="us_validForm" value="Envoyer le fichier">
	</form>
</body>
</html>