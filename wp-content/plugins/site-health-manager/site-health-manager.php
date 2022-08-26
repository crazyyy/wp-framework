<?php
/*
Plugin Name: Site Health Manager
Plugin URI:  https://wordpress.org/plugins/site-health-manager/
Description: Control which status tests and what debug information appear in your Site Health screen.
Version:     1.1.2
Author:      Rami Yushuvaev
Author URI:  https://GenerateWP.com/
Text Domain: site-health-manager
*/

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Site Health Manager class.
 *
 * @since 1.0.0
 */
class Site_Health_Manager {

	/**
	 * Holds the plugin basename.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private static $basename;

	/**
	 * The screen id used in WordPress dashboard.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $screen_id = 'tools_page_site-health-manager';

	/**
	 * The slug of the parent page in WordPress dashboard.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $parent_slug = 'tools.php';

	/**
	 * The slug of the plugin in WordPress dashboard.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $page_slug = 'site-health-manager';

	/**
	 * The capability required for viewing the settings screen.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $view_cap = 'manage_options';

	/**
	 * The current tab displayed in the settings screen.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.1.0
	 */
	private $current_tab = '';

	/**
	 * WordPress site health tests array.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.1.0
	 */
	private $wp_site_health_tests;

	/**
	 * WordPress site health info array.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $wp_site_health_info;

	/**
	 * Site Health Manager disabled tests array.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.1.0
	 */
	private $site_health_manager_disabled_tests = [];

	/**
	 * Site Health Manager disabled info array.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $site_health_manager_disabled_info = [];

	/**
	 * Site Health Manager class constructor.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Load plugin data
		$this->load_data(
			get_option( 'site_health_manager_disabled_tests' ),
			get_option( 'site_health_manager_disabled_info' )
		);

		// Set current tab
		if ( isset( $_GET['tab'] ) && $_GET['tab'] === 'info' ) {
			$this->current_tab = 'info';
		} else {
			$this->current_tab = 'status';
		}

		// Disable selected site health information.
		add_filter( 'debug_information', [ $this, 'disable_info' ], 99999 );

		// Disable selected site health status tests.
		add_filter( 'site_status_tests', [ $this, 'disable_tests' ], 99999 );

		// The plugin runs only in the admin, but we need to initialize it on init.
		add_action( 'init', [ $this, 'action_init' ] );

	}

	/**
	 * Load plugin data.
	 *
	 * @access private
	 *
	 * @since 1.0.0
	 *
	 * @param array|string $tests Plugin tests to be used.
	 * @param array|string $info Plugin data to be used.
	 */
	private function load_data( $tests, $info ) {

		$this->site_health_manager_disabled_tests = is_array( $tests ) ? $tests : [];
		$this->site_health_manager_disabled_info = is_array( $info ) ? $info : [];

	}

	/**
	 * Disable selected site health information.
	 *
	 * This filter excludes Site Health Manager screen.
	 *
	 * Called by `debug_information` hook.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @param array $tests An array of registered debug information in the Site Health Info screen.
	 *
	 * @return array The debug information.
	 */
	public function disable_info( $info ) {

		$current_screen = get_current_screen();

		if( $current_screen->id !== $this->screen_id ) {
			foreach ( $this->site_health_manager_disabled_info as $section_name => $fields ) {
				foreach ( $fields as $field_name ) {
					unset( $info[$section_name]['fields'][$field_name] );
				}
			}
		}

		return $info;

	}

	/**
	 * Disable selected site health status tests.
	 *
	 * This filter excludes Site Health Manager screen.
	 *
	 * Called by `site_status_tests` hook.
	 *
	 * @access public
	 *
	 * @since 1.1.0
	 *
	 * @param array $tests An array of registered tests in the Site Health Status screen.
	 *
	 * @return array The tests list.
	 */
	function disable_tests( $tests ) {

		$current_screen = get_current_screen();

		if( $current_screen->id !== $this->screen_id ) {
			foreach ( $this->site_health_manager_disabled_tests as $test_name ) {
				unset( $tests['direct'][$test_name] );
				unset( $tests['async'][$test_name] );
			}
		}

		return $tests;
	}

