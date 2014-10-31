;(function($) {
	$.fn.previsu_spip = function(settings) {
		var options;

		options = {
			previewParserPath:	'' ,
			previewParserVar:	'data',
			textEditer:	'Editer',
			textVoir:	'Voir',
			textFullScreen: 'Plein écran'
		};
		$.extend(options, settings);

		return this.each(function() {

			var $$, textarea, tabs, preview;
			$$ = $(this);
			textarea = this;

			// init and build previsu buttons
			function init() {
				$$.addClass("pp_previsualisation");
				tabs = $('<div class="markItUpTabs"></div>').prependTo($$.parent());
				$(tabs).append(
					'<a href="#fullscreen" class="fullscreen">' + options.textFullScreen + '</a>' +
					'<a href="#previsuVoir" class="previsuVoir">' + options.textVoir + '</a>' +
					'<a href="#previsuEditer" class="previsuEditer on">' + options.textEditer + '</a>'
				);
				
				preview = $('<div class="markItUpPreview"></div>').insertAfter(tabs);
				preview.hide();

				var is_full_screen = false;
				var mark = $$.parent();
				var objet = mark.parents('.formulaire_spip')[0].className.match(/formulaire_editer_(\w+)/);
				objet = (objet ? objet[1] : '');
				var champ = mark.parents('li')[0].className.match(/editer_(\w+)/);
				champ = (champ ? champ[1].toUpperCase() : '');
				$('.fullscreen').click(function(){
					mark.toggleClass('fullscreen');
					if (mark.is('.fullscreen')){
						is_full_screen = true;
						if (!mark.is('.livepreview')){
							var original_texte="";
							var textarea = $(mark).find('textarea.pp_previsualisation');
							var preview = $(mark).find('.markItUpPreview');
							function refresh_preview(){
								var texte = textarea.val();
								if (original_texte == texte){
									return;
								}
								renderPreview(preview.addClass('ajaxLoad'),texte,champ,objet);
								original_texte = texte;
							}
							var timerPreview=null;
							mark.addClass('livepreview').find('.markItUpEditor').bind('keyup click change focus refreshpreview',function(e){
								if (is_full_screen){
									if (timerPreview) clearTimeout(timerPreview);
									timerPreview = setTimeout(refresh_preview,500);
								}
							});
							$(window).bind('keyup',function(e){
								if (is_full_screen){
									// Touche Echap pour sortir du mode fullscreen
									if (e.type=='keyup' && e.keyCode==27){
										mark.removeClass('fullscreen');
										is_full_screen = false;
									}
								}
							});
						}
						mark.find('.markItUpEditor').trigger('refreshpreview');
					}
					else
						is_full_screen = false;
				});

				$('.previsuVoir').click(function(){
					$(mark).find('.markItUpPreview').height(
						  $(mark).find('.markItUpHeader').height()
						+ $(mark).find('.markItUpEditor').height()
						+ $(mark).find('.markItUpFooter').height()
					);

					$(mark).find('.markItUpHeader').hide();
					$(mark).find('.markItUpEditor').hide();
					$(mark).find('.markItUpFooter').hide();
					$(this).addClass('on').next().removeClass('on');
					renderPreview($(mark).find('.markItUpPreview').show().addClass('ajaxLoad'),
							$(mark).find('textarea.pp_previsualisation').val(),
							champ,
							objet,
					    false);

					return false;
				});
				$('.previsuEditer').click(function(){
					$(mark).find('.markItUpPreview').hide();
					$(mark).find('.markItUpHeader').show();
					$(mark).find('.markItUpEditor').show();
					$(mark).find('.markItUpFooter').show();
					$(this).addClass('on').prev().removeClass('on');
					return false;
				});
			}


			function renderPreview(node, val, champ, objet, async) {
				if (options.previewParserPath !== '') {
					$.ajax( {
						type: 'POST',
						async: typeof (async)=="undefined"?true:async,
						url: options.previewParserPath,
						data: 'champ='+champ
							+'&objet='+objet
							+'&' + options.previewParserVar+'='+encodeURIComponent(val),
						success: function(data) {
							node.html(data).removeClass('ajaxLoad');
							//ouvre un nouvel onglet lorsqu'on clique sur un lien dans la prévisualisation
							$("a",node).attr("target","blank");
						}
					} );
				}
			}
	
			init();
		});
	};
})(jQuery);
