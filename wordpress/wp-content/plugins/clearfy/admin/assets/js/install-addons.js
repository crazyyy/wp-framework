/**
 * This code provides tools for downloading, installing external add-ons for the Clearfy plugin
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 10.09.2017, Webcraftic
 * @version 1.0
 */


(function($) {
	'use strict';

	var externalAddon = {
		init: function() {
			this.events();
		},
		events: function() {
			var self = this;

			/**
			 * This event is intended for installation, removal, activation, deactivation of external add-ons
			 */

			$(document).on('click', '.wbcr-clr-update-component-button', function() {
				var $this = $(this),
					button_i18n = $(this).data('i18n'),
					plugin_slug = $(this).data('slug'),
					plugin_action = $(this).data('plugin-action'),
					plugin = $(this).data('plugin'),
					storage = $(this).data('storage'),
					wpnonce = $(this).data('wpnonce');

				var action = 'install-plugin';

				if( storage == 'freemius' || ((storage == 'wordpress' || storage == 'internal') && (plugin_action == 'activate' || plugin_action == 'deactivate')) ) {
					action = 'wbcr-clearfy-update-component';
				} else if( storage == 'wordpress' && plugin_action == 'delete' ) {
					action = 'delete-plugin';
				}

				var data = {
					action: action,
					slug: plugin_slug,
					storage: storage,
					plugin: plugin,
					plugin_action: plugin_action,
					_wpnonce: wpnonce
				};

				if( plugin_action == 'install' ) {
					$this.addClass('updating-message');
				}

				$this.addClass('disabled').text(button_i18n.loading);

				$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/pre_update', [$this, data]);

				self.sendRequest(data, function(response) {
					if( !response || !response.success ) {

						if( response.data && response.data.error_message ) {
							$.wbcr_factory_clearfy_206.app.showNotice(response.data.error_message, 'danger');
						}

						$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/update_error', [
							$this,
							data,
							response.data.error_message,
							response
						]);

						return;
					}

					if( response.success ) {
						$this.removeClass('disabled').removeClass('updating-message');

						if( storage == 'freemius' ) {
							if( response.data.update_notice ) {
								if( !$('.wbcr-clr-update-package').length ) {
									$.wbcr_factory_clearfy_206.app.showNotice(response.data.update_notice);
								}
							} else {
								if( $('.wbcr-clr-update-package').length ) {
									$('.wbcr-clr-update-package').closest('.wbcr-factory-warning-notice').remove();
								}
							}
						}

						if( plugin_action == 'install' ) {

							plugin_action = 'activate';
							$this.data('plugin-action', 'activate');
							$this.attr('data-plugin-action', 'activate');

							if( $this.hasClass('button') ) {
								$this.removeClass('button-default').addClass('button-primary');
							}

							$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/installed', [
								$this,
								data,
								response
							]);

						} else if( plugin_action == 'activate' ) {

							plugin_action = 'deactivate';
							$this.data('plugin-action', 'deactivate');
							$this.attr('data-plugin-action', 'deactivate');

							if( $this.hasClass('button') ) {
								$this.removeClass('button-primary').addClass('button-default');
							}

							// todo: вынести в отдельный файл
							// If the button is installed inside the notification,
							// then delete the button container after activating the component

							if( $this.closest('.wbcr-clr-new-component').length ) {
								$this.closest('.wbcr-clr-new-component').remove();
							}

							// todo: вынести в отдельный файл
							// If the button is installed inside the notification (inside),
							// then delete the button container after activating the component

							if( $this.closest('.alert').length ) {
								$this.closest('.alert').remove();
							}

							// todo: вынести в отдельный файл
							// If the button is installed inside the notification (inside),
							// then delete the button container after activating the component

							if( $this.closest('.wbcr-clearfy-fake-image-optimizer-board').length ) {
								$this.remove();
								window.location.reload();
							}

							// todo: вынести в отдельный файл
							// If the button is installed on the components page,
							// the active and inactive components are highlighted

							if( $this.closest('.plugin-card').length ) {
								self.setComponentActivate($this);
								$this.closest('.plugin-card').find('.delete-now').remove();
							}

							$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/pre_activate', [
								$this,
								data,
								response
							]);

							/**
							 * Send an additional request for activation of the component, during activation
							 * perform the action wbcr/clearfy/activated_component.
							 *
							 * Basically, this is necessary to prepare the plugin to work, write the necessary rows and
							 * tables in the database, rewriting permalinks, checking conflicts, etc.
							 */
							if( storage == 'freemius' || storage == 'internal' ) {
								self.sendRequestToComponentActivationPrepare($this, data, button_i18n);
								return;
							}

						} else if( plugin_action == 'deactivate' ) {

							plugin_action = 'activate';
							$this.data('plugin-action', 'activate');
							$this.attr('data-plugin-action', 'activate');

							if( $this.hasClass('button') ) {
								$this.removeClass('button-default').addClass('button-primary');
							}

							// todo: вынести в отдельный файл
							// If the button is installed on the components page,
							// the active and inactive components are highlighted

							if( $this.closest('.plugin-card').length ) {
								self.setComponentDeactivate($this);

								if( response.data['delete_button'] && response.data['delete_button'] != '' ) {
									$this.before($(response.data['delete_button']).addClass('delete-now'));
								}
							}

							// todo: вынести в отдельный файл
							// If the button is installed on the components page,
							// the active and inactive components are highlighted
							if( $this.closest('.wbcr-hide-after-action').length ) {
								$this.closest('.wbcr-hide-after-action').remove();
							}

							$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/deactivated', [
								$this,
								data,
								response
							]);

						} else if( plugin_action == 'delete' ) {

							plugin_action = 'install';
							$this.closest('.plugin-card').find('.install-now').data('plugin-action', 'install');
							$this.closest('.plugin-card').find('.install-now').attr('data-plugin-action', 'install');
							$this.closest('.plugin-card').find('.install-now').removeClass('button-primary').addClass('button-default');
							$this.closest('.plugin-card').find('.install-now').text(button_i18n.install);

							// todo: вынести в отдельный файл
							// If the button is installed on the components page,
							// the active and inactive components are highlighted

							if( $this.closest('.plugin-card').length ) {
								self.setComponentDeactivate($this);
								$this.remove();
							}

							$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/deleted', [$this, data, response]);
						}
					} else {
						if( plugin_action == 'install' ) {
							$this.removeClass('updating-message');
						}
					}

					$this.text(button_i18n[plugin_action]);

					if( response.data.need_rewrite_rules && !$('.wbcr-clr-need-rewrite-rules-message').length ) {
						$.wbcr_factory_clearfy_206.app.showNotice(response.data.need_rewrite_rules, 'warning');
					}

					$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/updated', [$this, data, response]);
				});

				return false;
			});

			$(document).on('click', '.wbcr-clr-plugin-update-link', function() {
				var $this = $(this),
					loading = $(this).data('loading'),
					success_msg = $(this).data('ok'),
					wpnonce = $(this).data('wpnonce'),
					container = $this.closest('p');

				var data = {
					action: 'wbcr-clearfy-update-package',
					_wpnonce: wpnonce
				};

				container.text(loading);

				self.sendRequest(data, function(response) {
					if( !response || !response.success ) {
						if( response.data && response.data.error_message ) {
							$.wbcr_factory_clearfy_206.app.showNotice(response.data.error_message, 'danger');
						}
						return;
					}

					if( response.success ) {
						container.closest('div').removeClass('notice-warning').addClass('notice-success');
						container.text(success_msg);
					} else {
						container.text(response.data.msg);
					}
				});

				return false;
			});
		},

		/**
		 * Устанавливает стиль компонента
		 *
		 * @param {object} componentButton
		 */
		setComponentDeactivate: function(componentButton) {
			componentButton.closest('.plugin-card').addClass('plugin-status-deactive');
		},

		/**
		 * Устанавливает стиль компонента
		 *
		 * @param {object} componentButton
		 */
		setComponentActivate: function(componentButton) {
			componentButton.closest('.plugin-card').removeClass('plugin-status-deactive');
		},

		/**
		 * Отправляет дополнительный запрос на активацию компонента, во время активации
		 * выполняет хук wbcr/clearfy/activated_component.
		 *
		 * В принципе, это необходимо для подготовки плагина к работе, записи необходимых строк и таблиц в
		 * базу данных, перепись постоянных ссылок, проверка конфликтов и т.д.
		 *
		 * @param {object} componentButton
		 * @param {object} sendData
		 * @param {object} button_i18n
		 */
		sendRequestToComponentActivationPrepare: function(componentButton, sendData, button_i18n) {
			var self = this;

			componentButton.addClass('button-primary')
				.addClass('disabled')
				.text(button_i18n.preparation);

			sendData.action = 'wbcr-clearfy-prepare-component';

			this.sendRequest(sendData, function(response) {
				componentButton.removeClass('disabled');

				if( !response || !response.success ) {
					componentButton.text(button_i18n['activate']);
					self.setComponentDeactivate(componentButton);

					if( response.data && response.data.error_message ) {
						$.wbcr_factory_clearfy_206.app.showNotice(response.data.error_message, 'danger');
					}

					$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/activated_error', [sendData.plugin]);
					return;
				}

				componentButton.removeClass('button-primary').text(button_i18n['deactivate']);
				self.setComponentActivate(componentButton);

				$.wbcr_factory_clearfy_206.hooks.run('clearfy/components/activated', [sendData.plugin]);
			});
		},

		sendRequest: function(data, callback) {
			var self = this;

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

					$.wbcr_factory_clearfy_206.app.showNotice('Error: [' + thrownError + '] Status: [' + xhr.status + '] Error massage: [' + xhr.responseText + ']', 'danger');
				}
			});
		}
	};

	$(document).ready(function() {
		externalAddon.init();
	});

})(jQuery);
