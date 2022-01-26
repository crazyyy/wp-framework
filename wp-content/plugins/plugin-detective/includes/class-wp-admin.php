<?php
/**
 * Plugin Detective Wp Admin.
 *
 * @since   0.0.0
 * @package Plugin_Detective
 */

/**
 * Plugin Detective Wp Admin.
 *
 * @since 0.0.0
 */
class PD_Wp_Admin {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   Plugin_Detective
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  Plugin_Detective $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {
		add_filter( 'plugin_action_links_' . $this->plugin->basename, array( $this, 'add_action_links' ) );
		add_action( 'admin_menu', array( $this, 'register_tools_page' ), 1 );
		add_action( 'admin_init', array( $this, 'redirect_tools_page' ), 1 );
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );
	}

	public function register_tools_page() {
		add_management_page( 'Plugin Detective', 'Plugin Detective', 'manage_options', 'plugin-detective', array( $this, 'render_tools_page' ) );
	}

	public function add_action_links ( $links ) {
		$mylinks = array(
			'<a href="' . $this->get_tools_page_url() . '"><strong>Troubleshoot Plugin Conflicts</strong></a>',
		);

		return array_merge( $links, $mylinks );
	}

	public function get_app_url( $troubleshoot_url='', $authenticated = true ) {
		$url = $this->plugin->url( 'troubleshoot/' );

		if ( !empty( $authenticated ) ) {
			require_once $this->plugin->dir( 'troubleshoot/includes/class-auth.php' );
			$nonce = PDT_Auth::create_nonce( 'pd_api' );
			$url = add_query_arg( array(
				'session' => get_current_user_id(),
				'nonce' => $nonce,
			), $url );
		}

		if ( !empty( $troubleshoot_url ) ) {
			$url = add_query_arg( array(
				'url' => urlencode( $troubleshoot_url )
			), $url );
		}

		return $url;
	}

	public function render_tools_page() {
		wp_redirect( $this->get_app_url() );
		exit();
	}

	public function get_tools_page_url( $troubleshoot_url = '' ) {
		$url = admin_url( 'tools.php?page=plugin-detective' );
		if ( !empty( $troubleshoot_url ) ) {
			$url = add_query_arg( array(
				'url' => $troubleshoot_url,
			), $url );
		}

		return $url;
	}

	public function redirect_tools_page() {
		if ( empty( $_GET['page'] ) || $_GET['page'] !== 'plugin-detective' ) {
			return;
		}
		
		if ( class_exists( 'ITSEC_Core' ) && $itsec_storage = get_option( 'itsec-storage' ) ) {
			if ( !empty( $itsec_storage['system-tweaks']['plugins_php'] ) ) {
				echo '<h1>iThemes Security is preventing Plugin Detective from operating properly</h1>';
				echo '<h3>To fix this: <code>Go to Security > Settings > System Tweaks</code> and <strong>uncheck</strong> the checkbox setting for <code>Disable PHP in Plugins</code></h3>';
				echo '<h3><a href="'. admin_url( 'admin.php?page=itsec&module=system-tweaks&module_type=recommended' ).'">Go there now</a></h3>';
				exit();
			}
		}

		$troubleshoot_url = '';
		if ( !empty( $_GET['url'] ) ) {
			$troubleshoot_url = sanitize_text_field( $_GET['url'] );
		}

		wp_redirect( $this->get_app_url( $troubleshoot_url ) );
		exit();
	}

	/**
	 * Add the admin bar menu
	 */
	public function admin_bar_menu() {
		global $wp_admin_bar;

		$current_url = '';
		if ( !empty( $_SERVER['REQUEST_URI'] ) ) {
			$desired_relative_path = (string)$_SERVER['REQUEST_URI'];
			$relative_path_to_wp_directory = (string)parse_url( site_url(), PHP_URL_PATH );

			if ( ! empty( $relative_path_to_wp_directory ) && strpos( $desired_relative_path, $relative_path_to_wp_directory ) === 0 ) {
				$desired_relative_path = substr( $desired_relative_path, strlen( $relative_path_to_wp_directory ) );
			}

			$current_url = site_url( $desired_relative_path );
		}

		// Add top menu
		if ( current_user_can( 'activate_plugins' ) ) {
			$wp_admin_bar->add_menu( array(
				'id'     => 'plugin-detective-bar',
				'parent' => '',
				'title'  => __( 'Troubleshoot', 'plugin-detective' ),
				'href'   => $this->get_tools_page_url( $current_url )
			) );
		}

		wp_enqueue_style( 'plugin_detective', $this->plugin->url( 'assets/admin.css' ) );
	}

}
