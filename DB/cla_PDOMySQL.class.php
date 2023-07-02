<?php

namespace MaBanque\DB;

use Exception;
use PDO;

/**
 * Classe servant de connector PDO à la base de données
 */
class cla_PDOMySQL extends PDO {

	/**
	 * Contient l'adresse de l'hébergeur de la base de donnée
	 * @var string
	 */
	public $cs_hebergeurBDD = "localhost";

	/**
	 * Contient le nom de la base à laquelle PDO doit se connecter.
	 * @var string
	 */
	public $cs_nomBDD = "ma_banque";

	/**
	 * Contient l'encodage utilisé lors que l'on établit la connexion
	 * @var string
	 */
	public $cs_charsetBDD = "utf8";

	/**
	 * Contient l'utilisateur dont se sert PDO pour se connecter à la base
	 * @var string
	 */
	public $cs_utilisateurBDD = "root";

	/**
	 * Contient le mot de passe de l'utilisateur dont se sert PDO pour se connecter à la base
	 * @var string
	 */
	public $cs_motDePasseBDD = "";

	/**
	 * Contient l'instance PDO courante
	 * 
	 * Cela permet de conserver l'instance PDO dans la classe.
	 * @var PDO
	 */
	protected $co_connexionMySQL;

	/**
	 * Contient l'instance PDOStatement de la requête en cours
	 * 
	 * Cela permet de faire des opérations sur cette instance sans la sortir de la classe.
	 * @var PDOStatement
	 */
	private $co_requeteEnCours = null;

	/**
	 * Contient l'instance PDOStatement correspondant à la requête préparée en cours d'exécution
	 * @var PDOStatement
	 */
	private $co_requetePrepareeEnCours = null;

	/**
	 * Tableau qui contiendra les requêtes préparées (PDOStatement) en cours.
	 */
	private $ca_requetesPrepareesStockees = array();
	
	/**
	 * Le __construct n'exécute aucune action, l'instanciation de PDO se fait avec la fonction fct_setConnexionRapide();
	 */
	function __construct() {}

	/**
	 * A la destruction de l'instance courante, on détruit également l'instance PDO pour fermer la connexion.
	 * On détruit aussi l'instance PDOStatement par sécurité.
	 */
	function __destruct() {
		$this->fct_clearConnexion();
	}

	/**
	 * Permet d'instancier PDO et de se connecter à la base
	 */
	public function fct_setConnexionRapide() {
		$this->co_connexionMySQL = new PDO (
			'mysql:host=' . $this->cs_hebergeurBDD . ';dbname=' . $this->cs_nomBDD . ';charset=' . $this->cs_charsetBDD,
			$this->cs_utilisateurBDD,
			$this->cs_motDePasseBDD
		);
	}

	/**
	 * Permet de fermer et détruire la connexion courante pour en construire une nouvelle
	 */
	public function fct_clearConnexion () {
		$this->co_requeteEnCours = null;
		$this->co_connexionMySQL = null;
	}

	/**
	 * Fonction de récupération de l'objet PDO
	 * 
	 * @return object L'instance PDO utilisée dans la classe
	 */
	public function fct_getConnexion() {
		return $this->co_connexionMySQL;
	}

	/**
	 * Permet de changer l'hébergeur par défaut
	 * 
	 * Défaut : localhost
	 * 
	 * @param string $ps_hebergeur Le nouvel hébergeur
	 */
	public function fct_setHebergeurBDD($ps_hebergeur) {
		$this->cs_hebergeurBDD = $ps_hebergeur;
	}

	/**
	 * Permet de changer le nom de la base par défaut
	 * 
	 * Défaut : 
	 * 
	 * @param string $ps_nomBDD Le nouveau nom de la base
	 */
	public function fct_setNomBDD($ps_nomBDD) {
		$this->cs_nomBDD = $ps_nomBDD;
	}

	/**
	 * Permet de modifier le charset par défaut
	 * 
	 * Défaut : utf8
	 * 
	 * @param string $ps_charset
	 */
	public function fct_setCharsetBDD($ps_charset) {
		$this->cs_charsetBDD = $ps_charset;
	}

