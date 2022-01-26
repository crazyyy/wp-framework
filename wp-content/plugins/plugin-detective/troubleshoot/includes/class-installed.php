<?php
/**
 * Troubleshoot Installed.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Installed.
 *
 * @since 0.0.0
 */
class PDT_Installed {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   Troubleshoot
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  Troubleshoot $plugin Main plugin object.
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

	}

	public function get_all( $params=array() ) {
		$data = array(
			'core' => $this->get_core(),
			'plugins' => $this->get_plugins(),
			'themes' => $this->get_themes(),
		);

		if ( !empty( $data['plugins']['plugin-detective'] ) ) {
			unset( $data['plugins']['plugin-detective'] );
		}

		return $data;
	}

	public function get_all_active( $params=array() ) {
		$data = $this->get_all();
		$data['plugins'] = array_filter( $data['plugins'], array( $this, 'filter_active' ) );
		$data['themes'] = array_filter( $data['themes'], array( $this, 'filter_active' ) );

		return $data;
	}

	public function filter_active( $item ) {
		if ( empty( $item['Active'] ) ) {
			return false;
		}

		return true;
	}

	public function get_core( $params=array() ) {
		global $wp_version;
		global $wp_db_version;
		$core = array(
			'version' => $wp_version,
			'db_version' => $wp_db_version,
			'latest' => $core_updates_data['updates'][0]->current,
			'detail' => $core_updates_data['updates'],
		);
		if ( version_compare( $core['latest'], $core['version'], '<=' ) ) {
			//Cases where the latest is actually older than installed version (caused by caching on some hosts)
			unset( $core['detail'] );
			$core['latest'] = $core['version'];
		}

		return $core;
	}
	
	public function get_plugins( $params=array() ) {
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		// Get all plugins
		$plugins = get_plugins();

		// Get the list of active plugins
		$active  = get_option( 'active_plugins', array() );


		// Premium plugins that have adopted the ManageWP API report new plugins by this filter
		foreach ( (array) $plugins as $plugin_file => $plugin ) {
		    if ( is_plugin_active( $plugin_file ) ) {
		    	$plugins[$plugin_file]['Active'] = true;
		    } else {
		    	$plugins[$plugin_file]['Active'] = false;
		    }
		    
		    $plugins[$plugin_file]['Description'] = htmlspecialchars( $plugins[$plugin_file]['Description'] );
		    
	        $plugins[$plugin_file]['plugin_file'] = $plugin_file;
			if ( empty( $plugins[$plugin_file]['slug'] ) || $plugins[$plugin_file]['slug'] === $plugin_file ) {
				$plugin_names = explode('/', $plugin_file);
				$plugins[$plugin_file]['slug'] = $plugin_names[0];
			}
			$plugin_slug = $plugins[$plugin_file]['slug'];
			$plugins[$plugin_file]['icon'] = 'https://ps.w.org/'.$plugin_slug.'/assets/icon-256x256.png';
			$plugins[$plugin_slug] = $plugins[$plugin_file];
			unset($plugins[$plugin_file]);
			if ( is_array( $plugins[$plugin_slug] ) ) {
				ksort($plugins[$plugin_slug]);
			}
		}

		return $plugins;
	}

	public function get_themes( $params=array() ) {
		require_once( ABSPATH . '/wp-admin/includes/theme.php' );
		// Get all themes
		if ( function_exists( 'wp_get_themes' ) ) {
			$themes = wp_get_themes();
		}

		// Get the active theme
		$active_theme = wp_get_theme();
		foreach ( (array) $themes as $key => $theme ) {
			// WordPress 3.4+
			if ( is_object( $theme ) && is_a( $theme, 'WP_Theme' ) ) {
				/* @var $theme WP_Theme */
				$theme_array = array(
					'Name'           => $theme->get( 'Name' ),
					'Active'         => ( $active_theme->get_stylesheet() == $theme->get_stylesheet() ),
					'Template'       => $theme->get_template(),
					'Stylesheet'     => $theme->get_stylesheet(),
					'Screenshot'     => $theme->get_screenshot(),
					'AuthorURI'      => $theme->get( 'AuthorURI' ),
					'Author'         => $theme->get( 'Author' ),
					'Version'        => $theme->get( 'Version' ),
					'ThemeURI'       => $theme->get( 'ThemeURI' )
				);
				$themes_array[$key] = $theme_array;
			}

		}

		return $themes_array;
	}
}
