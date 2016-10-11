<?php
defined( 'ABSPATH' ) or	die( 'Cheatin\' uh?' );

/**
 * This warnings are displayed when the plugin can not be deactivated correctly
 *
 * @since 2.0.0
 */
add_action( 'admin_notices', 'rocket_bad_deactivations' );
function rocket_bad_deactivations() {
	global $current_user;
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) && $msgs = get_transient( $current_user->ID . '_donotdeactivaterocket' ) ) {

		delete_transient( $current_user->ID . '_donotdeactivaterocket' );
		$errors = array();
		?>

		<div class="error">
			<?php
			foreach ( $msgs as $msg ) {

				switch( $msg ) {
					case 'wpconfig' :
						$errors['wpconfig'] = 	'<p>' . sprintf( __( '<b>%s</b> can not be deactivated because of <code>%s</code>.', 'rocket' ), WP_ROCKET_PLUGIN_NAME, 'WP_CACHE' ) . '<br>' . __( 'This constant is still defined in <code>wp-config.php</code> file and its value must be set to <code>false</code>.', 'rocket' ) . ' ' . sprintf( __( 'Maybe we do not have the writing permissions for <code>%s</code>.', 'rocket' ), 'wp-config.php' ) . '<br>' . __( 'Please give us permissions or resolve the problem yourself. Then retry deactivation.', 'rocket' ) . '</p>';
						break;

					case 'htaccess' :
						$errors['htaccess'] = '<p>' . sprintf( __( '<b>%s</b> can not be deactivated because of <code>%s</code>.', 'rocket' ), WP_ROCKET_PLUGIN_NAME, '.htaccess' ) . '<br>' . __( 'This file is not writable and we can not remove these directives.', 'rocket' ) . ' ' . sprintf( __( 'Maybe we do not have writing permissions for <code>%s</code>.', 'rocket' ), '.htaccess' ) . '<br>' . __( 'Please give us permissions or resolve the problem yourself. Then retry deactivation.', 'rocket' ) . '</p>';
						break;
				}

				/**
				  * Filter the output messages for each bad deactivation attempt.
				  *
				  * @since 2.0.0
				  *
				  * @param array $errors Contains the error messages to be filtered
				  * @param string $msg Contains the error type (wpconfig or htaccess)
				 */
				$errors = apply_filters( 'rocket_bad_deactivations', $errors, $msg );

			}

			// Display errors
			if ( count( $errors ) ) {
				array_map( 'printf', $errors );
			}

			/**
			  * Allow a "force deactivation" link to be printed, use at your own risks
			  *
			  * @since 2.0.0
			  *
			  * @param bool true will print the link
			 */
			$permit_force_deactivation = apply_filters( 'rocket_permit_force_deactivation', true );

			// We add a link to permit "force deactivation", use at your own risks.
			if ( $permit_force_deactivation ) {
				global $status, $page, $s;
				$plugin_file = 'wp-rocket/wp-rocket.php';
				$rocket_nonce = wp_create_nonce( 'force_deactivation' );

				echo '<p><a href="'.wp_nonce_url('plugins.php?action=deactivate&amp;rocket_nonce=' . $rocket_nonce . '&amp;plugin=' . $plugin_file . '&amp;plugin_status=' . $status . '&amp;paged=' . $page . '&amp;s=' . $s, 'deactivate-plugin_' . $plugin_file).'">' . __( 'You can still force the deactivation by clicking here.', 'rocket' ) . '</a></p>';
			}
			?>
		</div>

	<?php
	}
}

/**
 * This warning is displayed to inform the user that a plugin de/activation can be followed by a cache purgation
 *
 * @since 1.3.0
 */
add_action( 'admin_notices', 'rocket_warning_plugin_modification' );
function rocket_warning_plugin_modification() {
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) && rocket_valid_key() ) {

		$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

		if ( ! in_array( __FUNCTION__, (array) $boxes ) ) { ?>

			<div class="updated">
				<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=rocket_ignore&box='.__FUNCTION__ ), 'rocket_ignore_'.__FUNCTION__ ); ?>" class="rkt-cross"><div class="dashicons dashicons-no"></div></a>
				<p><?php printf( __( '<b>%s</b>: One or more extensions have been enabled or disabled, do not forget to clear the cache if necessary.', 'rocket' ), WP_ROCKET_PLUGIN_NAME ); ?> <a class="wp-core-ui button" href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=purge_cache&type=all' ), 'purge_cache_all' ); ?>"><?php _e('Clear cache', 'rocket') ; ?></a></p>
			</div>

		<?php
		}

	}
}

