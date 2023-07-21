/**
 * Fonction de récurrence pour générer les noms des options contenues dans le select des catégories
 * 
 * @param {Array|Object} pv_categorie Catégorie à traiter
 * @param {HTMLSelectElement} po_elementSelect Element HTML select sur lequel on va ajouter les options
 * @param {string} ps_nomParent Nom de la catégorie parente, si applicable
 */
function fct_recurrenceAfficheCategorie(pv_categorie, po_elementSelect, ps_nomParent) {
	if (pv_categorie instanceof Array) {
		let fb_isPremiereLigne = true;

		// On parcourt donc le tableau des enfants
		pv_categorie.forEach(po_categorie => {

			// Si on est sur la première ligne des enfants alors on a affaire au détail de la catégorie parente
			if (fb_isPremiereLigne) {
				fb_isPremiereLigne = false;

				// On crée l'option du parent
				fo_elementOption = document.createElement("option");
				fo_elementOption.textContent = ps_nomParent + po_categorie.as_nomCategorie;
				fo_elementOption.value = po_categorie.ai_idCategorie;
				po_elementSelect.appendChild(fo_elementOption);

				// On récupère le nom de la catégorie parente pour le concaténer avec la catégorie enfant
				ps_nomParent += po_categorie.as_nomCategorie + " > ";
			}
			else {
				// Pour les lignes enfants, on passe par la récurrence
				fct_recurrenceAfficheCategorie(po_categorie, po_elementSelect, ps_nomParent);
			}
		});
	}
	// Si c'est un objet alors c'est une catégorie sans enfant
	else if (pv_categorie instanceof Object) {
		fo_elementOption = document.createElement("option");

		// On concatène avec le nom du parent pour s'y retrouver
		fo_elementOption.textContent = ps_nomParent + pv_categorie.as_nomCategorie;
		fo_elementOption.value = pv_categorie.ai_idCategorie;
		po_elementSelect.appendChild(fo_elementOption);
	}
	else {
		// Sinon on sait pas ce qu'on a
		console.log(pv_categorie);
	}
}

function fct_genererSelectCategorie(ps_idElementSelect) {
	// TODO: Dans la fonction récursive, compter la profondeur et ajouter un attriber dans le <option> qui permet de bloquer la saisie d'une nouvelle catégorie si on est déjà au max de la profondeur
	
	// TODO: Faire une fonction js qui permet de régénérer le select quand on ajoute une catégorie
	let fo_elementSelect = document.querySelector("#" + ps_idElementSelect);
	let fo_elementOption;

	// On vide le select avant de le remplir
	fo_elementSelect.innerHTML = '';
	let fo_formulaire = new FormData();
	fo_formulaire.append('route', 'afficheTout');

	fetch(
		'/ajax/categorie.ajax.php',
		{
			method: "POST",
			body: fo_formulaire
		}
	).then((po_retour) => {
		po_retour.json().then((po_data) => {
			// On crée une option vide présélectionnée
			fo_elementOption = document.createElement("option");
			fo_elementOption.textContent = "Aucune";
			fo_elementOption.value = "";
			fo_elementOption.selected = true
			fo_elementSelect.appendChild(fo_elementOption);

			// On va parcourir le tableau des catégories que l'on a pu récupérer
			po_data.ao_retourAjax.aa_listeCategorie.forEach(pv_categorie => {
				let fs_nomParent = "";
				fct_recurrenceAfficheCategorie(pv_categorie, fo_elementSelect, fs_nomParent);
			});
		});
	}).catch((po_erreur) => {
		console.error(po_erreur);
	});

	// Ajout de la fonction de tri
	$(document).ready(function() {
		$('.form-select2').select2({
			language: {
				noResults: () => {
					return "Aucune catégorie trouvée";
				}
			}
		});
	});
}