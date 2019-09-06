/**
 * Assets manager scripts
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 13.11.2017, Webcraftic
 * @version 1.0
 */

(function($) {
	'use strict';

	$(function() {
		$('.wbcr-gnz-disable').on('change', function(ev) {
			var class_name = 'wbcr-gnz-table__loaded-super-no';
			var handle = $(this).data('handle');
			if( handle != undefined ) {
				class_name = 'wbcr-gnz-table__loaded-no';
			}

			if( $(this).prop('checked') == true ) {
				$(this).closest('label').find('input[type="hidden"]').val('disable');
				$(this).closest('tr').find('.wbcr-assets-manager-enable-placeholder').hide();
				$(this).closest('tr').find('.wbcr-assets-manager-enable').show();
				$(this).closest('tr').find('.wbcr-state').removeClass('wbcr-gnz-table__loaded-yes');
				$(this).closest('tr').find('.wbcr-state').addClass(class_name).trigger('cssClassChanged');

				if( typeof wbcrChangeHandleState == 'function' ) {
					wbcrChangeHandleState(this, 1);
				}
			} else {
				$(this).closest('label').find('input[type="hidden"]').val('');
				$(this).closest('tr').find('.wbcr-assets-manager-enable').hide();
				$(this).closest('tr').find('.wbcr-assets-manager-enable-placeholder').show();
				$(this).closest('tr').find('.wbcr-state').removeClass(class_name);
				$(this).closest('tr').find('.wbcr-state').addClass('wbcr-gnz-table__loaded-yes').trigger('cssClassChanged');

				if( typeof wbcrChangeHandleState == 'function' ) {
					wbcrChangeHandleState(this, 0);
				}
			}
		});

		$('.wbcr-gnz-action-select').on('change', function(ev) {
			var selectElement = $(this).children(':selected');
			$(this).closest('.wbcr-assets-manager-enable').find('.wbcr-assets-manager').hide();

			if( selectElement.val() != 'current' ) {
				$(this).closest('.wbcr-assets-manager-enable').find('.wbcr-assets-manager.' + selectElement.val()).show();
			}
		});

		$('.wbcr-gnz-sided-disable').on('change', function(ev) {
			$(this).closest('label').find('input[type="hidden"]').val($(this).prop('checked') ? 1 : 0);

			var handle = $(this).data('handle');
			if( handle != undefined ) {
				$('.wbcr-gnz-sided-' + handle)
					.prop('checked', $(this).prop('checked'))
					.closest('label')
					.find('input[type="hidden"]').val($(this).prop('checked') ? 1 : 0);
			}
		});

		$('.wbcr-reset-button').on('click', function() {
			$('.wbcr-gnz-disable').each(function() {
				$(this).prop('checked', false).trigger('change');
				$(this).closest('input').val('');
			});
			$('.wbcr-gnz-sided-disable').each(function() {
				$(this).prop('checked', false).trigger('change');
				$(this).closest('input').val(1);
			});
		});

		$('.wbcr-state').bind('cssClassChanged', function() {
			var el = $(this).parent('td').parent('tr').find('.wbcr-info-data');
			if( $(this).hasClass('wbcr-gnz-table__loaded-no') || $(this).hasClass('wbcr-gnz-table__loaded-super-no') ) {
				if( el.length > 0 ) {
					el.data('off', 1);
				}
			} else {
				if( el.length > 0 ) {
					el.data('off', 0);
				}
			}

			if( typeof wbcrCalculateInformation == 'function' ) {
				wbcrCalculateInformation();
			}
		});

		if( typeof wbcrCalculateInformation == 'function' ) {
			wbcrCalculateInformation();
		}

		$('ul.wbcr-gnz-tabs').on('click', '.wbcr-gnz-tabs__button:not(.active)', function() {
			window.location.hash = '#' + $(this).data('hash');
			$(this)
				.addClass('active').parent().siblings().find('.wbcr-gnz-tabs__button').removeClass('active')
				.closest('.wbcr-gnz-content').find('div.wbcr-gnz-tabs-content').removeClass('active').eq($(this).parent().index()).addClass('active');
		});

		var tabHash = window.location.hash.replace('#', '');
		if( tabHash ) {
			$('ul.wbcr-gnz-tabs .wbcr-gnz-tabs__button[data-hash="' + tabHash + '"]').click();
		} else {
			$('ul.wbcr-gnz-tabs li').eq(0).find('.wbcr-gnz-tabs__button').click();
		}

		/*if ($('#wpadminbar').length > 0) {
		 var h = $('#wpadminbar').height();
		 if (h > 0) {
		 $('#wbcr-gnz header.wbcr-gnz-panel').css('top', h + 'px');
		 var top = $('#wbcr-gnz ul.wbcr-gnz-tabs').css('top');
		 $('#wbcr-gnz ul.wbcr-gnz-tabs').css('top', top.replace('px', '') * 1 + h + 'px');
		 }
		 }*/

		$('.wbcr-close-button').on('click', function() {
			document.location.href = $(this).data('href');
		});
	});

})(jQuery);
