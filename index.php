<?php

require_once 'controller/cla_PDOMySQL.class.php';
require_once 'model/cla_Utilisateur.class.php';

session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
	<link id="colorTheme" rel="stylesheet" href="css/style.dark.css">
	<title>Ma Banque</title>
	<link rel="icon" href="img/assets/ma_banque.png">
	<script src="functions/fcts_javascript/fcts_switchColorTheme.js"></script>
	<script>fct_loadColorTheme();</script>
</head>
<body>
	<div class="banner top-header">
		<div class="connexion">
			<span id="p_erreurConnexion" class="msg-erreur"></span>
			<input type="text" name="us_emailLogin" id="us_emailLogin" placeholder="Email">
			<input type="password" name="us_motDePasseLogin" id="us_motDePasseLogin" placeholder="Mot de passe">
			<button id="btn_connexion" onclick="">Se connecter</button>
		</div>
	</div>
	<header>
		<h1>L'application de gestion bancaire en local</h1>
	</header>
	<button id="btn_switchColorTheme" value="dark" onclick="fct_switchColorTheme(this);">Switch color theme</button>
	<footer class="banner mention">
		<div>
			<p>2022 &copy; Tous droits réservés - Développé avec passion par <a target="_blank" href="https://www.maximebeacco.fr">Maxime BEACCO</a></p>
			<a target="_blank" href="https://www.flaticon.com/fr/auteurs/juicy-fish">Favicon by juicy_fish</a>
		</div>
	</footer>
	<script src="functions/fcts_javascript/fcts_module/mod_connexion.js" type="module"></script>
</body>
</html>