<?php
	/**
	 * Compatibility with Clearfy old components
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 22.10.2018, Webcraftic
	 * @version 1.0
	 */

	add_action('plugins_loaded', function () {
		if( defined('WIO_PLUGIN_ACTIVE') ) {
			if( !file_exists(WP_PLUGIN_DIR . '/robin-image-optimizer/robin-image-optimizer.php') ) {
				return;
			}

			$plugin = get_plugin_data(WP_PLUGIN_DIR . '/robin-image-optimizer/robin-image-optimizer.php');

			if( isset($plugin['Version']) && version_compare($plugin['Version'], '1.0.8', '<=') ) {
				$notice = __('Please update the plugin Robin image Optimizer to the latest version, as it may not work correctly with the new version of Clearfy!', 'clearfy');
				/**
				 * Выводит уведомление внутри интерфейса Clearfy, на всех страницах плагина.
				 * Это необходимо, чтоб напомнить пользователю обновить конфигурацию компонентов плагина,
				 * иначе вновь активированные компоненты не будет зайдествованы в работе плагина.
				 *
				 * @param Wbcr_Factory409_Plugin $plugin
				 * @param Wbcr_FactoryPages410_ImpressiveThemplate $obj
				 * @return bool
				 */
				add_action('wbcr/factory/pages/impressive/print_all_notices', function ($plugin, $obj) use ($notice) {
					$obj->printErrorNotice($notice);
				}, 10, 2);

				// Специально для преидущей версии фреймворка (407)
				add_action('wbcr_factory_pages_407_imppage_print_all_notices', function ($plugin, $obj) use ($notice) {
					$obj->printErrorNotice($notice);
				}, 10, 2);
			}
		}

		if( defined('WHLP_PLUGIN_ACTIVE') ) {
			if( !file_exists(WP_PLUGIN_DIR . '/hide-login-page/hide-login-page.php') ) {
				return;
			}

			$plugin = get_plugin_data(WP_PLUGIN_DIR . '/hide-login-page/hide-login-page.php');

			if( isset($plugin['Version']) && version_compare($plugin['Version'], '1.0.5', '<=') ) {
				$notice = __('Please update the plugin Hide login page to the latest version, as it may not work correctly with the new version of Clearfy!', 'clearfy');
				/**
				 * Выводит уведомление внутри интерфейса Clearfy, на всех страницах плагина.
				 * Это необходимо, чтоб напомнить пользователю обновить конфигурацию компонентов плагина,
				 * иначе вновь активированные компоненты не будет зайдествованы в работе плагина.
				 *
				 * @param Wbcr_Factory409_Plugin $plugin
				 * @param Wbcr_FactoryPages410_ImpressiveThemplate $obj
				 * @return bool
				 */
				add_action('wbcr/factory/pages/impressive/print_all_notices', function ($plugin, $obj) use ($notice) {
					$obj->printErrorNotice($notice);
				}, 10, 2);

				// Специально для преидущей версии фреймворка (407)
				add_action('wbcr_factory_pages_407_imppage_print_all_notices', function ($plugin, $obj) use ($notice) {
					$obj->printErrorNotice($notice);
				}, 10, 2);
			}
		}
	});

	/**
	 * Дополнительная подсказка, что форма импорта, экспорта перемещена
	 */
	add_action('admin_enqueue_scripts', function ($page_id) {

		if( !WbcrFactoryClearfy206_Helpers::strContains($page_id, WCL_Plugin::app()->getPluginName()) ) {
			return;
		}

		wp_enqueue_style('wp-pointer');
		wp_enqueue_script('wp-pointer');

		add_action('admin_print_footer_scripts', function () {
			$dismissed_pointers = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));

			$pointer_setting_content = "<h3>" . sprintf(__('Welcome to Clearfy (%s)', 'clearfy'), '1.4.x') . "</h3>";
			$pointer_setting_content .= "<p>" . __('We moved the form to import and export plugin settings to another page. Now all settings that relate only to the Clearfy plugin, we will post on this additional page.', 'clearfy') . "</p>";

			?>
			<script>
				//<![CDATA[
				jQuery(document).ready(function($) {
					<?php if( !in_array('wbcr_clearfy_settings_pointer_1_4_2', $dismissed_pointers) ): ?>
					$('.wbcr-factory-type-settings').pointer({
						content: '<?php echo $pointer_setting_content; ?>',
						position: {
							edge: 'top', // arrow direction
							align: 'center' // vertical alignment
						},
						pointerWidth: 350,
						close: function() {
							$.post(ajaxurl, {
								pointer: 'wbcr_clearfy_settings_pointer_1_4_2', // pointer ID
								action: 'dismiss-wp-pointer'
							});
						}
					}).pointer('open');
					<?php endif; ?>
				});
				//]]>
			</script>
		<?php
		}, 20);
	});