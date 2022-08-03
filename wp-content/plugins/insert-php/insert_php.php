<?php
/**
 * Plugin Name: Woody code snippets (PHP snippets | Insert PHP)
 * Plugin URI: https://woodysnippet.com/
 * Description: Executes PHP code, uses conditional logic to insert ads, text, media content and external service’s code. Ensures no content duplication.
 * Author: Creative Motion, Will Bontrager Software, LLC <will@willmaster.com>
 * Version: 2.4.6
 * Text Domain: insert-php
 * Domain Path: /languages/
 * Author URI: https://cm-wp.com
 */

/**
 * Developers who contributions in the development plugin:
 *
 * Will Bontrager
 * ---------------------------------------------------------------------------------
 * 1.0.0v - 1.3.0v Developed the first plugin version, which was named Insert php.
 * This was the founder of this plugin.
 *
 * If you are a long-term user, you may be confused about the new plugin update.
 * You’ve been using an old plugin – Insert php 1.3.0, and now got an extended
 * product – Woody Code Snippets. Insert php was the first plugin version to work
 * with PHP code. It was created by Will Bontrager Software, LLC. In 2018, the
 * Webcraftic studio started to actively develop the plugin. We’ve created a
 * roadmap and released several powerful updates that help you to use PHP code
 * more comfortable and secure. Now plugin supports not only PHP but other
 * snippet types as well. We’ve decided to rename the plugin as Woody ad
 * snippets. This name is more suitable for new and powerful plugin features.
 *
 * More information about the Insert PHP plugin can be found here:
 * http://www.willmaster.com/software/WPplugins/go/iphphome_iphplugin
 * ---------------------------------------------------------------------------------
 *
 * Alexander Kovalev
 * ---------------------------------------------------------------------------------
 * 1.3.0v - 2.0.6v. - Developed framework, plugin interface and plugin development.
 * 2.0.6v. - 2.2.5v - Fix bugs, improvement some code parts for the plugin.
 *
 * Email:         alex.kovalevv@gmail.com
 * Personal card: https://alexkovalevv.github.io
 * Personal repo: https://github.com/alexkovalevv
 * ---------------------------------------------------------------------------------
 *
 * Alexander Vitkalov
 * ---------------------------------------------------------------------------------
 * 2.0.6v. - 2.2.5v - Development conditional logic for some snippets, added new snippets types,
 * development snippets library, development import/export.
 *
 * Personal repo: https://github.com/nechin
 * ---------------------------------------------------------------------------------
 *
 * Artem Prihodko
 * ---------------------------------------------------------------------------------
 * 2.3.2v - current
 *
 * Email:         webtemyk@yandex.ru
 * Personal repo: https://github.com/temyk
 * ---------------------------------------------------------------------------------
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// @formatter:off



/**
 * -----------------------------------------------------------------------------
 * CHECK REQUIREMENTS
 * Check compatibility with php and wp version of the user's site. As well as checking
 * compatibility with other plugins from Webcraftic.
 * -----------------------------------------------------------------------------
 */

require_once dirname( __FILE__ ) . '/libs/factory/core/includes/class-factory-requirements.php';

$plugin_info = [
	'prefix'               => 'wbcr_inp_',
	'plugin_name'          => 'wbcr_insert_php',
	'plugin_title'         => __( 'Woody Code Snippets', 'insert-php' ),
	'plugin_text_domain'   => 'insert-php',

	// PLUGIN SUPPORT
	'support_details'      => [
		'url'           => 'https://r.freemius.com/3465/1916966/https://woodysnippet.com',
		'affiliate_url' => 'https://r.freemius.com/3465/1916966/',
		'pages_map'     => [
			'features' => 'premium-features',                       // {site}/premium-features
			'pricing'  => 'pricing',                                // {site}/prices
			'support'  => 'support',                                // {site}/support
			'docs'     => 'getting-started-with-woody-ad-snippets', // {site}/docs
		],
	],

	// PLUGIN ADVERTS
	'render_adverts'       => true,
	'adverts_settings'     => [
		'dashboard_widget' => true, // show dashboard widget (default: false)
		'right_sidebar'    => true, // show adverts sidebar (default: false)
		'notice'           => true, // show notice message (default: false)
	],

	// PLUGIN UPDATED SETTINGS
	/*
	'has_updates'          => false,
	'updates_settings'     => array(
		'repository'        => 'wordpress',
		'slug'              => 'woody-ad-snippets',
		'maybe_rollback'    => true,
		'rollback_settings' => array(
			'prev_stable_version' => '0.0.0',
		),
	),*/

	// PLUGIN PREMIUM SETTINGS
	'has_premium'          => true,
	'license_settings'     => [
		'provider'         => 'freemius',
		'slug'             => 'woody-ad-snippets-premium',
		'plugin_id'        => '3465',
		'public_key'       => 'pk_fc5703fe4f4fbc3e87f17fce5e0b8',
		'price'            => 19,
		'has_updates'      => true,
		'updates_settings' => [
			'maybe_rollback'    => true,
			'rollback_settings' => [
				'prev_stable_version' => '0.0.0',
			],
		],
	],

	// FRAMEWORK MODULES
	'load_factory_modules' => [
		[ 'libs/factory/bootstrap', 'factory_bootstrap_458', 'admin' ],
		[ 'libs/factory/forms', 'factory_forms_454', 'admin' ],
		[ 'libs/factory/pages', 'factory_pages_456', 'admin' ],
		[ 'libs/factory/types', 'factory_types_413' ],
		[ 'libs/factory/taxonomies', 'factory_taxonomies_333' ],
		[ 'libs/factory/metaboxes', 'factory_metaboxes_413', 'admin' ],
		[ 'libs/factory/viewtables', 'factory_viewtables_413', 'admin' ],
		[ 'libs/factory/shortcodes', 'factory_shortcodes_333', 'all' ],
		[ 'libs/factory/freemius', 'factory_freemius_144', 'all' ],
		[ 'libs/factory/adverts', 'factory_adverts_134', 'admin' ],
		[ 'libs/factory/feedback', 'factory_feedback_117', 'admin' ],
	],
];

