<?php
/*
 * Plugin Porte Plume pour SPIP 2
 * Licence GPL
 * Auteur Matthieu Marcillaud
 */
define('PORTE_PLUME_PUBLIC', true);

function porte_plume_insert_head_public($flux){
	if (PORTE_PLUME_PUBLIC) {
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
	$css = find_in_path('css/barre_outils.css');
	$css_icones = generer_url_public('barre_outils_icones.css');

	$flux 
		.= "<link rel='stylesheet' type='text/css' media='all' href='$css' />\n"
		.  "<link rel='stylesheet' type='text/css' media='all' href='$css_icones' />\n"
		.  "<script type='text/javascript' src='$js'></script>\n"
		.  "<script type='text/javascript' src='$js_previsu'></script>\n"
		.  "<script type='text/javascript' src='$js_settings'></script>\n"
		.  "<script type='text/javascript' src='$js_start'></script>\n";

	return $flux;
}


?>
