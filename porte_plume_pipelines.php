<?php
/*
 * Plugin Porte Plume pour SPIP 2
 * Licence GPL
 * Auteur Matthieu Marcillaud
 */
#define('PORTE_PLUME_PUBLIC', true);

// autoriser le porte plume dans le public ?
function autoriser_porte_plume_afficher_public_dist($faire, $type, $id, $qui, $opt) {
	// compatibilite d'avant le formulaire de configuration
	if (defined('PORTE_PLUME_PUBLIC')) {
		return PORTE_PLUME_PUBLIC;
	}
	return ($GLOBALS['meta']['barre_outils_public'] !== 'non');
	
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
	$js = find_in_path('javascript/porte_plume_forcer_hauteur.js');
	$css = find_in_path('css/barre_outils_prive.css');

	$flux = porte_plume_inserer_head($flux, $GLOBALS['spip_lang'])
		. "<script type='text/javascript' src='$js'></script>\n"
		. "<link rel='stylesheet' type='text/css' media='all' href='$css' />\n";
	
	return $flux;
}

function porte_plume_inserer_head($flux, $lang){
	$xregexp = find_in_path('javascript/xregexp-min.js');
	$markitup = find_in_path('javascript/jquery.markitup_pour_spip.js');
	$js_previsu = find_in_path('javascript/jquery.previsu_spip.js');
	$js_start = parametre_url(generer_url_public('porte_plume_start.js'), 'lang', $lang);

	$flux 
		.= porte_plume_insert_head_css() // compat SPIP 2.0
		.  "<script type='text/javascript' src='$xregexp'></script>\n"
		.  "<script type='text/javascript' src='$markitup'></script>\n"
		.  "<script type='text/javascript' src='$js_previsu'></script>\n"
		.  "<script type='text/javascript' src='$js_start'></script>\n";

	return $flux;
}

function porte_plume_insert_head_css($flux=''){
	static $done = false;
	if ($done) return $flux;
	$done = true;
	if (autoriser('afficher_public', 'porte_plume')) {
		$css = find_in_path('css/barre_outils.css');
		$css_icones = generer_url_public('barre_outils_icones.css');

		$flux
			.= "<link rel='stylesheet' type='text/css' media='all' href='$css' />\n"
			.  "<link rel='stylesheet' type='text/css' media='all' href='$css_icones' />\n";
	}
	return $flux;
}


// valeur par defaut des configurations
function porte_plume_configurer_liste_metas($metas){
	$metas['barre_outils_public'] = 'oui';
	return $metas;
}


function porte_plume_affiche_milieu($flux){
	if ($flux['args']['exec']=='config_fonctions'){
		// dans la branche 2.1 on utilise l'ancienne interface du porte plume par homogeneite
		// en version 2.0, le pipeline configurer_liste_metas n'existe pas...
		if (version_compare($GLOBALS['spip_version_branche'], "2.2.0-dev","<")
		and version_compare($GLOBALS['spip_version_branche'], "2.1.0-dev", ">")) {
			$porte_plume = charger_fonction('porte_plume', 'configuration');
			$flux['data'] .= $porte_plume(); 
		} else {
			$flux['data'] .= recuperer_fond('prive/configurer/porte_plume',array()); 
		}
	}

	return $flux;
}
?>