/**
 * This warning is displayed when some plugins may conflict with WP Rocket
 *
 * @since 1.3.0
 */
add_action( 'admin_notices', 'rocket_plugins_to_deactivate' );
function rocket_plugins_to_deactivate() {
	$plugins_to_deactivate = array();

	// Deactivate all plugins who can cause conflicts with WP Rocket
	$plugins = array(
		'w3-total-cache'                             => 'w3-total-cache/w3-total-cache.php',
		'wp-super-cache'                             => 'wp-super-cache/wp-cache.php',
		'quick-cache'                                => 'quick-cache/quick-cache.php',
		'hyper-cache'                                => 'hyper-cache/plugin.php',
		'hyper-cache-extended'                       => 'hyper-cache-extended/plugin.php',
		'wp-fast-cache'                              => 'wp-fast-cache/wp-fast-cache.php',
		'flexicache'                                 => 'flexicache/wp-plugin.php',
		'wp-fastest-cache'                           => 'wp-fastest-cache/wpFastestCache.php',
		'lite-cache'                                 => 'lite-cache/plugin.php',
		'gator-cache'                                => 'gator-cache/gator-cache.php',
		'wp-http-compression'                        => 'wp-http-compression/wp-http-compression.php',
		'wordpress-gzip-compression'                 => 'wordpress-gzip-compression/ezgz.php',
		'gzip-ninja-speed-compression'               => 'gzip-ninja-speed-compression/gzip-ninja-speed.php',
		'speed-booster-pack'                         => 'speed-booster-pack/speed-booster-pack.php',
		'wp-performance-score-booster'               => 'wp-performance-score-booster/wp-performance-score-booster.php',
		'remove-query-strings-from-static-resources' => 'remove-query-strings-from-static-resources/remove-query-strings.php',
		'query-strings-remover'                      => 'query-strings-remover/query-strings-remover.php',
		'wp-ffpc'                                    => 'wp-ffpc/wp-ffpc.php',
		'far-future-expiry-header'                   => 'far-future-expiry-header/far-future-expiration.php',
		'combine-css'                                => 'combine-css/combine-css.php',
		'super-static-cache'                         => 'super-static-cache/super-static-cache.php',
		'wpcompressor'                               => 'wpcompressor/wpcompressor.php',
		'check-and-enable-gzip-compression' 		 => 'check-and-enable-gzip-compression/richards-toolbox.php',
		'leverage-browser-caching-ninjas'   		 => 'leverage-browser-caching-ninjas/leverage-browser-caching-ninja.php',
		'force-gzip'								 => 'force-gzip/force-gzip.php'
	);

	if ( get_rocket_option( 'lazyload' ) ) {
		$plugins['bj-lazy-load']              = 'bj-lazy-load/bj-lazy-load.php';
		$plugins['lazy-load']                 = 'lazy-load/lazy-load.php';
		$plugins['jquery-image-lazy-loading'] = 'jquery-image-lazy-loading/jq_img_lazy_load.php';
		$plugins['advanced-lazy-load']        = 'advanced-lazy-load/advanced_lazyload.php';
		$plugins['crazy-lazy']                = 'crazy-lazy/crazy-lazy.php';
	}
	
	if ( get_rocket_option( 'lazyload_iframes' ) ) {
		$plugins['lazy-load-for-videos'] = 'lazy-load-for-videos/codeispoetry.php';
	}
	
	if ( get_rocket_option( 'minify_css' ) || get_rocket_option( 'minify_js' ) || get_rocket_option( 'minify_html' ) ) {
		$plugins['bwp-minify']              = 'bwp-minify/bwp-minify.php';
		$plugins['wp-minify']               = 'wp-minify/wp-minify.php';
		$plugins['scripts-gzip']            = 'scripts-gzip/scripts_gzip.php';
		$plugins['autoptimize']             = 'autoptimize/autoptimize.php';
		$plugins['minqueue']                = 'minqueue/plugin.php';
		$plugins['dependency-minification'] = 'dependency-minification/dependency-minification.php';
	}
	
	if ( get_rocket_option( 'minify_css' ) || get_rocket_option( 'minify_js' ) ) {
		$plugins['async-js-and-css'] = 'async-js-and-css/asyncJSandCSS.php';
	}
	
	if( get_rocket_option( 'minify_html' ) ) {
		$plugins['wp-html-compression'] = 'wp-html-compression/wp-html-compression.php';
		$plugins['wp-compress-html']    = 'wp-compress-html/wp_compress_html.php';
	}
	
	if( get_rocket_option( 'minify_js' ) ) {
		$plugins['wp-js']                = 'wp-js/wp-js.php';
		$plugins['combine-js']           = 'combine-js/combine-js.php';
		$plugins['footer-javascript']    = 'footer-javascript/footer-javascript.php';
		$plugins['scripts-to-footerphp'] = 'scripts-to-footerphp/scripts-to-footer.php';
	}
	
	if( get_rocket_option( 'do_cloudflare' ) ) {
		$plugins['cloudflare'] = 'cloudflare/cloudflare.php';
	}
	
	/**
	 * Filter the recommended plugins to deactivate to prevent conflicts
	 *
	 * @since 2.6.4
	 *
	 * @param string $plugins List of recommended plugins to deactivate
	*/
	$plugins = apply_filters( 'rocket_plugins_to_deactivate', $plugins );
	
	$plugins = array_filter( $plugins, 'is_plugin_active' );
	
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
		&& count( $plugins )
		&& rocket_valid_key()
	) { ?>

		<div class="error">
			<p><?php printf( __( '<b>%s</b>: The following plugins are not compatible with this plugin and may cause unexpected results:', 'rocket' ), WP_ROCKET_PLUGIN_NAME ); ?></p>
			<ul class="rocket-plugins-error">
			<?php
			foreach ( $plugins as $plugin ) {
				$plugin_data = get_plugin_data( WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $plugin );
				echo '<li>' . $plugin_data['Name'] . '</span> <a href="' . wp_nonce_url( admin_url( 'admin-post.php?action=deactivate_plugin&plugin=' . urlencode($plugin) ), 'deactivate_plugin' ) . '" class="button-secondary alignright">' . __( 'Deactivate', 'rocket' ) . '</a></li>';

			}
			?>
			</ul>
		</div>

	<?php
	}
}

