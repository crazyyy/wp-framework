/**
 * General
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2020, Webcraftic
 * @version 1.0
 */

(function ($) {

	function dan_pro_href(e) {
		var pro_href = "https://clearfy.pro/disable-admin-notices/";
		e.stopPropagation();
		window.open(pro_href, '_blank');
	}

	$('.factory-checkbox.wdanpro-checkbox-premium-label').click(dan_pro_href);
	$('.wdanpro-radio-premium-label .factory-compact_panel').click(dan_pro_href);

	$(document).on('click', '.wdan-page-restore-notice-link', function () {
		var self = $(this),
			noticeID = $(this).data('notice-id'),
			nonce = $(this).data('nonce'),
			counterEl = $('.wbcr-han-adminbar-counter');

		if (!noticeID) {
			alert('Undefinded error. Please report the bug to our support forum.');
		}

		self.hide();
		self.parent().find('.wdan-page-restore-notice-link-loader').show();


		$.ajax(ajaxurl, {
			type: 'post',
			dataType: 'json',
			data: {
				action: 'wbcr-dan-restore-notice',
				security: nonce,
				notice_id: noticeID
			},
			success: function (response) {
				if (!response || !response.success) {

					if (response.data.error_message) {
						console.log(response.data.error_message);
						self.closest('li').show();
					} else {
						console.log(response);
					}

					return;
				}

				counterEl.text(counterEl.text() - 1);
				self.closest('tr').hide();
				self.closest('tr').remove();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});

		return false;
	});


})(jQuery);
