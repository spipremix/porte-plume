<?php
/*
 * Plugin Porte Plume pour SPIP 2
 * Licence GPL
 * Auteur Matthieu Marcillaud
 */
define('PORTE_PLUME_PUBLIC', true);

// autoriser le porte plume dans le public ?
function autoriser_porte_plume_afficher_public_dist($faire, $type, $id, $qui, $opt) {
	return PORTE_PLUME_PUBLIC;
	// n'autoriser qu'aux identifies :
	# return $qui['id_auteur'] ? PORTE_PLUME_PUBLIC : false;
}

function porte_plume_insert_head_public($flux){
	include_spip('inc/autoriser');
	if (autoriser('afficher_public', 'porte_plume')) {
		$flux = porte_plume_inserer_head($flux, $GLOBALS['spip_lang']);
	}
	return $flux;
}

function porte_plume_insert_head_prive($flux){
	$flux = porte_plume_inserer_head($flux, $GLOBALS['spip_lang']);
	return $flux;
}

function porte_plume_inserer_head($flux, $lang){
	$js = find_in_path('javascript/jquery.markitup_pour_spip.js');
	$js_previsu = find_in_path('javascript/jquery.previsu_spip.js');
	$js_settings = parametre_url(generer_url_public('porte_plume.js'), 'lang', $lang);
	$js_start = parametre_url(generer_url_public('porte_plume_start.js'), 'lang', $lang);

	$flux 
		.= porte_plume_insert_head_css() // compat SPIP 2.0
		.  "<script type='text/javascript' src='$js'></script>\n"
		.  "<script type='text/javascript' src='$js_previsu'></script>\n"
		.  "<script type='text/javascript' src='$js_settings'></script>\n"
		.  "<script type='text/javascript' src='$js_start'></script>\n";

	return $flux;
}

function porte_plume_insert_head_css($flux=''){
	static $done = false;
	if ($done) return $flux;
	$done = true;

	$css = find_in_path('css/barre_outils.css');
	$css_icones = generer_url_public('barre_outils_icones.css');

	$flux
		.= "<link rel='stylesheet' type='text/css' media='all' href='$css' />\n"
		.  "<link rel='stylesheet' type='text/css' media='all' href='$css_icones' />\n";

	return $flux;
}


?>
