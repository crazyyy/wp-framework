<?php
/**
 * Plugin Name: Notifier To Slack
 *
 * @author            wpxpertise, devsabbirahmed
 * @copyright         2024- wpxpertise
 * @license           GPL-2.0-or-later
 * @package WP-Notifier-To-Slack
 *
 * @wordpress-plugin
 * Plugin Name: Notifier To Slack
 * Plugin URI: https://github.com/wpxpertise/
 * Description: Notifier To Slack allows users to receive instant notifications of their plugin activity, review and support requests directly in their Slack workspace.
 * Version:           2.13.1
 * Requires at least: 5.9
 * Requires PHP:      5.6
 * Author:            WPXpertise
 * Author URI:        https://wpxperties.com/
 * Text Domain:       wpnts
 * Domain Path: /languages/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'wpnts' ) );
}

if ( ! function_exists( 'nts_fs' ) ) {
	// Create a helper function for easy SDK access.
	function nts_fs() {
		global $nts_fs;

		if ( ! isset( $nts_fs ) ) {
			// Include Freemius SDK.
			require_once __DIR__ . '/freemius/start.php';

			$nts_fs = fs_dynamic_init( array(
				'id'                  => '14342',
				'slug'                => 'notifier-to-slack',
				'type'                => 'plugin',
				'public_key'          => 'pk_bc3d08a262990e44dee3cb5bb42a8',
				'is_premium'          => false,
				// If your plugin is a serviceware, set this option to false.
				'has_premium_version' => true,
				'has_addons'          => false,
				'has_paid_plans'      => true,
				// 'has_affiliation'     => 'selected',
				'menu'                => array(
					'slug'           => 'wpnts_notifier',
					'first-path'     => 'admin.php?page=wpnts_notifier',
					'contact'    => false,
					'support'        => false,
					'account'        => false,
				),
			) );
		}

		return $nts_fs;
	}

	// Init Freemius.
	nts_fs();
	// Signal that SDK was initiated.
	do_action( 'nts_fs_loaded' );
}

// If direct access than exit the file.
defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
define( 'WP_NOTIFIER_TO_SLACK_VERSION', '2.13.1' );
define( 'WP_NOTIFIER_TO_SLACK__FILE__', __FILE__ );
define( 'WP_NOTIFIER_TO_SLACK_DIR', __DIR__ );
define( 'WP_NOTIFIER_TO_SLACK_DIR_PATH', plugin_dir_path( WP_NOTIFIER_TO_SLACK__FILE__ ) );
define( 'WP_NOTIFIER_TO_SLACK_URL', plugins_url( '', __FILE__ ) );
define( 'WP_NOTIFIER_TO_SLACK_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_NOTIFIER_TO_SLACK_NAME', plugin_dir_url( __FILE__ ) );

if ( file_exists(__DIR__ . '/vendor/autoload.php') ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * All Namespace.
 */
use WPNTS\Inc\Ajax\Ajax;
use WPNTS\Inc\Theme;
use WPNTS\Inc\Route;
use WPNTS\Inc\Notify;
use WPNTS\Inc\Capcha;
use WPNTS\Inc\Enqueue;
use WPNTS\Inc\WPUpdate;
use WPNTS\Inc\Notices;
use WPNTS\Inc\Activate;
use WPNTS\Inc\DbTables;
use WPNTS\Inc\Deactivate;
use WPNTS\Inc\Database\DB;
use WPNTS\Inc\Maintenance;
use WPNTS\Inc\Integration;
use WPNTS\Inc\WooCommerce;
use WPNTS\Inc\PluginUpdate;
use WPNTS\Inc\AdminDashboard;
use WPNTS\Inc\BaseController;
use WPNTS\Inc\NotifierReview;
use WPNTS\Inc\NotifierSupport;
use WPNTS\Inc\SlackAttachment;


if ( ! class_exists('Notifier') ) {
	/**
	 * Main plugin class.
	 *
	 * @since 1.0.0
	 */
	class Notifier {
		/**
		 * Holds the plugin base file
		 *
		 * @since 1.0.0
		 * @var WPNTS
		 */
		public $WP_NOTIFIER_TO_SLACK;
		/**
		 * Constructor of the plugin.
		 *
		 * @since 1.0.0
		 * @var WPNTS
		 */
		public function __construct() {
			$this->includes();
			$this->WP_NOTIFIER_TO_SLACK = plugin_basename(__FILE__);
		}
		/**
		 * Register
		 */
		public function register() {
			add_action('plugins_loaded', [ $this, 'wpnts_load' ]);
			add_action('admin_init', [ $this, 'wpnts_plugin_activation' ]);
		}
		/**
		 * Main Plugin Textdomain.
		 */
		public static function wpnts_load() {
			load_plugin_textdomain('wpnts', false,__DIR__ . 'languages');
		}
		/**
		 * Classes instantiating here.
		 */
		public function includes() {
			new AdminDashboard();
			$enqueue = new Enqueue();
			$enqueue->register();

			new BaseController();
			new DbTables();
			new Route();
			
			

			// Calling Ajax.
			new Ajax();

			// Active and Deactivation notification.
			$active  = new Notify();
			$captchaactive  = new Capcha();
			$theme  = new Theme();
			
			$notice  = new Notices();

			// All plugin update notification.
			$update = new PluginUpdate();
			$update->wpnts_plugin_update_notification();

			// WordPress Core version update notification.
			$wpupdate = new WPUpdate();
			$wpupdate->wpnts_wordpress_core_update();

			// Plugin ORG support case notification.
			$load_support = new NotifierSupport();
			$load_support->wpnts_support_tickets();

			// Plugin review notification.
			$load_review = new NotifierReview();
			$load_review->wpnts_review_tickets();

			$maintenannotice_mode = new Maintenance();
			$integrations = new Integration();
			$woocoomerce_product = new WooCommerce();
			$slackattachment = new SlackAttachment();
		}
		/**
		 * While active the plugin redirect.
		 *
		 * @since 1.0.0
		 */

		public function wpnts_plugin_activation() {

			if ( ! get_option( 'NotifierActivationTime' ) ) {
				add_option( 'NotifierActivationTime', time() );
			}

			// Review Notice
			add_option( 'NotifierReviewNotice', 0 );
			add_option( 'DefaultNTReviewNoticeInterval', ( time() + 7 * 24 * 60 * 60 ) );

			// Upgrade notice options.
			add_option( 'NotifierUpgradeNotice', 0 );
			add_option( 'DefaultNTUpgradeInterval', ( time() + 10 * 24 * 60 * 60 ) );


			$redirect_to_admin_page = absint( get_option( 'nts_activation_redirect', 0 ) );

			if ( 1 === $redirect_to_admin_page ) {
				delete_option( 'nts_activation_redirect' );
				wp_safe_redirect( admin_url('admin.php?page=wpnts_notifier') );
				exit;
			}

		}
		/**
		 * Activation Hook
		 */
		public function wpnts_activate() {
			Activate::wpnts_activate();
		}
		/**
		 * Deactivation Hook
		 */
		public function wpnts_deactivate() {
			Deactivate::wpnts_deactivate();
		}
	}


	/**
	 * Instantiate an Object Class
	 */
	$wpnts = new Notifier();
	$wpnts->register();


	register_activation_hook (WP_NOTIFIER_TO_SLACK__FILE__, [ $wpnts, 'wpnts_activate' ] );
	register_deactivation_hook (WP_NOTIFIER_TO_SLACK__FILE__, [ $wpnts, 'wpnts_deactivate' ] );
}
