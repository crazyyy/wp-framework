<?php
	/**
	 * Factory Notices
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018 Webcraftic Ltd
	 *
	 * @package factory-notices
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	// module provides function only for the admin area
	if( !is_admin() ) {
		return;
	}

	if( defined('FACTORY_NOTICES_407_LOADED') ) {
		return;
	}

	define('FACTORY_NOTICES_407_LOADED', true);

	define('FACTORY_NOTICES_407_VERSION', '4.0.7');

	define('FACTORY_NOTICES_407_DIR', dirname(__FILE__));
	define('FACTORY_NOTICES_407_URL', plugins_url(null, __FILE__));

	#comp merge
	require_once(FACTORY_NOTICES_407_DIR . '/notices.php');
	#endcomp