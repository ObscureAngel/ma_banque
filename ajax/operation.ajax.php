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
				"ao_retourAjax" => fct_ajoutOperation(
					$_POST['us_designation'],
					$_POST['us_libellePaiement'],
					$_POST['ud_dateOperation'],
					$_POST['uf_montantOperation'],
					$_POST['ui_identifiantCategorie'],
					$_POST['us_nomEntreprise'],
					$_POST['us_nomVille']
				)
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

// Fonction d'ajout d'une opération par le formulaire
function fct_ajoutOperation (
	$ps_designationPaiement,
	$ps_libellePaiement,
	$pd_datePaiement,
	$pf_montantPaiement,
	$pi_categoriePaiement,
	$ps_entrepriseAchat,
	$ps_villeAchat
) {
	$fo_bdd = new cla_PDOMySQL();
	$fo_bdd->fct_setConnexionRapide();

	$fs_query = "INSERT INTO mb_operation (
		bs_descriptionPaiement,
		bs_libellePaiement,
		bd_dateOperation,
		bf_debitOperation,
		bf_creditOperation,
		bi_idCatagorieOperation,
		bi_idCompteOperation
	) VALUES (
		:bs_descriptionPaiement,
		:bs_libellePaiement,
		:bd_dateOperation,
		:bf_debitOperation,
		:bf_creditOperation,
		:bi_idCatagorieOperation,
		1
	)";

	$fo_bdd->fct_prepareQuery($fs_query);
	$fo_bdd->fct_executeQueryOperation([
		":bs_descriptionPaiement" => $ps_designationPaiement,
		":bs_libellePaiement" => $ps_libellePaiement,
		":bd_dateOperation" => $pd_datePaiement,
		":bf_debitOperation" => -$pf_montantPaiement,
		":bf_creditOperation" => 0,
		":bi_idCatagorieOperation" => $pi_categoriePaiement
	]);
}