/**
 * This warning is displayed when there is no permalink structure in the configuration.
 *
 * @since 1.0
 */
add_action( 'admin_notices', 'rocket_warning_using_permalinks' );
function rocket_warning_using_permalinks() {
	/** This filter is documented in inc/admin-bar.php */
	if( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
	    && ! $GLOBALS['wp_rewrite']->using_permalinks()
	    && rocket_valid_key()
	) { ?>

		<div class="error">
			<p><?php printf( __( '<b>%s</b>: A custom permalink structure is required for the plugin to work properly. Please go to <a href="%s">Permalink</a> to configure it.', 'rocket'), WP_ROCKET_PLUGIN_NAME, admin_url( 'options-permalink.php' ) ); ?></p>
		</div>

	<?php
	}
}

/**
 * This warning is displayed when the wp-config.php file isn't writable
 *
 * @since 2.0
 */
add_action( 'admin_notices', 'rocket_warning_wp_config_permissions' );
function rocket_warning_wp_config_permissions() {
	$config_file = rocket_find_wpconfig_path();

	if ( ! ( 'plugins.php' == $GLOBALS['pagenow'] && isset( $_GET['activate'] ) ) 
		/** This filter is documented in inc/admin-bar.php */
		&& current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
		&& ( ! is_writable( $config_file ) && ( ! defined( 'WP_CACHE' ) || ! WP_CACHE ) )
	    && rocket_valid_key() ) {

		$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

		if ( ! in_array( __FUNCTION__, (array) $boxes ) ) { ?>

			<div class="error">
				<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=rocket_ignore&box='.__FUNCTION__ ), 'rocket_ignore_'.__FUNCTION__ ); ?>" class="rkt-cross"><div class="dashicons dashicons-no"></div></a>
				<p>
				<?php
					printf( __( '<b>%s</b>: It seems we don\'t have <a href="%s" target="_blank">writing permissions</a> on <code>wp-config.php</code> file or the value of the constant <code>WP_CACHE</code> is set to <code>false</code>', 'rocket'), WP_ROCKET_PLUGIN_NAME, "http://codex.wordpress.org/Changing_File_Permissions" );
					echo '<br>';
					_e( 'To fix this you have to set writing permissions for <code>wp-config.php</code> and then save the settings again.', 'rocket' );
					echo '<br>';
					_e( 'If the message persists, you have to put the following code in your <code>wp-config.php</code> file so that it works correctly. Click on the field and press Ctrl-A to select all.', 'rocket' );
				?>
				</p>

				<?php
				// Get the content of the WP_CACHE constant added by WP Rocket
				$define = "/** Enable Cache by WP Rocket */\r\ndefine( 'WP_CACHE', true );\r\n";
				?>

				<p><textarea readonly="readonly" id="rules" name="rules" class="large-text readonly" rows="2"><?php echo esc_textarea( $define ); ?></textarea></p>
			</div>

		<?php
		}

	}
}

