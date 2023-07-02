<?php

namespace MaBanque\Ajax;

use MaBanque\DB\cla_PDOMySQL;
use Exception;

// Traitement des routes
try {
	if (empty($_POST)) throw new Exception("Requête inexistante");
	
	if (empty($_POST['route'])) throw new Exception("Requête inexistante");

	switch ($_POST['route']) {
		case 'ajout':
			echo json_encode([
				"ao_erreur" => [],
				"ao_retourAjax" => fct_ajoutCategorie(
					$_POST['us_nomCategorie'],
					$_POST['ui_identifiantParent']
				)
			]);
			break;

		case 'afficheTout':
			echo json_encode([
				"ao_erreur" => [],
				"ao_retourAjax" => fct_afficheToutCategorie()
			]);
			break;
	}
	
} catch (Exception $po_erreur) {
	echo json_encode([
		"ao_erreur" => [
			"as_messageErreur" => $po_erreur->getMessage(),
			"aa_contenuPost" => $_POST
		],
		"ao_retourAjax" => []
	]);
}

#region Fonctions correspondantes aux routes réceptionnées

/**
 * fct_ajoutCategorie
 *
 * @param  mixed $ps_nomCategorie
 * @param  mixed $pi_idParent
 * @return void
 */
function fct_ajoutCategorie ($ps_nomCategorie, $pi_idParent = null) {
	$fs_root = dirname(__DIR__);
	require_once($fs_root . "/DB/cla_PDOMySQL.class.php");
	$fo_bdd = new cla_PDOMySQL();
	$fo_bdd->fct_setConnexionRapide();

	$fs_query = "INSERT INTO mb_categorie (bi_idCategorieParent, bs_nomCategorie) VALUES (:bi_idParent, :bs_nomCategorie)";
	$fo_bdd->fct_prepareStockedQuery($fs_query, "insert");
	$fo_bdd->fct_executeStockedQuery("insert", [
		":bi_idParent" => (empty($pi_idParent) ? null : $pi_idParent),
		":bs_nomCategorie" => $ps_nomCategorie
	]);
}

/**
 * fct_afficheToutCategorie
 *
 * @return void
 */
function fct_afficheToutCategorie () {
	$fs_root = dirname(__DIR__);
	require_once($fs_root . "/DB/cla_PDOMySQL.class.php");
	$fo_bdd = new cla_PDOMySQL();
	$fo_bdd->fct_setConnexionRapide();

	$fa_listeCategorie = [];

	$fs_query = "SELECT * FROM mb_categorie WHERE bi_idCategorieParent IS NULL ORDER BY bs_nomCategorie ASC";
	$fa_categorieParente = $fo_bdd->fct_requeteQueryInstant_a($fs_query);

	foreach ($fa_categorieParente as $fa_ligne) {
		$fa_listeCategorie[] = fct_recurrenceCategorie($fa_ligne['bi_idCategorie']);
	}

	return ["aa_listeCategorie" => $fa_listeCategorie];
}

#endregion

#region Fonctions annexes
function fct_recurrenceCategorie ($pi_idCategorie) {
	$fs_root = dirname(__DIR__);
	require_once($fs_root . "/DB/cla_PDOMySQL.class.php");
	$fo_bdd = new cla_PDOMySQL();
	$fo_bdd->fct_setConnexionRapide();

	$fs_query = "SELECT bi_idCategorie FROM mb_categorie WHERE bi_idCategorieParent = " . $pi_idCategorie . " ORDER BY bs_nomCategorie ASC";
	$fa_categorieParente = $fo_bdd->fct_requeteQueryInstant_a($fs_query);

	if (empty($fa_categorieParente)) {
		$fs_query = "SELECT bs_nomCategorie FROM mb_categorie WHERE bi_idCategorie = " . $pi_idCategorie;
		return ["ai_idCategorie" => $pi_idCategorie, "as_nomCategorie" => $fo_bdd->fct_requeteQueryInstantResultatAtomique_v($fs_query)];
	}
	else {
		$fa_retourRecurrence = [];
		$fa_retourRecurrence[] = ["ai_idCategorie" => $pi_idCategorie, "as_nomCategorie" => $fo_bdd->fct_requeteQueryInstantResultatAtomique_v("SELECT bs_nomCategorie FROM mb_categorie WHERE bi_idCategorie = " . $pi_idCategorie)];
		foreach ($fa_categorieParente as $fa_ligne) {
			$fa_retourRecurrence[] = fct_recurrenceCategorie($fa_ligne['bi_idCategorie']);
		}
		return $fa_retourRecurrence;
	}
}
#endregion