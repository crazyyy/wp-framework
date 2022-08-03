<?php
/**
 * Factory Metaboxes
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>
 * @since         1.0.0
 * @package       factory-metaboxes
 * @copyright (c) 2018, Webcraftic Ltd
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// module provides function only for the admin area
if ( ! is_admin() ) {
	return;
}

if ( defined( 'FACTORY_METABOXES_413_LOADED' ) ) {
	return;
}

define( 'FACTORY_METABOXES_413_VERSION', '4.1.3' );

define( 'FACTORY_METABOXES_413_LOADED', true );

define( 'FACTORY_METABOXES_413_DIR', dirname( __FILE__ ) );
define( 'FACTORY_METABOXES_413_URL', plugins_url( null, __FILE__ ) );

#comp merge
require( FACTORY_METABOXES_413_DIR . '/metaboxes.php' );
require( FACTORY_METABOXES_413_DIR . '/metabox.class.php' );
require( FACTORY_METABOXES_413_DIR . '/includes/form-metabox.class.php' );
require( FACTORY_METABOXES_413_DIR . '/includes/publish-metabox.class.php' );
#endcomp