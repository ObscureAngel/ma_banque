<?php

require_once 'controller/cla_PDOMySQL.class.php';
require_once 'model/cla_Utilisateur.class.php';

session_start();

// Vérification de la connexion
if (!isset($_SESSION['ab_isConnecte']) || !$_SESSION['ab_isConnecte']) header('Location: ./');
$so_utilisateur = unserialize($_SESSION['ao_utilisateur']);

$li_heure = intval(date('H'));
if ($li_heure >= 4 && $li_heure < 18) $ls_texteAccueil = 'Bonjour';
else $ls_texteAccueil = 'Bonsoir';

$ls_texteAccueil .= ' ' . $so_utilisateur->fct_getPrenomUtilisateur();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="dashboard.css">
	<title>Tableau de bord</title>
</head>
<body>
	<div id="mySidenav" class="sidenav">
		<button id="ub_deconnexion" class="deconnexion" value="<?php echo $so_utilisateur->fct_getIdUtilisateur(); ?>"><img src="img/assets/logout.png" alt="Déconnexion" width="30px" /></button>
		<a id="closeBtn" href="#" class="close">&times;</a>
		<ul>
			<li><a href="#">Consulter vos comptes</a></li>
			<li><a href="#">Consulter vos projets d'épargne</a></li>
			<li><a href="#">Consulter vos dernières opérations</a></li>
			<li><a href="#">Téléverser un relevé</a></li>
		</ul>
	</div>

	<header>
		<p>
			<a href="#" id="openBtn"><img src="img/assets/burger.png" alt="Menu" width="40px" /></a>
			<?php echo $ls_texteAccueil; ?>
		</p>
	</header>

	<section></section>

	<?php include_once('html_parts/footer.html'); ?>
	<script type="module" src="functions/fcts_javascript/fcts_module/mod_dashboard.js"></script>
</body>
</html>