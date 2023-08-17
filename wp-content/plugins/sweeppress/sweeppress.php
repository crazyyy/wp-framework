<?php

/**
 * Plugin Name:       SweepPress
 * Plugin URI:        https://sweep.press/
 * Description:       Remove various old, unused, or obsolete data from the database, optimize the database for the best website performance.
 * Author:            Milan Petrovic
 * Author URI:        https://www.dev4press.com/
 * Text Domain:       sweeppress
 * Version:           2.3
 * Requires at least: 5.5
 * Tested up to:      6.3
 * Requires PHP:      7.3
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package SweepPress
 *
 * == Copyright ==
 * Copyright 2008 - 2023 Milan Petrovic (email: support@dev4press.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 */

use Dev4Press\v42\WordPress;

$sweeppress_dirname_basic = dirname( __FILE__ ) . '/';
$sweeppress_urlname_basic = plugins_url( '/', __FILE__ );

define( 'SWEEPPRESS_PATH', $sweeppress_dirname_basic );
define( 'SWEEPPRESS_URL', $sweeppress_urlname_basic );
define( 'SWEEPPRESS_D4PLIB_PATH', $sweeppress_dirname_basic . 'd4plib/' );
define( 'SWEEPPRESS_D4PLIB_URL', $sweeppress_urlname_basic . 'd4plib/' );

if ( ! defined( 'SWEEPPRESS_SIMULATION' ) ) {
	define( 'SWEEPPRESS_SIMULATION', false );
}

if ( ! defined( 'SWEEPPRESS_SWEEPERS_ALLOW_DB' ) ) {
	define( 'SWEEPPRESS_SWEEPERS_ALLOW_DB', true );
}

require_once( SWEEPPRESS_D4PLIB_PATH . 'core.php' );

require_once( SWEEPPRESS_PATH . 'core/autoload.php' );
require_once( SWEEPPRESS_PATH . 'core/bridge.php' );
require_once( SWEEPPRESS_PATH . 'core/functions.php' );

sweeppress();
sweeppress_settings();

if ( WordPress::instance()->is_admin() ) {
	sweeppress_ajax();
	sweeppress_admin();
}
