/**
 * General
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 10.09.2017, Webcraftic
 * @version 1.0
 */

(function($) {
	'use strict';

	var general = {
		init: function() {
			this.qickStartAssistent();
			this.importOptions();
		},
		qickStartAssistent: function() {
			var self = this;

			$('.wbcr-clearfy-button-activate-mode').click(function() {

				var switcher = $(this).closest('.wbcr-clearfy-switch'),
					modeName = switcher.data('mode'),
					modeOptions = switcher.data('mode-options');

				if( switcher.hasClass('wbcr-clearfy-loading') || switcher.hasClass('wbcr-clearfy-active') ) {
					return false;
				}

				self.showConfirmationPopup(modeName, modeOptions);
				return false;
			});

			$('.wbcr-clearfy-popup-button-cancel').click(function() {
				self.hideConfirmationPopup();
			});

			/*$('.wbcr-clearfy-button-deativate-mode').click(function() {
			 var $this = $(this),
			 switcher = $(this).closest('.wbcr-clearfy-switch'),
			 modeName = switcher.data('mode');

			 if( switcher.hasClass('wbcr-clearfy-loading') ) {
			 return false;
			 }

			 switcher.addClass('wbcr-clearfy-loading');

			 self.sendRequest({
			 action: 'wbcr_clearfy_configurate',
			 mode: modeName,
			 cancel_mode: true
			 }, function(data) {
			 switcher.removeClass('wbcr-clearfy-loading');

			 if( data && data.export_options ) {
			 $('#wbcr-clearfy-import-export').html(data.export_options);
			 }
			 },
			 function() {
			 if( modeName != 'reset' ) {
			 switcher.removeClass('wbcr-clearfy-active');
			 }
			 });
			 return false;
			 });*/

			$('.wbcr-clearfy-popup-button-ok').click(function() {
				var $this = $(this), modeName = $this.closest('.wbcr-clearfy-confirm-popup').data('mode'),
					switcher = $('div[data-mode="' + modeName + '"]', '#wbcr-clearfy-quick-mode-board'),
					modeArgs = switcher.data('mode-args'),
					flushRedirect = modeArgs && modeArgs.flush_redirect;

				self.hideConfirmationPopup();
				switcher.addClass('wbcr-clearfy-loading');

				self.sendRequest({
						action: 'wbcr_clearfy_configurate',
						mode: modeName,
						flush_redirect: flushRedirect
					}, function(data) {
						if( !flushRedirect ) {
							switcher.removeClass('wbcr-clearfy-loading');
						}

						if( !data || data.error ) {
							/**
							 * Хук выполняет проивольную функцию, после того как получен ajax ответ о том, что в
							 * результате конфигурации произошла ошибка Реализация системы фильтров и хуков в файле
							 * libs/clearfy/admin/assests/js/global.js Пример регистрации хука
							 * $.wbcr_factory_clearfy_206.hooks.add('wbcr/factory_clearfy_206/updated',
							 * function(noticeId) {});
							 * @param {string} modeName - имя режима конфигурации
							 * @param {object} data
							 */

							$.wbcr_factory_clearfy_206.hooks.run('clearfy/quick_start/configurated_error', [
								modeName,
								data
							]);
							return;
						}

						if( data.export_options ) {
							$('#wbcr-clearfy-import-export').html(data.export_options);
						}
					},
					function(data) {

						/**
						 * Хук выполняет проивольную функцию, после того как получен ajax ответ об успешном выполнении
						 * конфигурации Реализация системы фильтров и хуков в файле
						 * libs/clearfy/admin/assests/js/global.js Пример регистрации хука
						 * $.wbcr_factory_clearfy_206.hooks.add('wbcr/factory_clearfy_206/updated', function(noticeId)
						 * {});
						 * @param {string} modeName - имя режима конфигурации
						 * @param {object} data
						 */
						$.wbcr_factory_clearfy_206.hooks.run('clearfy/quick_start/configurated', [modeName, data]);

						if( modeName != 'reset' ) {
							switcher.addClass('wbcr-clearfy-active');
							return;
						}

						$('.wbcr-clearfy-switch').removeClass('wbcr-clearfy-active');
					});

				return false;
			});
		},

		showConfirmationPopup: function(modeName, options) {
			var self = this;

			if( !$('.wbcr-clearfy-layer').length ) {
				var layer = $('<div></div>').addClass('wbcr-clearfy-layer');
				layer.prependTo('#wpbody');
				layer.fadeIn();
			} else {
				$('.wbcr-clearfy-layer').fadeIn();
			}

			var popupElem = $('.wbcr-clearfy-confirm-popup');
			popupElem.data('mode', modeName);
			popupElem.fadeIn();

			if( modeName != 'reset' ) {
				var printOptTitles = '';

				if( options ) {
					for( var opt in options ) {
						if( !options.hasOwnProperty(opt) ) {
							continue;
						}
						printOptTitles += '<li>' + options[opt] + '</li>';

					}
					$('.wbcr-clearfy-list-options').html(printOptTitles);
					popupElem.addClass('wbcr-clearfy-default-warning-options');
				}
				return;
			}

			popupElem.addClass('wbcr-clearfy-reset-warning-options');
		},

		hideConfirmationPopup: function() {
			$('.wbcr-clearfy-layer').fadeOut(100);
			var popupElem = $('.wbcr-clearfy-confirm-popup');

			popupElem.fadeOut(100, function() {
				popupElem.removeClass('wbcr-clearfy-default-warning-options');
				popupElem.removeClass('wbcr-clearfy-reset-warning-options');
			});

		},

		importOptions: function() {
			var self = this;

			$('.wbcr-clearfy-import-options-button').click(function() {
				var settings = $('#wbcr-clearfy-import-export').val(),
					$this = $(this);

				if( !settings ) {
					$.wbcr_factory_clearfy_206.app.showNotice('Import options is empty!', 'danger');
					return false;
				}

				if( void 0 == wbcr_clearfy_ajax || !wbcr_clearfy_ajax.import_options_nonce ) {
					$.wbcr_factory_clearfy_206.app.showNotice('Unknown Javascript error, most likely the wbcr_clearfy_ajax variable does not exist!', 'danger');
					return false;
				}

				$(this).prop('disabled', true);

				self.sendRequest({
					action: 'wbcr-clearfy-import-settings',
					_wpnonce: wbcr_clearfy_ajax.import_options_nonce,
					settings: settings
				}, function(response) {
					$this.prop('disabled', false);

					if( response.data.update_notice ) {
						if( !$('.wbcr-clr-update-package').length ) {
							$.wbcr_factory_clearfy_206.app.showNotice(response.data.update_notice);
						}
					} else {
						if( $('.wbcr-clr-update-package').length ) {
							$('.wbcr-clr-update-package').closest('.wbcr-factory-warning-notice').remove();
						}
					}
				});

				return false;
			});
		},
		sendRequest: function(request_data, beforeValidateCallback, successCallback) {
			var self = this;

			if( wbcr_clearfy_ajax === undefined ) {
				console.log('Undefinded wbcr_clearfy_ajax object.');
				return;
			}

			if( typeof request_data === 'object' ) {
				request_data.security = wbcr_clearfy_ajax.ajax_nonce;
			}

			$.ajax(ajaxurl, {
				type: 'post',
				dataType: 'json',
				data: request_data,
				success: function(data, textStatus, jqXHR) {
					var noticeId;

					beforeValidateCallback && beforeValidateCallback(data);

					if( !data || data.error ) {
						console.log(data);

						if( data ) {
							noticeId = $.wbcr_factory_clearfy_206.app.showNotice(data.error_message, 'danger');
						} else {
							if( void 0 != wbcr_clearfy_ajax ) {
								noticeId = $.wbcr_factory_clearfy_206.app.showNotice(wbcr_clearfy_ajax.i18n.unknown_error, 'danger');
							}
						}

						setTimeout(function() {
							$.wbcr_factory_clearfy_206.app.hideNotice(noticeId);
						}, 5000);
						return;
					}

					successCallback && successCallback(data);

					if( !request_data.flush_redirect ) {
						if( void 0 != wbcr_clearfy_ajax ) {
							noticeId = $.wbcr_factory_clearfy_206.app.showNotice(wbcr_clearfy_ajax.i18n.success_update_settings, 'success');

							setTimeout(function() {
								$.wbcr_factory_clearfy_206.app.hideNotice(noticeId);
							}, 5000);
						}
						return;
					}

					window.location.href = wbcr_clearfy_ajax.flush_cache_url;
					// открыть уведомление

				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);

					var noticeId = $.wbcr_factory_clearfy_206.app.showNotice('Error: [' + thrownError + '] Status: [' + xhr.status + '] Error massage: [' + xhr.responseText + ']', 'danger');
				}
			});
		}
	};

	$(document).ready(function() {
		general.init();
	});

})(jQuery);
