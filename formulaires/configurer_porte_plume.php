<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2009                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_configurer_porte_plume_charger_dist(){
	$valeurs = array();
	$valeurs['barre_outils_public'] = $GLOBALS['meta']['barre_outils_public'];
	return $valeurs;
}

function formulaires_configurer_porte_plume_traiter_dist(){
	include_spip('inc/config');
	appliquer_modifs_config();
		
	return array('message_ok'=>_T('barre_outils:config_info_enregistree'));
}

?>
