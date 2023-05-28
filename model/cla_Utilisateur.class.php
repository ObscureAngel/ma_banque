<?php

class cla_Utilisateur {

	/**
	 * Identifiant de l'utilisateur
	 * @var int
	 */
	private $ci_idUtilisateur;

	/**
	 * Nom de l'utilisateur
	 * @var string
	 */
	private $cs_nomUtilisateur;

	/**
	 * Prénom de l'utilisateur
	 * @var string
	 */
	private $cs_prenomUtilisateur;

	/**
	 * Email de l'utilisateur
	 * @var string
	 */
	private $cs_emailUtilisateur;

	/**
	 * 
	 */
	public function __construct() {}

	/**
	 * 
	 */
	public function fct_setUtilisateur($pi_idUtilisateur, $ps_nomUtilisateur, $ps_prenomUtilisateur, $ps_emailUtilisateur) {
		$this->ci_idUtilisateur = $pi_idUtilisateur;
		$this->cs_nomUtilisateur = $ps_nomUtilisateur;
		$this->cs_prenomUtilisateur = $ps_prenomUtilisateur;
		$this->cs_emailUtilisateur = $ps_emailUtilisateur;
	}

	/**
	 * @param int $pi_idUtilisateur
	 */
	public function fct_setIdUtilisateur($pi_idUtilisateur) {
		$this->ci_idUtilisateur = $pi_idUtilisateur;
	}

	/**
	 * @return int
	 */
	public function fct_getIdUtilisateur() {
		return $this->ci_idUtilisateur;
	}

	/**
	 * @param string $ps_nomUtilisateur
	 */
	public function fct_setNomUtilisateur($ps_nomUtilisateur) {
		$this->cs_nomUtilisateur = $ps_nomUtilisateur;
	}

	/**
	 * @return string
	 */
	public function fct_getNomUtilisateur() {
		return $this->cs_nomUtilisateur;
	}

	/**
	 * @param string $ps_prenomUtilisateur
	 */
	public function fct_setPrenomUtilisateur($ps_prenomUtilisateur) {
		$this->cs_prenomUtilisateur = $ps_prenomUtilisateur;
	}

	/**
	 * @return string
	 */
	public function fct_getPrenomUtilisateur() {
		return $this->cs_prenomUtilisateur;
	}

	/**
	 * @param string $ps_emailUtilisateur
	 */
	public function fct_setEmailUtilisateur($ps_emailUtilisateur) {
		$this->cs_emailUtilisateur = $ps_emailUtilisateur;
	}

	/**
	 * @return string
	 */
	public function fct_getEmailUtilisateur() {
		return $this->cs_emailUtilisateur;
	}

	/**
	 * 
	 */
	public function fct_getUtilisateurJson() {
		return '{"ci_idUtilisateur":' . $this->ci_idUtilisateur . ',"cs_nomUtilisateur":"' . $this->cs_nomUtilisateur . '","cs_prenomUtilisateur":"' . $this->cs_prenomUtilisateur . '","cs_emailUtilisateur":"' . $this->cs_emailUtilisateur . '"}';
	}

	/**
	 * 
	 */
	public function fct_setUtilisateurJson($ps_json) {
		$fo_utilisateur = json_decode($ps_json);

		$this->ci_idUtilisateur = $fo_utilisateur->ci_idUtilisateur;
		$this->cs_nomUtilisateur = $fo_utilisateur->cs_nomUtilisateur;
		$this->cs_prenomUtilisateur = $fo_utilisateur->cs_prenomUtilisateur;
		$this->cs_emailUtilisateur = $fo_utilisateur->cs_emailUtilisateur;
	}
}