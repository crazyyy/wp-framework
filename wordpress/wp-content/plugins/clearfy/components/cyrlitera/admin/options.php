<?php
	/**
	 * Options for additionally form
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 21.01.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * @param $form
	 * @param $page Wbcr_FactoryPages410_ImpressiveThemplate
	 * @return mixed
	 */
	/*function wbcr_cyrlitera_seo_form_options($form, $page)
	{
		if( empty($form) ) {
			return $form;
		}

		$options = wbcr_cyrlitera_get_plugin_options();

		foreach(array_reverse($options) as $option) {
			array_unshift($form[0]['items'], $option);
		}

		return $form;
	}

	add_filter('wbcr_clr_seo_form_options', 'wbcr_cyrlitera_seo_form_options', 10, 2);*/
