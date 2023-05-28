function fct_verifierMotDePasse() {
	let fo_premierMotDePasse = document.querySelector('#us_motDePasseConfirmation');
	let fo_deuxiemeMotDePasse = document.querySelector('#us_motDePasse');
	let fo_boutonValidation = document.querySelector('#us_validation');

	if (fo_premierMotDePasse.value == fo_deuxiemeMotDePasse.value) fo_boutonValidation.removeAttribute('disabled');
	else fo_boutonValidation.setAttribute('disabled', '');
}