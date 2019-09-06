<?php
	/**
	 * Admin boot
	 * @author Webcraftic <alex.kovalevv@gmail.com>
	 * @copyright Webcraftic 25.05.2017
	 * @version 1.0
	 */

	require_once WUPM_PLUGIN_DIR . '/admin/includes/class.plugin-filters.php';
	require_once WUPM_PLUGIN_DIR . '/admin/includes/class.theme-filters.php';
	
	if( defined('LOADING_UPDATES_MANAGER_AS_ADDON') ) {
		/**
		 * This action is executed when the component of the Clearfy plugin is activate and if this component is name ga_cache
		 * @param string $component_name
		 */
		add_action('wbcr/clearfy/activated_component', function ($component_name) {
			if( $component_name == 'updates_manager' ) {
				if( class_exists('WCL_Plugin') ) {
					$license = WCL_Plugin::app()->getLicense();
					if( ($license->isLicenseValid() || (defined('WCL_PLUGIN_DEBUG') && WCL_PLUGIN_DEBUG)) && !WCL_Plugin::app()->isActivateComponent('updates-manager-premium') ) {
						WCL_Plugin::app()->activateComponent('updates-manager-premium');
					}
				}
			}
		});
		
		/**
		 * This action is executed when the component of the Clearfy plugin is activate and if this component is name ga_cache
		 * @param string $component_name
		 */
		add_action('wbcr_clearfy_deactivated_component', function ($component_name) {
			if( $component_name == 'updates_manager' ) {
				if( class_exists('WCL_Plugin') ) {
					$license = WCL_Plugin::app()->getLicense();
					if( ($license->isLicenseValid() || (defined('WCL_PLUGIN_DEBUG') && WCL_PLUGIN_DEBUG)) && WCL_Plugin::app()->isActivateComponent('updates-manager-premium') ) {
						WCL_Plugin::app()->deactivateComponent('updates-manager-premium');
					}
				}
			}
		});
	}

	/**
	 * Ошибки совместимости с похожими плагинами
	 */
	function wbcr_upm_admin_conflict_notices_error($notices, $plugin_name)
	{
		if( $plugin_name != WUPM_Plugin::app()->getPluginName() ) {
			return $notices;
		}

		$warnings = array();

		$default_notice = WUPM_Plugin::app()->getPluginTitle() . ': ' . __('We found that you have the plugin %s installed. The functions of this plugin already exist in %s. Please deactivate plugin %s to avoid conflicts between plugins\' functions.', 'webcraftic-updates-manager');
		$default_notice .= ' ' . __('If you do not want to deactivate the plugin %s for some reason, we strongly recommend do not use the same plugins\' functions at the same time!', 'webcraftic-updates-manager');

		if( is_plugin_active('companion-auto-update/companion-auto-update.php') ) {
			$warnings[] = sprintf($default_notice, 'Companion Auto Update', WUPM_Plugin::app()->getPluginTitle(), 'Companion Auto Update', 'Companion Auto Update');
		}

		if( is_plugin_active('disable-updates/disable-updates.php') ) {
			$warnings[] = sprintf($default_notice, 'Disable Updates', WUPM_Plugin::app()->getPluginTitle(), 'Disable Updates', 'Disable Updates');
		}

		if( is_plugin_active('disable-wordpress-updates/disable-updates.php') ) {
			$warnings[] = sprintf($default_notice, 'Disable All WordPress Updates', WUPM_Plugin::app()->getPluginTitle(), 'Disable All WordPress Updates', 'Disable All WordPress Updates');
		}

		if( is_plugin_active('stops-core-theme-and-plugin-updates/main.php') ) {
			$warnings[] = sprintf($default_notice, 'Easy Updates Manager', WUPM_Plugin::app()->getPluginTitle(), 'Easy Updates Manager', 'Easy Updates Manager');
		}

		if( empty($warnings) ) {
			return $notices;
		}
		$notice_text = '';
		foreach((array)$warnings as $warning) {
			$notice_text .= '<p>' . $warning . '</p>';
		}

		$notices[] = array(
			'id' => 'ump_plugin_compatibility',
			'type' => 'error',
			'dismissible' => true,
			'dismiss_expires' => 0,
			'text' => $notice_text
		);

		return $notices;
	}

	//add_action('admin_notices', 'wbcr_upm_admin_conflict_notices_error');
	add_filter('wbcr_factory_notices_407_list', 'wbcr_upm_admin_conflict_notices_error', 10, 2);

	function wbcr_upm_group_options($options)
	{
		$options[] = array(
			'name' => 'plugin_updates',
			'title' => __('Disable plugin updates', 'webcraftic-updates-manager'),
			'tags' => array('disable_all_updates'),
			'values' => array('disable_all_updates' => 'disable_plugin_updates')
		);
		$options[] = array(
			'name' => 'theme_updates',
			'title' => __('Disable theme updates', 'webcraftic-updates-manager'),
			'tags' => array('disable_all_updates'),
			'values' => array('disable_all_updates' => 'disable_theme_updates')
		);
		$options[] = array(
			'name' => 'auto_tran_update',
			'title' => __('Disable Automatic Translation Updates', 'webcraftic-updates-manager'),
			'tags' => array('disable_all_updates')
		);
		$options[] = array(
			'name' => 'wp_update_core',
			'title' => __('Disable wordPress core updates', 'webcraftic-updates-manager'),
			'tags' => array('disable_all_updates'),
			'values' => array('disable_all_updates' => 'disable_core_updates')
		);
		$options[] = array(
			'name' => 'enable_update_vcs',
			'title' => __('Enable updates for VCS Installations', 'webcraftic-updates-manager'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'plugins_update_filters',
			'title' => __('Plugin filters', 'webcraftic-updates-manager'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'updates_nags_only_for_admin',
			'title' => __('Updates nags only for Admin', 'webcraftic-updates-manager'),
			'tags' => array('recommended')
		);
		$options[] = array(
			'name' => 'disable_core_notifications',
			'title' => __('Core notifications', 'webcraftic-updates-manager'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'notify_updated',
			'title' => __('Notify me when update successful installed', 'webcraftic-updates-manager'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'notify_email',
			'title' => __('Email address', 'webcraftic-updates-manager'),
			'tags' => array()
		);

		return $options;
	}

	add_filter("wbcr_clearfy_group_options", 'wbcr_upm_group_options');

	function wbcr_upm_allow_quick_mods($mods)
	{
		$mods['disable_all_updates'] = array(
			'title' => __('One click disable all updates', 'webcraftic-updates-manager'),
			'icon' => 'dashicons-update'
		);

		return $mods;
	}

	add_filter("wbcr_clearfy_allow_quick_mods", 'wbcr_upm_allow_quick_mods');

	function wbcr_upm_set_plugin_meta($links, $file)
	{
		if( $file == WUPM_PLUGIN_BASE ) {

			$url = 'https://clearfy.pro';

			if( get_locale() == 'ru_RU' ) {
				$url = 'https://ru.clearfy.pro';
			}

			$url .= '?utm_source=wordpress.org&utm_campaign=' . WUPM_Plugin::app()->getPluginName();

			$links[] = '<a href="' . $url . '" style="color: #FF5722;font-weight: bold;" target="_blank">' . __('Get ultimate plugin free', 'webcraftic-updates-manager') . '</a>';
		}

		return $links;
	}

	if( !defined('LOADING_UPDATES_MANAGER_AS_ADDON') ) {
		add_filter('plugin_row_meta', 'wbcr_upm_set_plugin_meta', 10, 2);
	}

	/**
	 * Rating widget url
	 *
	 * @param string $page_url
	 * @param string $plugin_name
	 * @return string
	 */
	function wbcr_upm_rating_widget_url($page_url, $plugin_name)
	{
		if( !defined('LOADING_UPDATES_MANAGER_AS_ADDON') && ($plugin_name == WUPM_Plugin::app()->getPluginName()) ) {
			return 'https://goo.gl/Be2hQU';
		}

		return $page_url;
	}

	add_filter('wbcr_factory_pages_410_imppage_rating_widget_url', 'wbcr_upm_rating_widget_url', 10, 2);

	/**
	 * add link to Update manager and auto-update icons on default page "Plugins"
	 */
	function wbcr_upm_customize_plugin_page()
	{
		$screen = get_current_screen();

		if( !in_array($screen->id, array('plugins', 'plugins-network')) ) {
			return;
		}

		if( WUPM_Plugin::app()->isNetworkActive() && !is_network_admin() ) {
			return;
		}

		wp_enqueue_style('wbcr-upm-plugins', WUPM_PLUGIN_URL . '/admin/assets/css/plugins.css', array(), WUPM_Plugin::app()->getPluginVersion());
		wp_enqueue_script('wbcr-upm-plugins-js', WUPM_PLUGIN_URL . '/admin/assets/js/plugins.js', array('jquery'), WUPM_Plugin::app()->getPluginVersion());

        $pluginFilters = new WUPM_PluginFilters(WUPM_Plugin::app());
        $filters = $pluginFilters->getPlugins();

		$btn_title = __('Update manager', 'webcraftic-updates-manager');

		$btn_url = WUPM_Plugin::app()->getPluginPageUrl('plugins');

		ob_start();
		?>
        // l10n strings
        window.um_lang_text = window.um_lang_text || {};
        um_lang_text['default'] = '<?=__("Auto-update disabled", 'webcraftic-updates-manager');?>';
        um_lang_text['auto_update'] = '<?=__("Auto-update enabled", 'webcraftic-updates-manager');?>';
        um_lang_text['disable_updates'] = '<?=__("Update disabled", 'webcraftic-updates-manager');?>';
        um_lang_text['disable_tran_update'] = '<?=__("Translation update disabled", 'webcraftic-updates-manager');?>';

		jQuery(function($){
		var info = <?= json_encode(array(
		'filters' => $filters,
	)); ?>;
		um_add_plugin_icons(info);
		// um_add_plugin_actions("<?= $btn_title ?>", "<?= $btn_url ?>");
		});

		<?php
		$html = ob_get_clean();
		wp_add_inline_script('wbcr-upm-plugins-js', $html, 'after');
	}

	add_action('admin_enqueue_scripts', 'wbcr_upm_customize_plugin_page');

	/**
	 * add link to Update manager on default page "Themes"
	 */
	function wbcr_upm_customize_theme_page()
	{
		$screen = get_current_screen();
		if( $screen->id !== 'themes' ) {
			return;
		}

		if( WUPM_Plugin::app()->isNetworkActive() && !is_network_admin() ) {
			return;
		}

		wp_enqueue_style('wbcr-upm-plugins', WUPM_PLUGIN_URL . '/admin/assets/css/themes.css', array(), WUPM_Plugin::app()->getPluginVersion());
		wp_enqueue_script('wbcr-upm-themes-js', WUPM_PLUGIN_URL . '/admin/assets/js/themes.js', array('jquery'), WUPM_Plugin::app()->getPluginVersion());

		$btn_title = __('Update manager', 'webcraftic-updates-manager');

		$btn_url = WUPM_Plugin::app()->getPluginPageUrl('plugins');

		ob_start();
		?>


		jQuery(function($){
		 // window.um_add_theme_actions("<?= $btn_title ?>", "<?= $btn_url ?>");
		});

		<?php
		$html = ob_get_clean();
		wp_add_inline_script('wbcr-upm-themes-js', $html, 'after');
	}

	add_action('admin_enqueue_scripts', 'wbcr_upm_customize_theme_page');




