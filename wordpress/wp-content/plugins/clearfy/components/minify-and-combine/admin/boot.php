<?php
	/**
	 * Admin boot
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright Webcraftic 25.05.2017
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * Печатает ошибки совместимости с похожими плагинами
	 */
	add_action('wbcr_factory_notices_407_list', function ($notices, $plugin_name) {
		if( $plugin_name != WMAC_Plugin::app()->getPluginName() ) {
			return $notices;
		}

		if( is_plugin_active('autoptimize/autoptimize.php') ) {
			$notice_text = __('Clearfy: Minify and Combine component is not compatible with the Autoptimize plugin, please do not use them together to avoid conflicts. Please disable the Minify and Combine component', 'minify-and-combine');

			if( class_exists('WCL_Plugin') ) {
				$component_button = WCL_Plugin::app()->getInstallComponentsButton('internal', 'minify_and_combine');
				$notice_text .= ' ' . $component_button->getLink();
			}

			$notices[] = array(
				'id' => 'mac_plugin_compatibility',
				'type' => 'error',
				'classes' => array('wbcr-hide-after-action'),
				'dismissible' => false,
				'dismiss_expires' => 0,
				'text' => '<p>' . $notice_text . '</p>'
			);
		}

		return $notices;
	}, 10, 2);

	add_filter("wbcr_clearfy_group_options", function ($options) {
		/**
		 * Js optimize
		 */

		$options[] = array(
			'name' => 'js_optimize',
			'title' => __('Optimize JavaScript Code?', 'minify-and-combine'),
			'tags' => array('optimize_code', 'hide_my_wp')
		);
		$options[] = array(
			'name' => 'js_aggregate',
			'title' => __('Aggregate JS-files?', 'minify-and-combine'),
			'tags' => array('optimize_code')
		);
		$options[] = array(
			'name' => 'js_include_inline',
			'title' => __('Also aggregate inline JS?', 'minify-and-combine'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'js_forcehead',
			'title' => __('Force JavaScript in &lt;head&gt;?', 'minify-and-combine'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'js_exclude',
			'title' => __('Exclude scripts from Мinify And Combine:', 'minify-and-combine'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'js_trycatch',
			'title' => __('Add try-catch wrapping?', 'minify-and-combine'),
			'tags' => array()
		);
		/**
		 * CSS optimize
		 */
		$options[] = array(
			'name' => 'css_optimize',
			'title' => __('Optimize CSS Code?', 'minify-and-combine'),
			'tags' => array('optimize_code', 'hide_my_wp')
		);

		$options[] = array(
			'name' => 'css_aggregate',
			'title' => __('Aggregate CSS-files?', 'minify-and-combine'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'css_include_inline',
			'title' => __('Also aggregate inline CSS?', 'minify-and-combine'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'css_datauris',
			'title' => __('Generate data: URIs for images?', 'minify-and-combine'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'css_defer',
			'title' => __('Inline and Defer CSS?', 'minify-and-combine'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'css_inline',
			'title' => __('Inline all CSS?', 'minify-and-combine'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'css_exclude',
			'title' => __('Exclude CSS from Мinify And Combine', 'minify-and-combine'),
			'tags' => array()
		);

		return $options;
	});

	/**
	 * Adds a new mode to the Quick Setup page
	 *
	 * @param array $mods
	 * @return mixed
	 */

	add_filter("wbcr_clearfy_allow_quick_mods", function ($mods) {
		if( !defined('WHTM_PLUGIN_ACTIVE') ) {
			$title = __('One click optimize scripts (js, css)', 'minify-and-combine');
		} else {
			$title = __('One click optimize html code and scripts', 'minify-and-combine');
		}

		$mod['optimize_code'] = array(
			'title' => $title,
			'icon' => 'dashicons-performance'
		);

		return $mod + $mods;
	});