/**
 * Checks compatibility with WordPress, php and other plugins.
 */
$wbcr_compatibility = new Wbcr_Factory457_Requirements( __FILE__, array_merge( $plugin_info, [
	'plugin_already_activate' => defined( 'WINP_PLUGIN_ACTIVE' ),
	'required_php_version'    => '7.0',
	'required_wp_version'     => '4.8.0',
] ) );

/**
 * If the plugin is compatible, it will continue its work, otherwise it will be stopped and the user will receive a warning.
 */
if ( ! $wbcr_compatibility->check() ) {
	return;
}

global $wbcr_inp_safe_mode;

$wbcr_inp_safe_mode = false;

// Set the constant that the plugin is activated
define( 'WINP_PLUGIN_ACTIVE', true );

define( 'WINP_PLUGIN_VERSION', $wbcr_compatibility->get_plugin_version() );

// Root directory of the plugin
define( 'WINP_PLUGIN_DIR', dirname( __FILE__ ) );

// Absolute url of the root directory of the plugin
define( 'WINP_PLUGIN_URL', plugins_url( null, __FILE__ ) );

// Relative url of the plugin
define( 'WINP_PLUGIN_BASE', plugin_basename( __FILE__ ) );

// The type of posts used for snippets types
define( 'WINP_SNIPPETS_POST_TYPE', 'wbcr-snippets' );

// The taxonomy used for snippets types
define( 'WINP_SNIPPETS_TAXONOMY', 'wbcr-snippet-tags' );

// The snippets types
define( 'WINP_SNIPPET_TYPE_PHP', 'php' );
define( 'WINP_SNIPPET_TYPE_TEXT', 'text' );
define( 'WINP_SNIPPET_TYPE_UNIVERSAL', 'universal' );
define( 'WINP_SNIPPET_TYPE_CSS', 'css' );
define( 'WINP_SNIPPET_TYPE_JS', 'js' );
define( 'WINP_SNIPPET_TYPE_HTML', 'html' );
define( 'WINP_SNIPPET_TYPE_AD', 'advert' );

require_once WINP_PLUGIN_DIR . '/libs/factory/core/boot.php';
require_once WINP_PLUGIN_DIR . '/includes/compat.php';
require_once WINP_PLUGIN_DIR . '/includes/class.insertion.locations.php';
require_once WINP_PLUGIN_DIR . '/includes/class.helpers.php';
require_once WINP_PLUGIN_DIR . '/includes/class.plugin.php';

/*
 * Woocommerce Insertion location
 * @since 2.4
 * */

global $winp_snippets_locations;
$winp_snippets_locations = new WINP_Insertion_Locations();

try {
	new WINP_Plugin( __FILE__, array_merge( $plugin_info, [
		'plugin_version'     => WINP_PLUGIN_VERSION,
		'plugin_text_domain' => $wbcr_compatibility->get_text_domain(),
	] ) );
} catch ( Exception $exception ) {
	// Plugin wasn't initialized due to an error
	define( 'WINP_PLUGIN_THROW_ERROR', true );

	$wbcr_plugin_error_func = function () use ( $exception ) {
		$error = sprintf( 'The %s plugin has stopped. <b>Error:</b> %s Code: %s', 'Woody Ad Snippets', $exception->getMessage(), $exception->getCode() );
		echo '<div class="notice notice-error"><p>' . $error . '</p></div>';
	};

	add_action( 'admin_notices', $wbcr_plugin_error_func );
	add_action( 'network_admin_notices', $wbcr_plugin_error_func );
}
// @formatter:on