/**
 * This warning is displayed when the advanced-cache.php file isn't writeable
 *
 * @since 2.0
 */

add_action( 'admin_notices', 'rocket_warning_advanced_cache_permissions' );
function rocket_warning_advanced_cache_permissions() {
	$advanced_cache_file =  WP_CONTENT_DIR . '/advanced-cache.php';

	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
		&& ! is_writable( $advanced_cache_file )
		&& ( ! defined( 'WP_ROCKET_ADVANCED_CACHE' ) || ! WP_ROCKET_ADVANCED_CACHE )
	    && rocket_valid_key() ) {

		$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

		if ( ! in_array( __FUNCTION__, (array) $boxes ) ) { ?>

			<div class="error">
				<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=rocket_ignore&box='.__FUNCTION__ ), 'rocket_ignore_'.__FUNCTION__ ); ?>" class="rkt-cross"><div class="dashicons dashicons-no"></div></a>
				<p><b><?php echo WP_ROCKET_PLUGIN_NAME; ?></b>: <?php printf( __( 'If you had <a href="%1$s" target="_blank">writing permissions</a> on <code>%2$s</code> file, <b>%3$s</b> could do this automatically. This is not the case, here is the code you should add in your <code>%2$s</code> file for <b>%3$s</b> to work properly.', 'rocket' ), 'http://codex.wordpress.org/Changing_File_Permissions', basename( WP_CONTENT_DIR ) . '/advanced-cache.php', WP_ROCKET_PLUGIN_NAME ); ?></p>

				<?php
				// Get the content of advanced-cache.php file added by WP Rocket
				$content = get_rocket_advanced_cache_file();
				?>

				<p><textarea readonly="readonly" id="rules" name="rules" class="large-text readonly" rows="8"><?php echo esc_textarea( $content ); ?></textarea></p>
			</div>

		<?php
		}

	}
}

/**
 * This warning is displayed when the advanced-cache.php file isn't ours
 *
 * @since 2.2
 */
add_action( 'admin_notices', 'rocket_warning_advanced_cache_not_ours' );
function rocket_warning_advanced_cache_not_ours() {
	/** This filter is documented in inc/admin-bar.php */
	if ( ! ( 'plugins.php' == $GLOBALS['pagenow'] && isset( $_GET['activate'] ) ) 
		&& current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
		&& ! defined( 'WP_ROCKET_ADVANCED_CACHE' )
		&& ( defined( 'WP_CACHE' ) && WP_CACHE )
		&& get_rocket_option( 'version' ) == WP_ROCKET_VERSION
	    && rocket_valid_key()) { ?>

			<div class="error">
				<p><b><?php echo WP_ROCKET_PLUGIN_NAME; ?></b>: <?php printf( __( 'It seems that the <code>%s</code> file is not ours. Save the settings, we will automatically recreate the correct one. If it\'s still not working, please delete it and save again.', 'rocket' ), basename( WP_CONTENT_DIR ) . '/advanced-cache.php' ); ?></p>
			</div>

		<?php
	}
}

/**
 * This warning is displayed when the .htaccess file doesn't exist or isn't writeable
 *
 * @since 1.0
 */
add_action( 'admin_notices', 'rocket_warning_htaccess_permissions' );
function rocket_warning_htaccess_permissions() {
	global $is_apache;
	$htaccess_file =  get_home_path() . '.htaccess';

	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
	    && ( ! is_writable( $htaccess_file ) )
	    && $is_apache
	    && rocket_valid_key() ) {

		$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

		if ( ! in_array( __FUNCTION__, (array) $boxes ) ) { ?>

			<div class="error">
				<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=rocket_ignore&box='.__FUNCTION__ ), 'rocket_ignore_'.__FUNCTION__ ); ?>" class="rkt-cross"><div class="dashicons dashicons-no"></div></a>
				<p><b><?php echo WP_ROCKET_PLUGIN_NAME; ?></b>: <?php printf( __( 'If you had <a href="%1$s" target="_blank">writing permissions</a> on <code>.htaccess</code> file, <b>%2$s</b> could do this automatically. This is not the case, so here are the rewrite rules you have to put in your <code>.htaccess</code> file for <b>%2$s</b> to work correctly. Click on the field and press Ctrl-A to select all.', 'rocket' ), 'http://codex.wordpress.org/Changing_File_Permissions', WP_ROCKET_PLUGIN_NAME ) . '<br>' . __('<strong>Warning:</strong> This message will popup again and its content may be updated when saving the options', 'rocket'); ?></p>
				<p><textarea readonly="readonly" id="rules" name="rules" class="large-text readonly" rows="6"><?php echo esc_textarea( get_rocket_htaccess_marker() ); ?></textarea></p>
			</div>

		<?php
		}

	}
}

