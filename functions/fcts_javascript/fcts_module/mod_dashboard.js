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

document.querySelector("#openBtn").addEventListener('click', function() {
	document.querySelector("#mySidenav").classList.add("active");
});

document.querySelector("#closeBtn").addEventListener('click', function() {
	document.querySelector("#mySidenav").classList.remove("active");
});

/*document.querySelector('#btn_envoiReleve').addEventListener('click', function(po_event) {
	po_event.preventDefault();
	
	let fo_formulaireReleve = new FormData();
	fo_formulaireReleve.append("ur_fichierReleve", document.querySelector('#ur_fichierReleve').files[0]);
	fo_formulaireReleve.append("ui_idCompte", document.querySelector('#ui_idCompte').value);

	Ajax.fct_ajaxSender(
		"mb_operation.ajax.php",
		fo_formulaireReleve,
		function(po_retourAjax) {
			console.log(po_retourAjax.ajs_messageRetour);

			if (po_retourAjax.ajb_rechargePage) window.location.reload();
		}
	);
});*/