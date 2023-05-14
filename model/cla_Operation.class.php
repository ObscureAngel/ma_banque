<?php

namespace MaBanque\model;

use MaBanque\DB\DBInsertion;
use MaBanque\DB\cla_PDOMySQL;

class Operation implements DBInsertion {

	private int $ci_idOperation;

	

	/**
	 */
	public function __construct() {
	}
	/**
	 * Ajoute un champ dans le table d'insertion
	 *
	 * @param array $pa_champsInsertion
	 * @param string $ps_nomChamp
	 * @param mixed $pv_valeurChamp
	 * @return void
	 */
	public function fct_ajouteChampInsertion(array &$pa_champsInsertion, string $ps_nomChamp, mixed $pv_valeurChamp) {
	}
	
	/**
	 * Retire un champ du tableau d'insertion
	 *
	 * @param array $pa_champsInsertion
	 * @param string $ps_nomChamp
	 * @return void
	 */
	public function fct_retireChampInsertion(array &$pa_champsInsertion, string $ps_nomChamp) {
	}
	
	/**
	 * Modifie un champ du tableau d'insertion
	 *
	 * @param array $pa_champsInsertion
	 * @param string $ps_nomChamp
	 * @param mixed $pv_valeurChamp
	 * @return void
	 */
	public function fct_modifieChampInsertion(array &$pa_champsInsertion, string $ps_nomChamp, mixed $pv_valeurChamp) {
	}
	
	/**
	 * Prépare et contrôle les données avant insertion
	 *
	 * @param array $pa_champsInsertion
	 * @return void
	 */
	public function fct_prepareInsertion(array &$pa_champsInsertion) {
	}
	
	/**
	 * Lance l'insertion des données dans la base
	 *
	 * @param array $pa_champsInsertion
	 * @param cla_PDOMySQL $po_connexionBdd
	 * @return void
	 */
	public function fct_lancementInsertion(array &$pa_champsInsertion, cla_PDOMySQL $po_connexionBdd) {
	}
}
