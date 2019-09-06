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
				nonce = $(this).data('nonce'),
				counterEl = $('.wbcr-han-adminbar-counter');

			if( !noticeID ) {
				alert('Undefinded error. Please report the bug to our support forum.');
			}

			self.closest('li').hide();

			$.ajax(ajaxurl, {
				type: 'post',
				dataType: 'json',
				data: {
					action: 'wbcr-dan-restore-notice',
					security: nonce,
					notice_id: noticeID
				},
				success: function(response) {
					if( !response || !response.success ) {

						if( response.data.error_message ) {
							console.log(response.data.error_message);
							self.closest('li').show();
						} else {
							console.log(response);
						}

						return;
					}

					counterEl.text(counterEl.text() - 1);
					self.closest('li').remove();
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});

			return false;
		});
	});
})(jQuery);
