<?php

require_once '../../controller/cla_PDOMySQL.class.php';
require_once '../../model/cla_Utilisateur.class.php';

session_start();

function fct_connexionUtilisateur($ps_emailConnexion, $ps_motDePasse) {
	$fa_retourAjax = array();
	if (isset($_SESSION['ab_isConnecte']) && $_SESSION['ab_isConnecte']) $fa_retourAjax['aji_statutRetour'] = 2;
	else {
		$lo_bdd = new cla_PDOMySQL();
		$lo_bdd->fct_setConnexionRapide();
		$lo_bdd->fct_setErrorMode();

		$ls_query = 'SELECT bs_motDePasseUtilisateur FROM mb_utilisateur WHERE bs_loginUtilisateur = "' . $ps_emailConnexion . '"';
		$ls_hashMotDePasse = $lo_bdd->fct_requeteQueryInstantResultatAtomique_v($ls_query);

		$lb_isConnecte = password_verify($ps_motDePasse, $ls_hashMotDePasse);

		if ($lb_isConnecte) {
			$ls_query = 'SELECT bi_idUtilisateur, bs_nomUtilisateur, bs_prenomUtilisateur, bs_emailUtilisateur FROM mb_utilisateur WHERE bs_loginUtilisateur = "' . $ps_emailConnexion . '"';
			$la_data = $lo_bdd->fct_requeteQueryInstant_a($ls_query);
			$la_data = $la_data[0];

			$lo_utilisateur = new cla_Utilisateur();
			$lo_utilisateur->fct_setUtilisateur(
				$la_data['bi_idUtilisateur'],
				$la_data['bs_nomUtilisateur'],
				$la_data['bs_prenomUtilisateur'],
				$la_data['bs_emailUtilisateur']
			);

			$_SESSION['ab_isConnecte'] = $lb_isConnecte;
			$_SESSION['as_utilisateur'] = $lo_utilisateur->fct_getUtilisateurJson();

			$fa_retourAjax['aji_statutRetour'] = 1;
		}
		else $fa_retourAjax['aji_statutRetour'] = 0;
	}

	return json_encode($fa_retourAjax);
}

if (isset($_POST['ajs_emailConnexion']) && isset($_POST['ajs_motDePasseConnexion'])) {
	echo fct_connexionUtilisateur($_POST['ajs_emailConnexion'], $_POST['ajs_motDePasseConnexion']);
}
else session_destroy();