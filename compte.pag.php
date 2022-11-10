<?php

require_once 'controller/cla_PDOMySQL.class.php';
require_once 'model/cla_Utilisateur.class.php';

session_start();

// Vérification de la connexion
if (!isset($_SESSION['ab_isConnecte']) || !$_SESSION['ab_isConnecte']) header('Location: vue/connexionUtilisateur.pag.php');
$so_utilisateur = unserialize($_SESSION['ao_utilisateur']);

$lo_bdd = new cla_PDOMySQL();
$lo_bdd->fct_setConnexionRapide();
$lo_bdd->fct_setErrorMode();

switch ($_REQUEST['action']) {
	case 'voir':
		$ls_query = 'SELECT * FROM mb_compte WHERE bi_idUtilisateurCompte = ' . $so_utilisateur->fct_getIdUtilisateur();
	break;

	case 'ajouter':

		$ls_query = 'INSERT INTO mb_compte (bi_idUtilisateurCompte, bs_nomCompte) VALUES (' . $so_utilisateur->fct_getIdUtilisateur() . ', "' . $_POST['us_nomCompte'] . '")';
		$lo_bdd->fct_requeteExecute_i($ls_query);
	break;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ma Banque</title>
</head>
<body>
	<form action="" method="post">
		<input type="hidden" name="action" value="ajouter">
		<label for="us_nomCompte">Nom du compte</label>
		<input type="text" name="us_nomCompte" id="us_nomCompte" maxlength="45">
		<input type="submit" name="us_validation" value="Enregistrer">
	</form>
</body>
</html>