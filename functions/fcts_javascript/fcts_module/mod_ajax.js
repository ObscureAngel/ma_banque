/**
 * Ajout d'un nom au module
 */
export const gs_nomModule = "Module AJAX"

/**
 * Module facilitant les appels ajax
 * Les données récupérées de l'appel ajax sont utilisés comme des objets
 * 
 * @param {string} ps_fichierAjax Fichier de traitement de la requête ajax
 * @param {object} po_data Objet contenant les données à transmettre
 * @param {object} po_fonctionCallback Objet contenant la fonction à appeler après le retour de la requête ajax
 */
export function fct_ajaxSender(ps_fichierAjax, po_data, po_fonctionCallback) {
	let fo_xmlHttpRequest = new XMLHttpRequest();
	let fs_urlFichierAjax = "functions/fcts_ajax/" + ps_fichierAjax;
	let fs_parametres = new URLSearchParams(po_data).toString();
	fo_xmlHttpRequest.open("POST", fs_urlFichierAjax, true);
	
	fo_xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	fo_xmlHttpRequest.onreadystatechange = function() {
		if (fo_xmlHttpRequest.readyState == 4 && fo_xmlHttpRequest.status == 200) {
			po_fonctionCallback(JSON.parse(fo_xmlHttpRequest.responseText));
		}
	}
	fo_xmlHttpRequest.send(fs_parametres);
}