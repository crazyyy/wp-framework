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

	if( defined('FACTORY_NOTICES_410_LOADED') ) {
		return;
	}

	define('FACTORY_NOTICES_410_LOADED', true);

	define('FACTORY_NOTICES_410_VERSION', '4.1.0');

	define('FACTORY_NOTICES_410_DIR', dirname(__FILE__));
	define('FACTORY_NOTICES_410_URL', plugins_url(null, __FILE__));

	#comp merge
	require_once(FACTORY_NOTICES_410_DIR . '/notices.php');
	#endcomp