/**
 * This warning is displayed when the config dir isn't writeable
 *
 * @since 2.0.2
 */
add_action( 'admin_notices', 'rocket_warning_config_dir_permissions' );
function rocket_warning_config_dir_permissions() {
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
	    && ( ! is_writable( WP_ROCKET_CONFIG_PATH ) )
	    && rocket_valid_key() ) {

		$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

		if ( ! in_array( __FUNCTION__, (array) $boxes ) ) { ?>

			<div class="error">
				<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=rocket_ignore&box='.__FUNCTION__ ), 'rocket_ignore_'.__FUNCTION__ ); ?>" class="rkt-cross"><div class="dashicons dashicons-no"></div></a>
				<p><b><?php echo WP_ROCKET_PLUGIN_NAME; ?></b>: <?php printf( __('Be careful, you don\'t have <a href="%1$s" target="_blank">writing permissions</a> on <b>%3$s</b> domain configuration folder (<code>%2$s</code>). To make <b>%3$s</b> work properly, please CHMOD <code>755</code> or <code>775</code> or <code>777</code> this folder.<br/>When the problem is solved, thank you to save the %3$s options to generate the configuration file.', 'rocket' ), 'http://codex.wordpress.org/Changing_File_Permissions', trim( str_replace( ABSPATH, '', WP_ROCKET_CONFIG_PATH ), '/' ), WP_ROCKET_PLUGIN_NAME ); ?></p>
			</div>

		<?php
		}

	}
}

/**
 * This warning is displayed when the cache dir isn't writeable
 *
 * @since 1.0
 */
add_action( 'admin_notices', 'rocket_warning_cache_dir_permissions' );
function rocket_warning_cache_dir_permissions() {
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
	    && ( ! is_writable( WP_ROCKET_CACHE_PATH ) )
	    && rocket_valid_key() ) {

		$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

		if ( ! in_array( __FUNCTION__, (array) $boxes ) ) { ?>

			<div class="error">
				<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=rocket_ignore&box='.__FUNCTION__ ), 'rocket_ignore_'.__FUNCTION__ ); ?>" class="rkt-cross"><div class="dashicons dashicons-no"></div></a>
				<p><b><?php echo WP_ROCKET_PLUGIN_NAME; ?></b>: <?php printf( __('Be careful, you don\'t have <a href="%1$s" target="_blank">writing permissions</a> on <b>%3$s</b> cache folder (<code>%2$s</code>). For <b>%3$s</b> works properly, please CHMOD <code>755</code> or <code>775</code> or <code>777</code> this folder.', 'rocket' ), 'http://codex.wordpress.org/Changing_File_Permissions', trim( str_replace( ABSPATH, '', WP_ROCKET_CACHE_PATH ), '/' ), WP_ROCKET_PLUGIN_NAME ); ?></p>
			</div>

		<?php
		}

	}
}

/**
 * This warning is displayed when the minify cache dir isn't writeable
 *
 * @since 2.1
 */
add_action( 'admin_notices', 'rocket_warning_minify_cache_dir_permissions' );
function rocket_warning_minify_cache_dir_permissions() {
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) )
	    && ( ! is_writable( WP_ROCKET_MINIFY_CACHE_PATH ) )
	    && ( get_rocket_option( 'minify_css', false ) || get_rocket_option( 'minify_js', false ) )
	    && rocket_valid_key() ) {

		$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

		if ( ! in_array( __FUNCTION__, (array) $boxes ) ) { ?>

			<div class="error">
				<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=rocket_ignore&box='.__FUNCTION__ ), 'rocket_ignore_'.__FUNCTION__ ); ?>" class="rkt-cross"><div class="dashicons dashicons-no"></div></a>
				<p><b><?php echo WP_ROCKET_PLUGIN_NAME; ?></b>: <?php printf( __('Be careful, you don\'t have <a href="%1$s" target="_blank">writing permissions</a> on <b>%3$s</b> minified cache folder (<code>%2$s</code>). To make <b>%3$s</b> work properly, please CHMOD <code>755</code> or <code>775</code> or <code>777</code> this folder.', 'rocket' ), 'http://codex.wordpress.org/Changing_File_Permissions', trim( str_replace( ABSPATH, '', WP_ROCKET_MINIFY_CACHE_PATH ), '/' ), WP_ROCKET_PLUGIN_NAME ); ?></p>
			</div>

		<?php
		}

	}
}

