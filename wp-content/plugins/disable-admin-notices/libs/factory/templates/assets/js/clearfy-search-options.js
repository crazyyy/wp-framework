(function($) {
	'use strict';

	$(document).ready(function() {
		if( '' !== window.location.hash && window.location.hash.indexOf('factory-control-') ) {
			let controlClass = window.location.hash.replace('#', ''),
				controlEl = $('.' + controlClass);

			// If the option is hidden in a container that becomes visible only with certain logic of actions.
			if( controlEl.closest('.factory-div').length && !controlEl.is(':visible') ) {
				controlEl.closest('.factory-div').fadeIn();
			}

			// If the option is hidden in a container as an additional
			if( controlEl.closest('.factory-more-link-content').length && !controlEl.is(':visible') ) {
				controlEl.closest('.factory-more-link-content').fadeIn(100, function() {
					controlEl.closest('.factory-more-link-content').find('.factory-more-link-hide').show();
				});
				$('a[href="#' + controlEl.closest('.factory-more-link-content').attr('id') + '"]').hide();
			}

			$([document.documentElement, document.body]).animate({
				scrollTop: controlEl.offset().top - 150
			}, 500, function() {

				controlEl.find('.control-label').css({
					color: '#ff5722',
					fontWeight: 'bold'
				});

				controlEl.closest('.factory-more-link-content').find('.factory-more-link-hide').css('display', 'block');

				history.pushState("", document.title, window.location.pathname
					+ window.location.search);
			});
		}

		if( undefined === window.wfactory_clearfy_search_options ) {
			throw new Error('Global var {wfactory_clearfy_search_options} is not declared.');
		}

		$('#wbcr-factory-templates-116__autocomplete').wfactory_clearfy_autocomplete({
			lookup: wfactory_clearfy_search_options,
			onSelect: function(suggestion) {
				$('#wbcr-factory-templates-116__autocomplete').prop("disabled", true);
				window.location.href = suggestion.data.page_url;
			}
		});
	});

})(jQuery);