import * as Ajax from "./mod_ajax.js";

document.querySelector('#ub_deconnexion').addEventListener('click', function() {
	Ajax.fct_ajaxSender(
		"deconnexion.ajax.php",
		{
			"ajb_deconnexion": 1,
			"aji_idUtilisateur": this.value
		},
		function(po_retourAjax) {
			console.log(po_retourAjax.ajs_messageRetour);

			if (po_retourAjax.ajb_rechargePage) window.location.reload();
		}
	);
});