	/**
	 * Permet de changer le nom d'utilisateur par défaut
	 * 
	 * Défaut : 
	 * 
	 * @param string $ps_utilisateurBDD Le nouveau nom d'utilisateur
	 */
	public function fct_setUtilisateurBDD($ps_utilisateurBDD) {
		$this->cs_utilisateurBDD = $ps_utilisateurBDD;
	}

	/**
	 * Permet de changer le mot de passe par défaut
	 * 
	 * Défaut : <password>
	 * 
	 * @param string $ps_motDePasseBDD Le nouveau mot de passe
	 */
	public function fct_setMotDePasseBDD($ps_motDePasseBDD) {
		$this->cs_motDePasseBDD = $ps_motDePasseBDD;
	}

	/**
	 * Fonction qui permet de setup la connexion avec les informations reçues de fct_getDevEnv
	 * 
	 * @param array $pa_credentialsBdd Tableau contenant les informations nécessaires pour la connexion.
	 * Il doit être formaté comme le tableau récupéré depuis fct_getDevEnv
	 * 
	 * @return void
	 */
	public function fct_setCredentialsBDD($pa_credentialsBdd) {
		$this->cs_hebergeurBDD = $pa_credentialsBdd['as_host'];
		$this->cs_nomBDD = $pa_credentialsBdd['as_bdd'];
		$this->cs_utilisateurBDD = $pa_credentialsBdd['as_user'];
		$this->cs_motDePasseBDD = $pa_credentialsBdd['as_password'];
	}

