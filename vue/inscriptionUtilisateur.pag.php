<?php
if (isset($_POST['us_validation'])) {
	require_once '../controller/cla_PDOMySQL.class.php';
	$lo_bdd = new cla_PDOMySQL();
	$lo_bdd->fct_setConnexionRapide();
	$lo_bdd->fct_setErrorMode();

	$fa_data = array(
		"as_login" => $_POST['us_emailLogin'],
		"as_motDePasse" => password_hash($_POST['us_motDePasse'], PASSWORD_BCRYPT),
		"as_nom" => $_POST['us_nomUtilisateur'],
		"as_prenom" => $_POST['us_prenomUtilisateur'],
		"as_email" => $_POST['us_emailLogin']
	);

	$ls_query = 'INSERT INTO mb_utilisateur (bs_loginUtilisateur, bs_motDePasseUtilisateur, bs_nomUtilisateur, bs_prenomUtilisateur, bs_emailUtilisateur) VALUES ("' . $fa_data['as_login'] . '", "' . $fa_data['as_motDePasse'] . '", "' . $fa_data['as_nom'] . '", "' . $fa_data['as_prenom'] . '", "' . $fa_data['as_email'] . '")';
	$lo_bdd->fct_requeteExecute_i($ls_query);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="fcts_inscriptionConnexion.js"></script>
	<title>Inscription</title>
</head>
<body>
	<form action="" method="post">
		<label for="us_nomUtilisateur">Nom</label>
		<input type="text" name="us_nomUtilisateur" id="us_nomUtilisateur">

		<label for="us_prenomUtilisateur">Prénom</label>
		<input type="text" name="us_prenomUtilisateur" id="us_prenomUtilisateur">

		<label for="us_emailLogin">Email</label>
		<input type="email" name="us_emailLogin" id="us_emailLogin">

		<label for="us_motDePasse">Mot de passe</label>
		<input type="password" name="us_motDePasse" id="us_motDePasse" onkeyup="fct_verifierMotDePasse()">

		<label for="us_motDePasseConfirmation">Confirmer le mot de passe</label>
		<input type="password" name="us_motDePasseConfirmation" id="us_motDePasseConfirmation" onkeyup="fct_verifierMotDePasse()">

		<input type="submit" name="us_validation" id="us_validation" value="S'inscrire">
	</form>
</body>
</html>