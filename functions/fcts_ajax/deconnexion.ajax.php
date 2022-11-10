<?php

require_once '../../model/cla_Utilisateur.class.php';

session_start();

function fct_deconnexionUtilisateur($pi_idDeconnexionUtilisateur) {
	if (isset($_SESSION['ab_isConnecte']) && $_SESSION['ab_isConnecte']) {
		$so_utilisateur = unserialize($_SESSION['ao_utilisateur']);

		if ($so_utilisateur->fct_getIdUtilisateur() == $pi_idDeconnexionUtilisateur) {
			session_destroy();
			return json_encode(array(
				"ajs_messageRetour" => "Vous avez été déconnecté, à bientôt !",
				"ajb_rechargePage" => 1
			));
		}
		else {
			return json_encode(array(
				"ajs_messageRetour" => "Une erreur est survenue.",
				"ajb_rechargePage" => 0
			));
		}
	}
	else {
		session_destroy();
		return json_encode(array(
			"ajs_messageRetour" => "Une erreur est survenue, merci de vous reconnecter.",
			"ajb_rechargePage" => 1
		));
	}
}

if (isset($_POST['ajb_deconnexion']) && $_POST['ajb_deconnexion']) {
	echo fct_deconnexionUtilisateur($_POST['aji_idUtilisateur']);
}
else session_destroy();