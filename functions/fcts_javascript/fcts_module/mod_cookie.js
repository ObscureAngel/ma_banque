
/**
 * Nom du module
 */
export const gs_nomModule = "Module de gestion des cookies en Javascript";

/**
 * Fonction permettant d'ajouter une valeur dans les cookies du site
 * @param {string} ps_nomCookie Nom du cookie à ajouter
 * @param {mixed} pv_valeurCookie Valeur à enregistrer
 * @param {int} pi_nombreJourValidite Nombre de jour avant l'expiration du cookie
 */
export function fct_createCookie(ps_nomCookie, pv_valeurCookie, pi_nombreJourValidite) {
	const fo_dateCookie = new Date();
	fo_dateCookie.setTime(fo_dateCookie.getTime() + (pi_nombreJourValidite * 24 * 60 * 60 * 1000));
	let fs_expirationCookie = "expires=" + fo_dateCookie.toUTCString();

	document.cookie = ps_nomCookie + "=" + pv_valeurCookie + ";" + fs_expirationCookie + ";path=/";
}

/**
 * Fonction permettant de récupérer la valeur d'un cookie
 * @param {string} ps_nomCookie Nom du cookie à récupérer
 * @returns {mixed} La valeur du cookie demandé
 */
export function fct_readCookie(ps_nomCookie) {
	let name = ps_nomCookie + "=";
	let ca = document.cookie.split(';');
	for(let i = 0; i < ca.length; i++) {
		let c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

export function fct_updateCookie(ps_nomCookie, pv_nouvelleValeurCookie) {
	
}

export function fct_deleteCookie(ps_nomCookie) {
	
}

export function fct_verifieCookie() {
	let user = getCookie("username");
	if (user != "") {
		alert("Welcome again " + user);
	} else {
		user = prompt("Please enter your name:", "");
		if (user != "" && user != null) {
			setCookie("username", user, 365);
		}
	}
}