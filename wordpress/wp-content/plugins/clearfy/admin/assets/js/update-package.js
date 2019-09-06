/**
 * This code provides tools for downloading, installing external add-ons for the Clearfy plugin
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 10.09.2017, Webcraftic
 * @version 1.0
 */


(function($) {
	'use strict';

	var clearfyPackage = {
		init: function() {
			this.events();
		},
		events: function() {
			var self = this;

			/**
			 * This event is intended for installation, removal, activation, deactivation of external add-ons
			 */

			$(document).on('click', '.wbcr-clr-update-package', function() {
				var $this = $(this),
					loading = $(this).data('loading'),
					wpnonce = $(this).data('wpnonce');

				var data = {
					action: 'wbcr-clearfy-update-package',
					_wpnonce: wpnonce
				};

				$this.addClass('disabled').text(loading);

				self.sendRequest(data, function(response) {
					var noticeId;

					$this.closest('.wbcr-factory-warning-notice').remove();

					if( !response || !response.success ) {

						if( response.data.error_message ) {
							console.log(response.data.error_message);
							noticeId = $.wbcr_factory_clearfy_206.app.showNotice('Error massage: [' + response.data.error_message + ']', 'danger');
						} else {
							console.log(response);
						}

						return;
					}

					noticeId = $.wbcr_factory_clearfy_206.app.showNotice(response.data.message, 'success');

					setTimeout(function() {
						$.wbcr_factory_clearfy_206.app.hideNotice(noticeId);
					}, 5000);
				});

				return false;
			});
		},
		sendRequest: function(data, callback) {
			$.ajax(ajaxurl, {
				type: 'post',
				dataType: 'json',
				data: data,
				success: function(data, textStatus, jqXHR) {
					callback && callback(data);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);

					var noticeId = $.wbcr_factory_clearfy_206.app.showNotice('Error: [' + thrownError + '] Status: [' + xhr.status + '] Error massage: [' + xhr.responseText + ']', 'danger');

					allNotices.push(noticeId);
				}
			});
		}
	};

	$(document).ready(function() {
		clearfyPackage.init();
	});

})(jQuery);
