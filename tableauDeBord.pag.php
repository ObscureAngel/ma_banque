<?php

require_once 'controller/cla_PDOMySQL.class.php';
require_once 'model/cla_Utilisateur.class.php';

session_start();

// Vérification de la connexion
if (!isset($_SESSION['ab_isConnecte']) || !$_SESSION['ab_isConnecte']) header('Location: ./');
$so_utilisateur = unserialize($_SESSION['ao_utilisateur']);

// Initialisation de la connexion à la base
$lo_bdd = new cla_PDOMySQL();
$lo_bdd->fct_setConnexionRapide();
$lo_bdd->fct_setErrorMode();

#region Edition du message d'accueil
$li_heure = intval(date('H'));
if ($li_heure >= 4 && $li_heure < 18) $ls_texteAccueil = 'Bonjour';
else $ls_texteAccueil = 'Bonsoir';

$ls_texteAccueil .= ' ' . $so_utilisateur->fct_getPrenomUtilisateur();
#endregion

#region Construction des trois éléments du tableau de bord
$ls_requete = "SELECT * FROM mb_compte WHERE bi_idUtilisateurCompte = " . $so_utilisateur->fct_getIdUtilisateur();
$la_comptesUtilisateurs = $lo_bdd->fct_requeteQueryInstant_a($ls_requete);
$ls_objetHtmlComptes = "";
foreach ($la_comptesUtilisateurs as $la_compte) {
	$ls_objetHtmlComptes .= '<tr>';
	$ls_objetHtmlComptes .= '<td>' . $la_compte['bs_nomCompte'] . '</td>';
	$ls_objetHtmlComptes .= '<td class="afficheChiffre">--,-- €</td>';
	$ls_objetHtmlComptes .= '</tr>';
}

$ls_requete = "SELECT * FROM mb_projet WHERE bi_idUtilisateurProjet = " . $so_utilisateur->fct_getIdUtilisateur();
$la_projetsUtilisateurs = $lo_bdd->fct_requeteQueryInstant_a($ls_requete);
$ls_objetHtmlProjets = "";
foreach ($la_projetsUtilisateurs as $la_projet) {
	$ls_objetHtmlProjets .= '<tr>';
	$ls_objetHtmlProjets .= '<td>' . $la_projet['bs_nomProjet'] . '</td>';
	$ls_objetHtmlProjets .= '<td class="afficheChiffre">' . $la_projet['bf_objectifProjet'] . '€</td>';
	$ls_objetHtmlProjets .= '<td class="afficheChiffre">---%</td>';
	$ls_objetHtmlProjets .= '<td class="afficheDate">' . $la_projet['bd_dateFinaleProjet'] . '</td>';
	$ls_objetHtmlProjets .= '</tr>';
}

$ls_requete = "SELECT * FROM mb_operation JOIN mb_compte ON bi_idCompteOperation = bi_idCompte WHERE bi_idUtilisateurCompte = " . $so_utilisateur->fct_getIdUtilisateur() . " ORDER BY bd_dateOperation DESC";
$la_operationsUtilisateurs = $lo_bdd->fct_requeteQueryInstant_a($ls_requete);
$ls_objetHtmlOperations = "";
foreach ($la_operationsUtilisateurs as $la_operation) {
	$ls_objetHtmlOperations .= '<tr>';
	$ls_objetHtmlOperations .= '<td class="afficheDate">' . $la_operation['bd_dateOperation'] . '</td>';
	$ls_objetHtmlOperations .= '<td>' . $la_operation['bs_libelleOperation'] . '</td>';
	$ls_objetHtmlOperations .= '<td class="afficheChiffre">' . (is_null($la_operation['bf_creditOperation']) ? '' : $la_operation['bf_creditOperation'] . ' €') . '</td>';
	$ls_objetHtmlOperations .= '<td class="afficheChiffre">' . (is_null($la_operation['bf_debitOperation']) ? '' : $la_operation['bf_debitOperation'] . ' €') . '</td>';
	$ls_objetHtmlOperations .= '</tr>';
}
#endregion
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="tableauDeBord.css">
	<link rel="stylesheet" href="css/banque.css">
	<title>Tableau de bord</title>
</head>
<body>
	<div id="mySidenav" class="sidenav">
		<button id="ub_deconnexion" class="deconnexion" value="<?=$so_utilisateur->fct_getIdUtilisateur()?>"><img src="img/assets/logout.png" alt="Déconnexion" width="30px" /></button>
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
			<span class="bienvenue"><?=$ls_texteAccueil?></span>
		</p>
	</header>

	<div id="compte-projet" class="conteneur-flex">
		<section id="compte">
			<table>
				<thead>
					<tr>
						<th>Nom du compte</th>
						<th>Balance</th>
					</tr>
				</thead>
				<tbody>
					<?=$ls_objetHtmlComptes?>
				</tbody>
			</table>
		</section>

		<section id="projet">
			<table>
				<thead>
					<tr>
						<th>Nom de projet</th>
						<th>Objectif</th>
						<th>Avancée</th>
						<th>Date finale</th>
					</tr>
				</thead>
				<tbody>
					<?=$ls_objetHtmlProjets?>
				</tbody>
			</table>
		</section>
	</div>
	
	<section id="operation" class="conteneur-flex">
		<table>
			<thead>
				<tr>
					<th>Date de l'opération</th>
					<th>Nom de l'opération</th>
					<th>Crédit</th>
					<th>Débit</th>
				</tr>
			</thead>
			<tbody>
				<?=$ls_objetHtmlOperations?>
			</tbody>
		</table>
	</section>

	<?php include_once('html_parts/footer.html'); ?>
	<script type="module" src="functions/fcts_javascript/fcts_module/mod_dashboard.js"></script>
</body>
</html>