/**
 * Notification panel
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 10.09.2017, Webcraftic
 * @version 1.0
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		$(document).on('click', '.wbcr-han-panel-restore-notify-link', function() {
			var self = $(this),
				noticeID = $(this).data('notice-id'),
				counterEl = $('.wbcr-han-adminbar-counter');

			if( !noticeID ) {
				alert('Undefinded error. Please report the bug to our support forum.');
			}

			self.closest('li').hide();

			$.ajax(ajaxurl, {
				type: 'post',
				dataType: 'json',
				data: {
					action: 'wbcr_dan_restore_notice',
					security: wbcr_dan_ajax_restore_nonce,
					notice_id: noticeID
				},
				success: function(data, textStatus, jqXHR) {
					if( data == 'error' && data.error ) {
						alert(data.error);
						self.closest('li').show();
						return;
					}

					counterEl.text(counterEl.text() - 1);
					self.closest('li').remove();
				}
			});
		});
	});
})(jQuery);
