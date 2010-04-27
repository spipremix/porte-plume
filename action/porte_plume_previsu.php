<?php
/**
 * Action affichant la prévisualisation de porte plume
 *
 * Pas besoin de sécuriser outre mesure ici, on ne réalise donc qu'un
 * recuperer_fond
 *
 * On passe par cette action pour éviter les redirection et la perte du $_POST de
 * $forcer_lang=true;
 * cf : ecrire/public.php ligne 80
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_porte_plume_previsu_dist(){
	echo recuperer_fond('porte_plume_preview',$_POST);
}
?>