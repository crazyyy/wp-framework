<?php
/**
 * Factory Shortcodes
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>
 * @since         1.0.0
 * @package       factory-shortcodes
 * @copyright (c) 2018, Webcraftic Ltd
 *
 */

if ( defined( 'FACTORY_SHORTCODES_333_LOADED' ) ) {
	return;
}

define( 'FACTORY_SHORTCODES_333_VERSION', '3.3.3' );

define( 'FACTORY_SHORTCODES_333_LOADED', true );

define( 'FACTORY_SHORTCODES_333_DIR', dirname( __FILE__ ) );

#comp merge
require( FACTORY_SHORTCODES_333_DIR . '/shortcodes.php' );
require( FACTORY_SHORTCODES_333_DIR . '/shortcode.class.php' );
#endcomp
