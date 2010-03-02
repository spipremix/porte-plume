function barre_forcer_hauteur () {
	$(".markItUpEditor").each(function() {
		var hauteur_min = $(this).height();
		var hauteur_max = parseInt($(window).height()) - 200;
		var hauteur = hauteur_min;

		
		var signes = $(this).val().length;
		/* en gros: 400 signes donne 100 pixels de haut */
		var hauteur_signes = Math.round(signes / 4) + 50;
		if (hauteur_signes > hauteur_min && hauteur_signes < hauteur_max) hauteur = hauteur_signes;
		else if (hauteur_signes > hauteur_max) hauteur = hauteur_max;
		
		$(this).height(hauteur);
		
	});
}

$(document).ready(function(){
	barre_forcer_hauteur();
	$(window).bind("resize", function() {
		barre_forcer_hauteur();
	});
});