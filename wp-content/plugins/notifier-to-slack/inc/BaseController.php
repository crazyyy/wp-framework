<?php
/**
 * Admin Chat Box Basecontrol
 *
 * This class is used to based control
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use WPNTS\Inc\nts_fs;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * BaseController Class
 *
 * @since 1.0.0
 */
class BaseController {
	/**
	 * $plugin_url Holds the path of the root directory.
	 *
	 * @var Admin
	 * @since 1.0.0
	 */
	public $plugin_url;
	/**
	 * $plugin Holds the path of the Inc directory.
	 *
	 * @var Admin
	 * @since 1.0.0
	 */

	public $plugin;
	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin_url = plugin_dir_url( __DIR__ );
		$this->plugin = plugin_dir_url(__FILE__); // inc.
	}
}
