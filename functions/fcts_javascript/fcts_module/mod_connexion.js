import * as Ajax from "./mod_ajax.js";

document.querySelector('#btn_connexion').addEventListener('click', function() {
	let us_emailConnexion = document.querySelector("#us_emailLogin").value;
	let us_motDePasseConnexion = document.querySelector("#us_motDePasseLogin").value;

	Ajax.fct_ajaxSender(
		"connexion.ajax.php",
		{
			"ajs_emailConnexion": us_emailConnexion,
			"ajs_motDePasseConnexion": us_motDePasseConnexion
		},
		function(po_retourAjax) {
			if (po_retourAjax.aji_statutRetour == 1 || po_retourAjax.aji_statutRetour == 2) window.location.href = "tableauDeBord.pag.php";
			else {
				document.querySelector("#p_erreurConnexion").innerHTML = "Erreur d'adresse email ou de mot de passe"

			}
		}
	);
});