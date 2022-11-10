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

	$ls_query = 'INSERT INTO mb_compte (bi_idUtilisateurCompte, bs_nomCompte) VALUES (' . $_SESSION['ao_utilisateur']->fct_getIdUtilisateur() . ', "' . $_POST['us_nomCompte'] . '")';
	$lo_bdd->fct_requeteExecute_i($ls_query);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajout de compte</title>
</head>
<body>
	<form action="" method="post">
		<label for="us_nomCompte">Nom du compte</label>
		<input type="text" name="us_nomCompte" id="us_nomCompte" maxlength="45">
		<input type="submit" name="us_validation" value="Enregistrer">
	</form>
</body>
</html>