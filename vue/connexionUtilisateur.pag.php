<?php

require_once '../controller/cla_PDOMySQL.class.php';
require_once '../model/cla_Utilisateur.class.php';

session_start();

if (isset($_SESSION['ab_isConnecte']) && $_SESSION['ab_isConnecte']) header('Location: ../dashboard.php');

if (isset($_POST['us_validation'])) {
	$lo_bdd = new cla_PDOMySQL();
	$lo_bdd->fct_setConnexionRapide();
	$lo_bdd->fct_setErrorMode();

	$ls_query = 'SELECT bs_motDePasseUtilisateur FROM mb_utilisateur WHERE bs_loginUtilisateur = "' . $_POST['us_emailLogin'] . '"';
	$ls_hashMotDePasse = $lo_bdd->fct_requeteQueryInstantResultatAtomique_v($ls_query);

	$lb_isConnecte = password_verify($_POST['us_motDePasse'], $ls_hashMotDePasse);

	if ($lb_isConnecte) {
		$ls_query = 'SELECT bi_idUtilisateur, bs_nomUtilisateur, bs_prenomUtilisateur, bs_emailUtilisateur FROM mb_utilisateur WHERE bs_loginUtilisateur = "' . $_POST['us_emailLogin'] . '"';
		$la_data = $lo_bdd->fct_requeteQueryInstant_a($ls_query);
		$la_data = $la_data[0];

		$lo_utilisateur = new cla_Utilisateur(
			$la_data['bi_idUtilisateur'],
			$la_data['bs_nomUtilisateur'],
			$la_data['bs_prenomUtilisateur'],
			$la_data['bs_emailUtilisateur']
		);

		$_SESSION['ab_isConnecte'] = $lb_isConnecte;
		$_SESSION['ao_utilisateur'] = $lo_utilisateur;

		header('Location: ../dashboard.php');
	}
	else session_destroy();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="fcts_inscriptionConnexion.js"></script>
	<title>Connexion</title>
</head>
<body>
	<form action="" method="post">
		<label for="us_emailLogin">Email</label>
		<input type="email" name="us_emailLogin" id="us_emailLogin">

		<label for="us_motDePasse">Mot de passe</label>
		<input type="password" name="us_motDePasse" id="us_motDePasse">

		<input type="submit" name="us_validation" id="us_validation" value="Se connecter">
	</form>
</body>
</html>