	/**
	 * Permet d'activer les exception et les déclanchements d'erreurs sur les focntions PDO
	 */
	public function fct_setErrorMode() {
		$this->co_connexionMySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Permet d'effectuer une requête de récupération de données sur la connexion courante.
	 * 
	 * @param string $ps_query La requête à effectuer
	 * 
	 * @throws Exception Si aucune connexion n'a été configuré précédemment.
	 */
	public function fct_requeteQuery ($ps_query) {
		if (is_null($this->co_connexionMySQL)) 
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant d'effectuer une requête.");

		$this->co_requeteEnCours = $this->co_connexionMySQL->query($ps_query);
	}

	/**
	 * Permet d'effectuer une requête de récupération de données sur la connexion courante et de récupérer les résultats intantanément.
	 * 
	 * @param string $ps_query La requête à effectuer
	 * 
	 * @return array Le tableau du résultat de la requête.
	 * 
	 * @throws Exception Si aucune connexion n'a été configuré précédemment.
	 */
	public function fct_requeteQueryInstant_a ($ps_query) {
		if (is_null($this->co_connexionMySQL)) 
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant d'effectuer une requête.");

		$fo_requeteEnCours = $this->co_connexionMySQL->query($ps_query);
		return $fo_requeteEnCours->fetchAll();
	}

	/**
	 * 
	 * 
	 * @param string $ps_query La requête à effectuer
	 * 
	 * @return mixed Le résultat atomique de la requête. Si le résultat est vide, la fonction renvoie null.
	 * 
	 * @throws Exception Si aucune connexion n'a été configuré précédemment.
	 * @throws Exception Si la requête en cours a rencontré une erreur.
	 */
	public function fct_requeteQueryInstantResultatAtomique_v($ps_query) {
		if (is_null($this->co_connexionMySQL)) 
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant d'effectuer une requête.");

		$fo_requeteEnCours = $this->co_connexionMySQL->query($ps_query);

		if (is_bool($fo_requeteEnCours) && $fo_requeteEnCours === false) {
			throw new Exception("La requête a rencontré une erreur et n'a pas pu récupérer de données. Veuillez contacter le pôle Informatique d'Edissio.");
		}

		$fa_resultatRequete = $fo_requeteEnCours->fetchAll();
		
		if (!empty($fa_resultatRequete)) {
			$fv_retourFonction = $fa_resultatRequete[0];
		}
		else {
			$fv_retourFonction = null;
		}

		if (is_array($fv_retourFonction)) {
			$fv_retourFonction = $fv_retourFonction[0];
		}

		return $fv_retourFonction;
	}

	/**
	 * Permet d'effectuer une requête d'administration sur la connexion courante.
	 * 
	 * @param string $ps_query La requête à effectuer
	 * 
	 * @return int Le nombre de ligne affectées par la requête
	 * 
	 * @throws Exception Si aucune connexion n'a été configuré précédemment.
	 */
	public function fct_requeteExecute_i ($ps_query) {
		if (is_null($this->co_connexionMySQL))
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant d'effectuer une requête.");

		return $this->co_connexionMySQL->exec($ps_query);
	}

	/**
	 * Fonction spécifique à l'insertion qui permet de récupérer ensuite l'id de la ligne insérée
	 * 
	 * @param string Table sur laquelle il faut insérer des données
	 * 
	 * @param array Tableau des valeurs à insérer
	 * 
	 * @param array (Optionnel) Le tableau des champs dans lesquels insérer les données
	 * 
	 * @return int L'identifiant de la nouvelle ligne insérée.
	 * 
	 * @throws Exception Si la connexion n'est pas configurée
	 * @throws Exception Dans le cas d'une insertion complète (paramètre optionnel nul), si le nombre de valeurs ne correspond pas au nombre de colonnes
	 * @throws Exception Dans le cas d'une insertion partielle (paramètre optionnel non nul), si le nombre de valeurs ne correspond pas au nombre de champs dans lesquels on doit insérer
	 */
	public function fct_requeteInsert_i($ps_nomTable, $pa_valeursInsertion,	$pa_champsInsertion = null) {
		// Vérification de la présence d'une connexion
		if (is_null($this->co_connexionMySQL))
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant d'effectuer une requête.");

		// Récupération de la description de la table
		$fa_descriptionTableInsertion = $this->fct_requeteQueryInstant_a("DESC " . $ps_nomTable);

		// Contrôle du nombre de champs à insérer dans le cas d'une insertion complète
		if (
			is_null($pa_champsInsertion)
			&& (sizeof($pa_valeursInsertion) != sizeof($fa_descriptionTableInsertion))
		) {
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant d'effectuer une requête.");
		}

		// Contrôle du nombre de champs à insérer dans le cas d'une insertion partielle.
		if (
			!is_null($pa_champsInsertion)
			&& (sizeof($pa_valeursInsertion) != sizeof($pa_champsInsertion))
		) {
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant d'effectuer une requête.");
		}

		// On utilisera qu'une seule variable dans la suite du code.
		if (!is_null($pa_champsInsertion)) $fa_descriptionTableInsertion = $pa_champsInsertion;

		$fs_query = "INSERT INTO " . $ps_nomTable . " (" . implode(', ', $pa_champsInsertion) . ") VALUES ()";

		/**
		 * mbeacco - 08/06/2021
		 * @todo Faire un test sur le type des valeurs en fonction du type des colonnes (utiliser la base information_schema qui est accessible)
		 * @todo Ne pas prendre en compte les colonnes id dans le comptage d'une insertion complète
		 * @todo Permettre de pouvoir préparer plusieurs requêtes en même temps dans une même instance de la classe (idem pour les query de données je pense)
		 */
	}

	/**
	 * Permet de récupérer l'ensemble des résultats d'une requête de récupération de données
	 * 
	 * @return array Le tableau contenant les résultats de la requête courante
	 * 
	 * @throws Exception Si aucune requête n'est en cours.
	 * @throws Exception Si la requête en cours a rencontré une erreur.
	 */
	public function fct_getResultatRequete_a () {
		if (is_null($this->co_requeteEnCours)) 
			throw new Exception("Aucune requête de récupération de données n'est en cours. Veuillez effectuer une requête de récupération de données avant d'utiliser cette fonction.");

		if (
			is_bool($this->co_requeteEnCours)
			&& $this->co_requeteEnCours === false
		)
			throw new Exception("La requête a rencontré une erreur et n'a pas pu récupérer de données. Veuillez contacter le pôle Informatique d'Edissio.");

		$fa_tableauResultatsRetour = $this->co_requeteEnCours->fetchAll();
		$this->co_requeteEnCours = null;
		return $fa_tableauResultatsRetour;
	}

	/**
	 * Permet de préparer une requête afin d'optimiser et sécuriser son exécution
	 * 
	 * @param string $ps_query
	 * 
	 * @param array $pa_optionPreparation (Optionnel)
	 * 
	 * @throws Exception Si la connexion PDO n'a pas été faite.
	 * @throws Exception Si la requête est vide ou n'est pas une chaîne de caractères.
	 * @throws Exception Si la préparation de la requête échoue.
	 */
	public function fct_prepareQuery($ps_query, $pa_optionPreparation = array()) {
		if (is_null($this->co_connexionMySQL)) {
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant de préparer une requête.");
		}

		if (!is_string($ps_query) || empty($ps_query)) {
			throw new Exception("La requête que vous souhaitez préparer n'est pas valide. Veuillez vérifier votre syntaxe.");
		}
		
		$this->co_requetePrepareeEnCours = $this->co_connexionMySQL->prepare($ps_query, $pa_optionPreparation);

		if ($this->co_requetePrepareeEnCours === false) {
			throw new Exception("La requête que vous souhaitez préparer n'est pas valide. Veuillez vérifier votre syntaxe.");
		}
	}

	/**
	 * Permet de préparer une requête afin d'optimiser et sécuriser son exécution
	 * 
	 * @param string $ps_query
	 * 
	 * @param string $ps_clefRequetePreparee (Optionnel)
	 * 
	 * @param array $pa_optionPreparation (Optionnel)
	 * 
	 * @return mixed string si une clef textuelle est définie, int sinon.
	 * 
	 * @throws Exception Si la connexion PDO n'a pas été faite.
	 * @throws Exception Si la requête est vide ou n'est pas une chaîne de caractères.
	 * @throws Exception Si la préparation de la requête échoue.
	 */
	public function fct_prepareStockedQuery($ps_query, $ps_clefRequetePreparee = null, $pa_optionPreparation = array()) {
		if (is_null($this->co_connexionMySQL)) {
			throw new Exception("PDO n'est connecté à aucune base de données. Veuillez configurer la connexion avant de préparer une requête.");
		}

		if (!is_string($ps_query) || empty($ps_query)) {
			throw new Exception("La requête que vous souhaitez préparer n'est pas valide. Veuillez vérifier votre syntaxe.");
		}

		if (!is_array($pa_optionPreparation)) {
			throw new Exception("Les options de préparation sont incorrectes. Veuillez les vérifier.");
		}

		if (!is_string($ps_clefRequetePreparee) || is_numeric($ps_clefRequetePreparee) || is_null($ps_clefRequetePreparee)) {
			$fv_clefRequetePreparee = sizeof($this->ca_requetesPrepareesStockees);
		}
		else {
			$fv_clefRequetePreparee = $ps_clefRequetePreparee;
		}
		
		$this->ca_requetesPrepareesStockees[$fv_clefRequetePreparee] = $this->co_connexionMySQL->prepare($ps_query, $pa_optionPreparation);

		if ($this->co_requetePrepareeEnCours === false) {
			throw new Exception("La requête que vous souhaitez préparer n'est pas valide. Veuillez vérifier votre syntaxe.");
		}

		return $fv_clefRequetePreparee;
	}

	/**
	 * Permet d'exécuter une requête précédemment préparée avec des valeurs spécifiques
	 * 
	 * @param array $pa_valeursParametres
	 * 
	 * @throws Exception Si aucune requête préparée n'est en cours.
	 * @throws Exception Si les paramètres sont vides ou ne sont pas contenus dans un tableau.
	 * @throws Exception Si l'exécution de la requête préparée échoue.
	 */
	public function fct_executeQueryOperation($pa_valeursParametres) {
		if (is_null($this->co_requetePrepareeEnCours)) {
			throw new Exception("Aucune requête préparée n'est en cours. Veuillez préparer une requête avant d'utiliser cette fonction.");
		}

		if (!is_array($pa_valeursParametres) || empty($pa_valeursParametres)) {
			throw new Exception("Les valeurs à utiliser pour exécuter la requête préparée sont invalides. Veuiller les vérifier");
		}

		$fb_resultatRequetePreparee = $this->co_requetePrepareeEnCours->execute($pa_valeursParametres);

		if (!$fb_resultatRequetePreparee) {
			throw new Exception("La requête préparée a échoué. Veuiller préparer à nouveau la requête.");
		}
	}

	/**
	 * Permet d'exécuter une requête précédemment préparée avec des valeurs spécifiques
	 * 
	 * @param array $pa_valeursParametres
	 * 
	 * @return array Les résultats de la requête préparée exécutée avec les valeurs passées en paramètre
	 * 
	 * @throws Exception Si aucune requête préparée n'est en cours.
	 * @throws Exception Si les paramètres sont vides ou ne sont pas contenus dans un tableau.
	 * @throws Exception Si l'exécution de la requête préparée échoue.
	 */
	public function fct_executeQueryDonnees($pa_valeursParametres) {
		if (is_null($this->co_requetePrepareeEnCours)) {
			throw new Exception("Aucune requête préparée n'est en cours. Veuillez préparer une requête avant d'utiliser cette fonction.");
		}

		if (!is_array($pa_valeursParametres) || empty($pa_valeursParametres)) {
			throw new Exception("Les valeurs à utiliser pour exécuter la requête préparée sont invalides. Veuiller les vérifier.");
		}

		$fb_resultatRequetePreparee = $this->co_requetePrepareeEnCours->execute($pa_valeursParametres);

		if (!$fb_resultatRequetePreparee) {
			throw new Exception("La requête préparée a échoué. Veuiller préparer à nouveau la requête.");
		}

		return $this->co_requetePrepareeEnCours->fetchAll();
	}

	/**
	 * Permet d'exécuter une requête précédemment préparée et stockée avec des valeurs spécifiques
	 * 
	 * @param mixed $pv_indexQuery string si la clé est une chaîne de caractères, int sinon.
	 * 
	 * @param array $pa_valeursParametres Valeurs des paramètres SQL de la requête.
	 * 
	 * @return array|bool Les résultats de la requête préparée exécutée avec les valeurs passées en paramètre
	 * 
	 * @throws Exception Si aucune requête préparée n'est en cours.
	 * @throws Exception Si les paramètres sont vides ou ne sont pas contenus dans un tableau.
	 * @throws Exception Si l'exécution de la requête préparée échoue.
	 */
	public function fct_executeStockedQuery($pv_indexQuery, $pa_valeursParametres, $pb_isDataQuery = true) {
		if (is_null($this->ca_requetesPrepareesStockees[$pv_indexQuery])) {
			throw new Exception("Aucune requête préparée n'est en cours. Veuillez préparer une requête avant d'utiliser cette fonction.");
		}

		if (!is_array($pa_valeursParametres) || empty($pa_valeursParametres)) {
			throw new Exception("Les valeurs à utiliser pour exécuter la requête préparée sont invalides. Veuiller les vérifier.");
		}

		$fb_resultatRequetePreparee = $this->ca_requetesPrepareesStockees[$pv_indexQuery]->execute($pa_valeursParametres);

		if (!$fb_resultatRequetePreparee) {
			throw new Exception("La requête préparée a échoué. Veuiller préparer à nouveau la requête.");
		}

		if ($pb_isDataQuery) return $this->ca_requetesPrepareesStockees[$pv_indexQuery]->fetchAll();
		else return $fb_resultatRequetePreparee;
	}

	/**
	 * Permet de retirer une requête préparée stockée dans l'instance de la connexion.
	 * 
	 * @param mixed $pv_indexQuery string si la clé est une chaîne de caractères, int sinon.
	 */
	public function fct_deletePreparedStockedQuery($pv_indexQuery)	{
		unset($this->ca_requetesPrepareesStockees[$pv_indexQuery]);
	}
}