/**
 * This thankful message is displayed when the site has been added
 *
 * @since 2.2
 */
add_action( 'admin_notices', 'rocket_thank_you_license' );
function rocket_thank_you_license() {
	if ( '1' == get_rocket_option( 'license' ) ) {
		$options = get_option( WP_ROCKET_SLUG );
		$options['license'] = time();
		$options['ignore'] = true;
		update_option( WP_ROCKET_SLUG, $options );
	?>
		<div class="updated">
			<p>
				<b><?php echo WP_ROCKET_PLUGIN_NAME; ?></b>: <?php _e( 'Thank you. Your license has been successfully validated!', 'rocket' ); ?><br />
				<?php printf( __( 'Key: <code>%s</code><br>Email: <i>%s</i>', 'rocket' ), get_rocket_option( 'consumer_key' ), get_rocket_option( 'consumer_email' ) ); ?>
			</p>
		</div>
	<?php
	}
}

/**
 * Add a message about Imagify on the "Upload New Media" screen and WP Rocket options page.
 *
 * @since 2.7
 */
add_action( 'admin_notices', '__rocket_imagify_notice' );
function __rocket_imagify_notice() {
	$current_screen = get_current_screen();
		
	// Add the notice only on the "WP Rocket" settings, "Media Library" & "Upload New Media" screens
	if ( 'admin_notices' === current_filter() && ( isset( $current_screen ) && 'settings_page_wprocket' !== $current_screen->base ) ) {
		return;
	}
	
	$boxes = get_user_meta( $GLOBALS['current_user']->ID, 'rocket_boxes', true );

	if ( defined( 'IMAGIFY_VERSION' ) || in_array( __FUNCTION__, (array) $boxes ) || 1 == get_option( 'wp_rocket_dismiss_imagify_notice' ) || rocket_is_white_label() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
		
	$imagify_plugin = 'imagify/imagify.php';
	$is_imagify_installed = rocket_is_plugin_installed( $imagify_plugin );

	$action_url = $is_imagify_installed ?
	rocket_get_plugin_activation_link( $imagify_plugin )
		:
	add_query_arg(
		array(
			'tab'       => 'plugin-information',
			'plugin'    => 'imagify',
			'TB_iframe' => true,
			'width'     => 722,
			'height'    => 949
		),
		admin_url( 'plugin-install.php' )
	);

	$classes = $is_imagify_installed ? '' : ' tgm-plugin-update-modal';
	$cta_txt = $is_imagify_installed ? esc_html__( 'Activate Imagify', 'rocket' ) : esc_html__( 'Install Imagify for Free', 'rocket' );

	$dismiss_url = wp_nonce_url(
		admin_url( 'admin-post.php?action=rocket_ignore&box=' . __FUNCTION__ ),
		'rocket_ignore_' . __FUNCTION__
	);
	?>

	<div class="updated rkt-imagify-notice">
		<a href="<?php echo $dismiss_url; ?>" class="rkt-cross"><span class="dashicons dashicons-no"></span></a>
		
		<p class="rkt-imagify-logo">
			<img src="<?php echo WP_ROCKET_ADMIN_UI_IMG_URL ?>logo-imagify.png" srcset="<?php echo WP_ROCKET_ADMIN_UI_IMG_URL ?>logo-imagify.svg 2x" alt="Imagify" width="150" height="18">
		</p>
		<p class="rkt-imagify-msg">
			<?php _e( 'Speed up your website and boost your SEO by reducing image file sizes without loosing quality with Imagify.', 'rocket' ); ?>
		</p>
		<p class="rkt-imagify-cta">
			<a href="<?php echo $action_url; ?>" class="button button-primary<?php echo $classes; ?>"><?php echo $cta_txt; ?></a>
		</p>
	</div>

	<?php
}