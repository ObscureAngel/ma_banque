/**
 * Ajout d'un nom au module
 */
export const gs_nomModule = "Module Popup"

export let ga_listPopup = [];

let cs_templatePopup = '';

/**
 * Module facilitant les appels ajax
 * Les données récupérées de l'appel ajax sont utilisés comme des objets
 * 
 * @param {string} ps_fichierAjax Fichier de traitement de la requête ajax
 * @param {object} po_data Objet contenant les données à transmettre
 * @param {object} po_fonctionCallback Objet contenant la fonction à appeler après le retour de la requête ajax
 */
export function fct_createPopup(ps_idPopup, ps_htmlContent, ps_cssContent, ps_jsContent) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 */
export function fct_openPopup(ps_idPopup) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 */
export function fct_closePopup(ps_idPopup) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 * @param {string} ps_htmlContent Contenu HTML
 * @param {string} ps_cssContent Contenu CSS
 * @param {string} ps_jsContent Contenu JS
 */
export function fct_updatePopup(ps_idPopup, ps_htmlContent, ps_cssContent, ps_jsContent) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 */
export function fct_deletePopup(ps_idPopup) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 * @param {string} ps_htmlContent Contenu HTML
 */
export function fct_addHtmlContent(ps_idPopup, ps_htmlContent) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 * @param {string} ps_jsContent Contenu JS
 */
export function fct_addJsContent(ps_idPopup, ps_jsContent) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 * @param {string} ps_cssContent Contenu CSS
 */
export function fct_addCssContent(ps_idPopup, ps_cssContent) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 * @param {string} ps_htmlContent Contenu HTML
 */
export function fct_updateHtmlContent(ps_idPopup, ps_htmlContent) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 * @param {string} ps_jsContent Contenu JS
 */
export function fct_updateJsContent(ps_idPopup, ps_jsContent) {}

/**
 * 
 * @param {string} ps_idPopup ID du popup
 * @param {string} ps_cssContent Contenu CSS
 */
export function fct_updateCssContent(ps_idPopup, ps_cssContent) {}