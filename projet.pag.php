<?php

require_once 'controller/cla_PDOMySQL.class.php';
require_once 'model/cla_Utilisateur.class.php';

session_start();

// Vérification de la connexion
if (!isset($_SESSION['ab_isConnecte']) || !$_SESSION['ab_isConnecte']) header('Location: vue/connexionUtilisateur.pag.php');

if (isset($_POST['us_validation'])) {
	$lo_bdd = new cla_PDOMySQL();
	$lo_bdd->fct_setConnexionRapide();
	$lo_bdd->fct_setErrorMode();

	$ls_query = 'INSERT INTO mb_projet (bi_idUtilisateurProjet , bs_nomProjet, bf_objectifProjet, bf_etatProjet, bd_dateFinaleProjet) VALUES (' . $_SESSION['ao_utilisateur']->fct_getIdUtilisateur() . ', "' . $_POST['us_nomProjet'] . '", ' . $_POST['uf_objectifProjet'] . ', 0.00, "' . $_POST['ud_dateFinProjet'] . '")';
	$lo_bdd->fct_requeteExecute_i($ls_query);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajout de projet</title>
</head>
<body>
	<form action="" method="post">
		<label for="us_nomProjet">Nom du projet</label>
		<input type="text" name="us_nomProjet" id="us_nomProjet" maxlength="45">
		<label for="uf_objectifProjet">Objectif du projet</label>
		<input type="number" name="uf_objectifProjet" id="uf_objectifProjet" min="0" step="0.01">
		<label for="ud_dateFinProjet">Date de fin du projet</label>
		<input type="date" name="ud_dateFinProjet" id="ud_dateFinProjet">
		<input type="submit" name="us_validation" value="Enregistrer">
	</form>
</body>
</html>