	/**
	 * Site Health Manager initialization actions.
	 *
	 * Registers the hooks that run the plugin.
	 *
	 * Called by `init` action hook.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public function action_init() {

		if ( ! is_admin() )
			return;

		isset( self::$basename ) || self::$basename = plugin_basename( __FILE__ );

		// Add action links.
		add_filter( 'plugin_action_links_' . self::$basename, [ $this, 'plugin_action_links' ], 10, 2 );

		// Add admin menu.
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );

		// Load the plugin textdomain to allow multilingual translations.
		load_plugin_textdomain( 'site-health-manager' );

	}

	/**
	 * Site Health Manager plugin action links.
	 *
	 * Adds a link to the settings page in the plugins list.
	 *
	 * Called by `plugin_action_links_*` filter hook.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public function plugin_action_links( $links, $file ) {

		$links[] = sprintf(
			'<a href="%s">%s</a>',
			menu_page_url( $this->page_slug, false ),
			__( 'Settings' ) // No text-domain, use WordPress core string
		);
		return $links;

	}

	/**
	 * Site Health Manager plugin menu.
	 *
	 * Registers admin menu for the plugin.
	 *
	 * Called by `admin_menu` action hook.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {

		$admin_screen = add_submenu_page(
			$this->parent_slug,
			__( 'Site Health Manager', 'site-health-manager' ),
			__( 'Site Health Manager', 'site-health-manager' ),
			$this->view_cap,
			$this->page_slug, 
			[ $this, 'settings_page' ]
		);

		// TODO: move to a method.
		wp_enqueue_style( 'site-health' );

		// Add footer scripts
		add_action( "admin_footer-{$admin_screen}", [ $this,'admin_footer' ] );

	}

	/**
	 * Site Health Manager plugin footer scripts and styles in WordPress dashboard.
	 *
	 * Called by `admin_footer-*` action hook.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public function admin_footer() {

		?>
		<style>
			.tools_page_site-health-manager #wpcontent { padding-left: 0; }
			.tools_page_site-health-manager .health-check-body { padding-left: 20px; }
			.tools_page_site-health-manager .site-health-manager-nav { text-align: center; padding: 10px 0 20px; }
			.tools_page_site-health-manager .hidden { display: none; }
			.tools_page_site-health-manager table.status-table td:nth-of-type(1) { width: 20px; }
			.tools_page_site-health-manager table.status-table td:nth-of-type(2) { width: calc(100% - 20px); }
			.tools_page_site-health-manager table.info-table td:nth-of-type(1) { width: 20px; }
			.tools_page_site-health-manager table.info-table td:nth-of-type(2) { width: 30%; }
			.tools_page_site-health-manager table.info-table td:nth-of-type(3) { width: calc(100% - 30% - 20px); }
			<?php if ( version_compare( get_bloginfo('version'), '5.2.2', '>=' ) ) : ?>
			.tools_page_site-health-manager .health-check-tabs-wrapper { grid-template-columns: 1fr 1fr 1fr; }
			.tools_page_site-health-manager .health-check-tab { display: inline-block; }
			<?php endif; ?>
		</style>
		<?php

	}

	/**
	 * Site Health Manager plugin settings page.
	 *
	 * Called by `add_submenu_page()` function.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public function settings_page() {

		// Check required user capability
		if ( !current_user_can( $this->view_cap ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'site-health-manager' ) );
		}

		// Save Settings
		if ( isset( $_REQUEST['submit'] )
			&& isset( $_REQUEST[$this->page_slug.'_nonce'] )
			&& wp_verify_nonce( $_REQUEST[$this->page_slug.'_nonce'], $this->page_slug )
		) {
			$new_tests = [];
			if ( isset( $_REQUEST['tests'] ) ) {
				foreach ( $_REQUEST['tests'] as $test_name => $field ) {
					array_push( $new_tests, $test_name );
				}
			}

			$new_info = [];
			if ( isset( $_REQUEST['info'] ) ) {
				foreach ( $_REQUEST['info'] as $section_name => $fields ) {
					$new_info[$section_name] = [];
					foreach ( $fields as $field_name => $field ) {
						array_push( $new_info[$section_name], $field_name );
					}
				}
			}

			// Save new data
			update_option( 'site_health_manager_disabled_tests', $new_tests );
			update_option( 'site_health_manager_disabled_info', $new_info );

			// Reload plugin data
			$this->load_data( $new_tests, $new_info );
		}

		// Set variables
		$admin_url = menu_page_url( $this->page_slug, false );
		$site_health_manager_tabs = [
			'status' => [
				'name' => 'status',
				'label' => __( 'Status Manager', 'site-health-manager' ),
				'href' => $admin_url . '&tab=status',
				'aria_current' => ( $this->current_tab === 'status' ) ? 'true' : 'false',
				'active_class' => ( $this->current_tab === 'status' ) ? 'active' : '',
			],
			'info' => [
				'name' => 'info',
				'label' => __( 'Info Manager', 'site-health-manager' ),
				'href' => $admin_url . '&tab=info',
				'aria_current' => ( $this->current_tab === 'info' ) ? 'true' : 'false',
				'active_class' => ( $this->current_tab === 'info' ) ? 'active' : '',
			],
		];
		?>
		<div class="health-check-header">
			<div class="health-check-title-section">
				<h1><?php _e( 'Site Health', 'site-health-manager' ); ?></h1>

				<div class="site-health-progress hide-if-no-js loading">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30pt" height="30pt" viewBox="0 0 30 30" version="1.1">
						<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,37.647059%,37.647059%);fill-opacity:1;" d="M 27.785156 9.8125 C 27.875 5.980469 24.835938 2.734375 21.003906 2.695312 C 18.4375 2.667969 16.195312 4.046875 14.992188 6.109375 C 13.792969 4.046875 11.550781 2.667969 8.984375 2.695312 C 5.152344 2.734375 2.113281 5.980469 2.203125 9.8125 C 2.40625 18.371094 12.640625 25.816406 14.652344 27.199219 C 14.859375 27.339844 15.128906 27.339844 15.335938 27.199219 C 17.347656 25.816406 27.582031 18.371094 27.785156 9.8125 Z M 27.785156 9.8125 "/>
						<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 14.910156 22.121094 C 14.535156 22.121094 14.21875 21.855469 14.148438 21.488281 L 12.257812 11.449219 L 10.246094 16.226562 C 10.128906 16.507812 9.863281 16.691406 9.558594 16.699219 C 9.257812 16.710938 8.976562 16.542969 8.84375 16.273438 L 8.304688 15.207031 L 0.773438 15.207031 C 0.347656 15.207031 0 14.859375 0 14.433594 C 0 14.003906 0.347656 13.660156 0.773438 13.660156 L 8.78125 13.660156 C 9.074219 13.660156 9.339844 13.820312 9.46875 14.082031 L 11.828125 8.476562 C 11.960938 8.160156 12.285156 7.96875 12.625 8.007812 C 12.964844 8.042969 13.238281 8.296875 13.304688 8.632812 L 14.863281 16.914062 L 15.507812 13.039062 C 15.570312 12.664062 15.890625 12.390625 16.269531 12.390625 L 18.796875 12.390625 C 19.058594 12.390625 19.300781 12.523438 19.445312 12.742188 L 20.632812 14.5625 L 21.140625 13.941406 C 21.289062 13.761719 21.507812 13.660156 21.742188 13.660156 L 29.214844 13.660156 C 29.640625 13.660156 29.988281 14.003906 29.988281 14.433594 C 29.988281 14.859375 29.640625 15.207031 29.214844 15.207031 L 22.105469 15.207031 L 21.15625 16.363281 C 21 16.550781 20.761719 16.65625 20.515625 16.644531 C 20.269531 16.628906 20.046875 16.5 19.910156 16.292969 L 18.378906 13.9375 L 16.925781 13.9375 L 15.671875 21.472656 C 15.609375 21.84375 15.292969 22.117188 14.917969 22.121094 C 14.914062 22.121094 14.910156 22.121094 14.910156 22.121094 Z M 14.910156 22.121094 "/>
					</svg>
				</div>
			</div>

			<nav class="health-check-tabs-wrapper hide-if-no-js">
				<a href="<?php echo esc_url( admin_url( 'site-health.php' ) ); ?>" class="health-check-tab">
					<?php _e( 'Status', 'site-health-manager' ); ?>
				</a>

				<a href="<?php echo esc_url( admin_url( 'site-health.php?tab=debug' ) ); ?>" class="health-check-tab">
					<?php _e( 'Info', 'site-health-manager' ); ?>
				</a>

				<a href="<?php echo esc_url( $admin_url ); ?>" class="health-check-tab active" aria-current="true">
					<?php _e( 'Manager', 'site-health-manager' ); ?>
				</a>
			</nav>
		</div>

		<hr class="wp-header-end">

		<div class="health-check-body">

			<h2><?php echo esc_html__( 'Site Health Manager', 'site-health-manager' ); ?></h2>

			<p><?php echo esc_html__( 'Make sure your health score is correct by running only the tests relevant to your server configuration. Take some protective measures to keep your critical server data hidden and secure.', 'site-health-manager' ); ?></p>

			<nav class="site-health-manager-nav">
				<?php foreach ( $site_health_manager_tabs as $tab => $tab_data ) { ?>
				<a href="<?php echo esc_url( $tab_data['href'] ); ?>"
					class="<?php echo esc_attr( $tab_data['active_class'] ); ?> health-check-tab"
					aria-current="<?php echo esc_attr( $tab_data['aria_current'] ); ?>">
					<?php echo esc_html( $tab_data['label'] ); ?>
				</a>
				<?php } ?>
			</nav>

			<form action="<?php echo $admin_url; ?>&tab=<?php echo $this->current_tab; ?>" method="post">
				<?php
				// Load WP_Site_Health class
				if ( ! class_exists( 'WP_Site_Health' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/class-wp-site-health.php' );
				}

				// Load WP_Debug_Data class
				if ( ! class_exists( 'WP_Debug_Data' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/class-wp-debug-data.php' );
				}

				// Get available tests and info
				$this->wp_site_health_tests = WP_Site_Health::get_tests();
				$this->wp_site_health_info = WP_Debug_Data::debug_data();

				// Tests List
				?>
				<div class="status-wrapper <?php echo ( $this->current_tab === 'status' ) ? '' : 'hidden'; ?>">
					<p><?php echo esc_html__( 'Site Health Status screen generates a health score based on tests it runs on the server, but some tests may not be relevant to your server setup. This may cause a low health score, unhappy site owners, and complaints for web hosts.', 'site-health-manager' ); ?></p>
					<p><?php echo esc_html__( 'Select the test you want to disable in order to prevent displaying the wrong health score in your Site Health Status screen. For example, missing PHP extensions for security reasons or disabled background updates to allow version control.', 'site-health-manager' ); ?></p>

					<h3><?php echo esc_html__( 'Tests', 'site-health-manager' ); ?></h3>
					<?php
					foreach ( $this->wp_site_health_tests as $type ) {
						?>
						<table class="widefat striped status-table" role="presentation">
							<tbody>
							<?php
							foreach ( $type as $test => $details ) {
								printf(
									'<tr><td><input type="checkbox" name="%1$s" %2$s></td><td>%3$s</td></tr>',
									esc_attr( 'tests[' .$test . ']' ),
									checked( in_array( $test, $this->site_health_manager_disabled_tests ), 1, 0 ),
									esc_html( $details['label'] )
								);
							}
							?>
							</tbody>
						</table>
						<?php
					}
					?>
				</div>
				<?php

				// Info List
				?>
				<div class="info-wrapper <?php echo ( $this->current_tab === 'info' ) ? '' : 'hidden'; ?>">
					<p><?php echo esc_html__( 'Site Health Info screen displays configuration data and debugging information. Some data in this screen is confidential and sharing critical server data should be done with caution and with security in mind.', 'site-health-manager' ); ?></p>
					<p><?php echo esc_html__( 'Select what information you want to disable in order to prevent your users from copying it to the clipboard when sharing debug data with third parties. For example, when sending data to plugin/theme developers to debug issues.', 'site-health-manager' ); ?></p>
					<?php
					foreach ( $this->wp_site_health_info as $section => $details ) {

						if ( ! isset( $details['fields'] ) || empty( $details['fields'] ) ) {
							continue;
						}

						if ( isset( $details['label'] ) && ! empty( $details['label'] ) ) {
							printf( '<h3>%s</h3>', $details['label'] );
						}

						if ( isset( $details['description'] ) && ! empty( $details['description'] ) ) {
							printf( '<p>%s</p>', $details['description'] );
						}
						?>
						<table class="widefat striped info-table" role="presentation" id="site-health-manager-section-<?php echo esc_attr( $section ); ?>">
							<tbody>
							<?php
							foreach ( $details['fields'] as $field_name => $field ) {
								// check if disabled
								$is_disabled = $this->is_info_disabled( $section, $field_name );

								// Info value (single value or an array of values)
								if ( is_array( $field['value'] ) ) {
									$values = '<ul>';
									foreach ( $field['value'] as $name => $value ) {
										$values .= sprintf( '<li>%s: %s</li>', $name, $value );
									}
									$values .= '</ul>';
								} else {
									$values = $field['value'];
								}

								// Info list
								printf(
									'<tr><td><input type="checkbox" name="%1$s" %2$s></td><td>%3$s</td><td>%4$s</td></tr>',
									esc_attr( 'info[' .$section . '][' . $field_name . ']' ),
									checked( $is_disabled, 1, 0 ),
									esc_html( $field['label'] ),
									esc_html( $values )
								);
							}
							?>
							</tbody>
						</table>
						<br>
						<?php
					}
					?>
				</div>
				<?php

				// Set security nonce
				wp_nonce_field( $this->page_slug, $this->page_slug . '_nonce' );

				submit_button();
				?>
			</form>

		</div>
	<?php
	}

	/**
	 * Check whether the info is disabled or not.
	 *
	 * @access private
	 *
	 * @since 1.0.0
	 *
	 * @param string $section Info section name.
	 * @param string $field   Info field name.
	 *
	 * @return boolean True if info is disabled, False otherwise.
	 */
	private function is_info_disabled( $section, $field ) {

		$disabled = false;

		if ( array_key_exists( $section, $this->site_health_manager_disabled_info ) ) {
			if ( in_array( $field, $this->site_health_manager_disabled_info[$section] ) ) {
				$disabled = true;
			}
		}

		return $disabled;

	}

}

/**
 * Site Health Manager plugin loader.
 *
 * @since 1.0.0
 */
function site_health_manager_loader() {
	return new Site_Health_Manager;
}
add_action( 'plugins_loaded', 'site_health_manager_loader' );
