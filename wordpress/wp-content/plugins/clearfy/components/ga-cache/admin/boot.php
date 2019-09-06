<?php
/**
 * The boot file is needed to connect backend files, as well as register hooks.
 * Some hooks are so small that it does not make sense to put them into a file
 * or put them into a specific group of code.
 *
 * I usually register administrator notifications, create handlers before saving
 * plugin settings or after, register options in the Clearfy plugin.
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>, Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright Webcraftic
 * @version 1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Notice that the plugin has been seriously updated!
 *
 * @param array $notices all registered notices
 * @param string $plugin_name
 *
 * @since 3.0.1
 * @return array all notices
 */
function wbcr_ga_admin_conflict_notices_error( $notices, $plugin_name ) {
	if ( defined( 'LOADING_GA_CACHE_AS_ADDON' ) || $plugin_name != WGA_Plugin::app()->getPluginName() ) {
		return $notices;
	}
	
	$text = '<p>' . __( 'The <b>Simple Google Analytics</b> plugin has some major changes!', 'simple-google-analytics' ) . '</p>';
	$text .= '<p>' . __( 'Unfortunately, the old version of the plugin (2.2.2) is no longer supported, but you still can download it from the WordPress repository in case if the new release doesn’t work for you.', 'simple-google-analytics' ) . '</p>';
	$text .= '<p>' . __( 'We’ve updated the code and fixed the compatibility issue for the latest WordPress and PHP versions. We’ve also added additional feature of the Local Google Analytics – this way your website will load faster. The plugin’s name has been changed to Local Google Analytics, but all features remained the same.', 'simple-google-analytics' ) . '</p>';
	$text .= '<p>' . sprintf( __( 'Please, check <a href="%s">plugin settings</a> and its performance on your website. We do care about you and want to avoid any problems with the new version.', 'simple-google-analytics' ) . '</p>', admin_url( 'options-general.php?page=ga_cache-' . WGA_Plugin::app()->getPluginName() ) ) . '</p>';
	$text .= '<p>' . sprintf( __( 'We are aimed to pay more attention to the speed and security aspects of your website. That’s why you should definitely try our basic WordPress optimization plugin as well. Clearfy includes functionality of this plugin and has many additional features for the website optimization:
<a href="%s">Donwload Clearfy for free</a>', 'simple-google-analytics' ), 'https://clearfy.pro?utm_source=wordpress.org&utm_campaign=' . WGA_Plugin::app()->getPluginName() ) . '</p>';
	
	$notices[] = array(
		'id'              => 'ga_plugin_upgrade_notice1',
		'type'            => 'warning',
		'dismissible'     => true,
		'dismiss_expires' => 0,
		'text'            => $text
	);
	
	return $notices;
}

add_filter( 'wbcr_factory_notices_407_list', 'wbcr_ga_admin_conflict_notices_error', 10, 2 );

/**
 * Migrate settings from the old plugin to the new one.
 *
 * @since 3.0.1
 * @return void
 */
function wbcr_ga_upgrade() {
	global $wpdb;
	
	if ( defined( 'LOADING_GA_CACHE_AS_ADDON' ) ) {
		return;
	}
	
	$is_migrate_up_to_230 = WGA_Plugin::app()->getPopulateOption( 'is_migrate_up_to_230', false );
	
	if ( ! $is_migrate_up_to_230 ) {
		$old_plugin_tracking_id              = get_option( 'sga_analytics_id' );
		$old_plugin_code_location            = get_option( 'sga_code_location' );
		$old_plugin_demographic_and_interest = (int) get_option( 'sga_demographic_and_interest' );
		$old_plugin_sga_render_when_loggedin = (int) get_option( 'sga_render_when_loggedin' );
		
		if ( ! empty( $old_plugin_tracking_id ) ) {
			WGA_Plugin::app()->updatePopulateOption( 'ga_cache', 1 );
			WGA_Plugin::app()->updatePopulateOption( 'ga_tracking_id', $old_plugin_tracking_id );
			
			$script_position = 'footer';
			
			if ( $old_plugin_code_location == 'head' ) {
				$script_position = 'header';
			}
			
			WGA_Plugin::app()->updatePopulateOption( 'ga_script_position', $script_position );
			WGA_Plugin::app()->updatePopulateOption( 'ga_anonymize_ip', $old_plugin_demographic_and_interest );
			WGA_Plugin::app()->updatePopulateOption( 'ga_track_admin', $old_plugin_sga_render_when_loggedin );
			
			$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'sga_%';" );
		}
		
		WGA_Plugin::app()->updatePopulateOption( 'is_migrate_up_to_230', 1 );
	}
}

add_action( 'init', 'wbcr_ga_upgrade' );

/**
 * After saving the settings in the plugin, we check whether the
 * options for analytic caching are enabled or not. If enabled,
 * add cron task.
 *
 * @param Wbcr_Factory409_Plugin $plugin *
 * @param Wbcr_FactoryPages410_ImpressiveThemplate $page
 *
 * @since 3.0.1
 * @return void
 */
add_action( 'wbcr_factory_409_imppage_after_form_save', function ( $plugin, $page ) {
	if ( WGA_Plugin::app()->getPluginName() != $plugin->getPluginName() ) {
		return;
	}
	
	$ga_cache = WGA_Plugin::app()->getPopulateOption( 'ga_cache' );
	
	if ( $ga_cache ) {
		if ( ! wp_next_scheduled( 'wbcr/gac/update_analytic_library' ) ) {
			wp_schedule_event( time(), 'daily', 'wbcr/gac/update_analytic_library' );
		}
	} else {
		if ( wp_next_scheduled( 'wbcr/gac/update_analytic_library' ) ) {
			wp_clear_scheduled_hook( 'wbcr/gac/update_analytic_library' );
		}
	}
}, 10, 2 );

/**
 * This action is executed when the component of the Clearfy plugin
 * is activate and if this component is name ga_cache
 *
 * @since 3.0.1
 * @return void
 */
add_action( 'wbcr/clearfy/activated_component', function ( $component_name ) {
	if ( $component_name == 'ga_cache' ) {
		require_once WGA_PLUGIN_DIR . '/admin/activation.php';
		$plugin = new WGA_Activation( WGA_Plugin::app() );
		$plugin->activate();
	}
} );

/**
 * This action is executed when the component of the Clearfy plugin
 * is deactivated and if this component is name ga_cache
 *
 * @since 3.0.1
 * @return void
 */
add_action( 'wbcr_clearfy_pre_deactivate_component', function ( $component_name ) {
	if ( $component_name == 'ga_cache' ) {
		require_once WGA_PLUGIN_DIR . '/admin/activation.php';
		$plugin = new WGA_Activation( WGA_Plugin::app() );
		$plugin->deactivate();
	}
} );

/**
 * We register options of this plugin in global Clearfy options. Clearfy later can automatically
 * set default values for this options or completely delete it from site database.
 *
 * In more detail you can read about it here: wp-plugin-clearfy\admin\includes\options.php
 *
 * @param array $options all available component options plugin clearfy
 *
 * @return array
 */
function wbcr_ga_group_options( $options ) {
	$options[] = array(
		'name'  => 'ga_cache',
		'title' => __( 'Google Analytics Cache', 'simple-google-analytics' ),
		'tags'  => array()
	);
	
	$options[] = array(
		'name'  => 'ga_tracking_id',
		'title' => __( 'Google analytic Code', 'clearfy' ),
		'tags'  => array()
	);
	$options[] = array(
		'name'  => 'ga_adjusted_bounce_rate',
		'title' => __( 'Use adjusted bounce rate?', 'clearfy' ),
		'tags'  => array()
	);
	$options[] = array(
		'name'  => 'ga_enqueue_order',
		'title' => __( 'Change enqueue order?', 'clearfy' ),
		'tags'  => array()
	);
	$options[] = array(
		'name'  => 'ga_disable_display_features',
		'title' => __( 'Disable all display features functionality?', 'clearfy' ),
		'tags'  => array()
	);
	$options[] = array(
		'name'  => 'ga_anonymize_ip',
		'title' => __( 'Use Anonymize IP? (Required by law for some countries)', 'clearfy' ),
		'tags'  => array()
	);
	$options[] = array(
		'name'  => 'ga_track_admin',
		'title' => __( 'Track logged in Administrators?', 'clearfy' ),
		'tags'  => array()
	);
	
	return $options;
}

add_filter( "wbcr_clearfy_group_options", 'wbcr_ga_group_options' );

if ( ! defined( 'LOADING_GA_CACHE_AS_ADDON' ) ) {
	/**
	 * Add a link to plugin meta. You can find this link in admin panel on
	 * the page plugins.php. Look under plugin short description.
	 *
	 * @param array $links An array of the plugin's metadata, including the version,
	 *              author, author URI, and plugin URI.
	 * @param string $file path to the plugin file, relative to the plugins directory.
	 *
	 * @return array
	 */
	function wbcr_ga_set_plugin_meta( $links, $file ) {
		if ( $file == WGA_PLUGIN_BASE ) {
			
			$url = 'https://clearfy.pro';
			
			if ( get_locale() == 'ru_RU' ) {
				$url = 'https://ru.clearfy.pro';
			}
			
			$url .= '?utm_source=wordpress.org&utm_campaign=' . WGA_Plugin::app()->getPluginName();
			
			$links[] = '<a href="' . $url . '" style="color: #FF5722;font-weight: bold;" target="_blank">' . __( 'Get ultimate plugin free', 'simple-google-analytics' ) . '</a>';
		}
		
		return $links;
	}
	
	add_filter( 'plugin_row_meta', 'wbcr_ga_set_plugin_meta', 10, 2 );
}

/**
 * Rating widget url
 *
 * @param string $page_url
 * @param string $plugin_name
 *
 * @return string
 */
function wbcr_ga_rating_widget_url( $page_url, $plugin_name ) {
	if ( ! defined( 'LOADING_GA_CACHE_AS_ADDON' ) && ( $plugin_name == WGA_Plugin::app()->getPluginName() ) ) {
		return 'https://wordpress.org/support/plugin/simple-google-analytics/reviews/#new-post';
	}
	
	return $page_url;
}

add_filter( 'wbcr_factory_imppage_rating_widget_url', 'wbcr_ga_rating_widget_url', 10, 2 );



