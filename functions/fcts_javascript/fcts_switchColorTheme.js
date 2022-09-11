function fct_switchColorTheme(po_btnElement) {
	let fo_linkThemeElement = document.querySelector("#colorTheme");
	fo_linkThemeElement.href = 'css/style.' + po_btnElement.value + '.css';
	
	if (po_btnElement.value == 'dark') po_btnElement.value = 'light';
	else po_btnElement.value = 'dark';
}

function fct_loadColorTheme() {
	
}