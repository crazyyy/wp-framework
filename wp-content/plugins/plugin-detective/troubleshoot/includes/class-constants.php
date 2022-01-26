<?php
/**
 * Troubleshoot Constants.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Constants.
 *
 * @since 0.0.0
 */
class PDT_Constants {
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
		$this->define_constants();
	}

	public function define_constants() {
		// Define the directory seperator if it isn't already
		if( !defined( 'DS' ) ) {
			if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
				define('DS', '\\');
			}
			else {
				define('DS', '/');
			}
		}

		// Include plugin-detective-config.php if it exists
		$path_to_pd_config = dirname( dirname( dirname ( $this->plugin->dir() ) ) ) . '/' . 'plugin-detective-config.php';
		if ( @file_exists( $path_to_pd_config ) ) {
			include_once( $path_to_pd_config );
		}


		// Define ABSPATH
		if ( !defined('ABSPATH') ) {
			$ABSPATH = dirname( dirname( dirname ( $this->plugin->dir() ) ) ) . '/';

			for ($i=0; $i < 3; $i++) { 			
				if ( @file_exists( $ABSPATH . 'wp-settings.php' ) ) {
					define('ABSPATH', $ABSPATH );
					break;
				} else if ( @file_exists( $ABSPATH . 'wp/wp-settings.php' ) ) {
					define('ABSPATH', $ABSPATH . 'wp/' );
					break;
				} else if ( @file_exists( $ABSPATH . 'wp-load.php' ) ) {
					define('ABSPATH', $ABSPATH . 'wp/' );
					break;
				} else if ( @file_exists( $ABSPATH . 'wp/wp-load.php' ) ) {
					define('ABSPATH', $ABSPATH . 'wp/' );
					break;
				}

				$ABSPATH = dirname( $ABSPATH ) . '/';
			}

			if ( !defined( 'ABSPATH' ) ) {
				echo '<p>It\'s possible you have an unusual directory structure, and we can\'t find the path to the root of your WordPress install.'.'</p>';
				echo '<p>You can tell Plugin Detective about your install by creating a config file here:</p>';
				echo '<pre>'. $path_to_pd_config .'</pre>';
				echo '<p>where you define the path to your WP install</p>';
				echo '<code>'. "define( 'ABSPATH', '/path/to/wordpress/install/' );" .'</code>';
				echo '<p>You may want to define other customized values like <code>WP_CONTENT_DIR</code>, <code>WP_CONTENT_URL</code> or other values from your wp-config.php file that are unique to your install</p>';
				echo '<p>Error details: <code>Couldn\'t find ABSPATH from plugin path: ' . $this->plugin->dir() . '</code></p>';
				echo '<style>code { color: #333; background-color: #ccc; padding: 5px; }</style>';
				exit();
			}
		}

		// Search for wp-config.php
		$wp_config_dir_path = ABSPATH . 'wp-config.php';
		if ( ! @file_exists( $wp_config_dir_path ) ) {
			$wp_config_dir_path = dirname( ABSPATH ) . '/' . 'wp-config.php';

			if ( ! @file_exists( $wp_config_dir_path ) ) {
				$wp_config_dir_path = ABSPATH . 'wp' . '/' . 'wp-config.php';

				if ( ! @file_exists( $wp_config_dir_path ) ) {
					die( "Unable to locate wp-config.php file: \n" . ABSPATH. 'wp-config.php' . "\n OR \n" . dirname( ABSPATH ) . '/' . 'wp-config.php' );
				}
			}
		}


		if ( isset($_ENV['PANTHEON_ENVIRONMENT']) ) {
			define('DB_NAME', $_ENV['DB_NAME']);

			/** MySQL database username */
			define('DB_USER', $_ENV['DB_USER']);

			/** MySQL database password */
			define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

			/** MySQL hostname; on Pantheon this includes a specific port number. */
			define('DB_HOST', $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT']);
		}

		$config_files = array(
			dirname( $wp_config_dir_path ) . '/wp-config-local.php',
			dirname( $wp_config_dir_path ) . '/wp-config-hosting.php',
			$wp_config_dir_path,
		);
		$attempts = array(
			'standard',
			'normalize',
		);
		$methods = array(
			'php-define',
			'php-define-double-quote',
			'php-unquoted',
		);

		foreach ($config_files as $key => $config_file_path) {
			if ( !file_exists( $config_file_path ) ) {
				continue;
			}

			foreach ($attempts as $key => $attempt) {
				if ( $attempt === 'normalize' ) {
					$config_file = new PDT_Config( $config_file_path, true );
				} else {
					$config_file = new PDT_Config( $config_file_path );
				}
				foreach ($methods as $key => $method) {
			        $config_file->set_type( $method );
					if ( empty( $DB_USER ) ) {
						$DB_USER = $config_file->get_key( 'DB_USER' );
					}
					if ( empty( $DB_NAME ) ) {
						$DB_NAME = $config_file->get_key( 'DB_NAME' );
					}
					if ( empty( $DB_PASSWORD ) ) {
						$DB_PASSWORD = $config_file->get_key( 'DB_PASSWORD' );
					}
					if ( empty( $DB_HOST ) ) {
						$DB_HOST = $config_file->get_key( 'DB_HOST' );
					}
					if ( empty( $WP_CONTENT_DIR ) ) {
						$WP_CONTENT_DIR = $config_file->get_key( 'WP_CONTENT_DIR' );
					}
					if ( empty( $WP_CONTENT_URL ) ) {
						$WP_CONTENT_URL = $config_file->get_key( 'WP_CONTENT_URL' );
					}

					if ( !empty( $DB_USER ) ) {
						break;
					}
				}
			}
		}

		if ( empty( $DB_USER ) ) {
			echo '<h3>Unable to read database credentials from wp-config.php</h3>';
			echo '<h5>They should be formatted like this in your wp-config.php file:</h5>';
			echo "<pre>
// ** MySQL settings - You can get this info from your web host ** //
define( 'DB_NAME', 'database_name_here' );

/** MySQL database username */
define( 'DB_USER', 'username_here' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password_here' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
</pre>";
			echo '<h5>If you are still having trouble connecting, please contact us by emailing support@tylerdigital.com with a copy of your file (you may want to remove any sensitive data first)</h5>';
			exit();
		}

		$DB_USER = str_replace( '");', '', $DB_USER );
		$DB_USER = ( strpos( $DB_USER, '"' ) === 0 ) ? substr( $DB_USER, 1 ) : $DB_USER;
		$DB_USER = str_replace( '\');', '', $DB_USER );
		$DB_USER = ( strpos( $DB_USER, '\'' ) === 0 ) ? substr( $DB_USER, 1 ) : $DB_USER;


		$DB_NAME = str_replace( '");', '', $DB_NAME );
		$DB_NAME = ( strpos( $DB_NAME, '"' ) === 0 ) ? substr( $DB_NAME, 1 ) : $DB_NAME;
		$DB_NAME = str_replace( '\');', '', $DB_NAME );
		$DB_NAME = ( strpos( $DB_NAME, '\'' ) === 0 ) ? substr( $DB_NAME, 1 ) : $DB_NAME;


		$DB_PASSWORD = str_replace( '");', '', $DB_PASSWORD );
		$DB_PASSWORD = ( strpos( $DB_PASSWORD, '"' ) === 0 ) ? substr( $DB_PASSWORD, 1 ) : $DB_PASSWORD;
		$DB_PASSWORD = str_replace( '\');', '', $DB_PASSWORD );
		$DB_PASSWORD = ( strpos( $DB_PASSWORD, '\'' ) === 0 ) ? substr( $DB_PASSWORD, 1 ) : $DB_PASSWORD;


		$DB_HOST = str_replace( '");', '', $DB_HOST );
		$DB_HOST = ( strpos( $DB_HOST, '"' ) === 0 ) ? substr( $DB_HOST, 1 ) : $DB_HOST;
		$DB_HOST = str_replace( '\');', '', $DB_HOST );
		$DB_HOST = ( strpos( $DB_HOST, '\'' ) === 0 ) ? substr( $DB_HOST, 1 ) : $DB_HOST;

		if ( !defined( 'DB_USER' ) ) {
			define( 'DB_USER', $DB_USER );
		}
		if ( !defined( 'DB_NAME' ) ) {
			define( 'DB_NAME', $DB_NAME );
		}
		if ( !defined( 'DB_PASSWORD' ) ) {
			define( 'DB_PASSWORD', $DB_PASSWORD );
		}
		if ( !defined( 'DB_HOST' ) ) {
			define( 'DB_HOST', $DB_HOST );
		}

		if ( !empty( $WP_CONTENT_DIR ) ) {
			define( 'WP_CONTENT_DIR', $WP_CONTENT_DIR );
		}

		if ( !empty( $WP_CONTENT_URL ) ) {
			define( 'WP_CONTENT_URL', $WP_CONTENT_URL );
		}

		$config_file->set_type( 'php-variable' );
		global $table_prefix;
		$table_prefix = $config_file->get_key( 'table_prefix' );
		$GLOBALS['table_prefix'] = $table_prefix;

		if ( !defined('WP_CONTENT_DIR') )
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); // no trailing slash, full paths only - WP_CONTENT_URL is defined further down

		// Add define('WP_DEBUG', true); to wp-config.php to enable display of notices during development.
		if ( !defined('WP_DEBUG') )
			define( 'WP_DEBUG', false );

		// Add define('WP_DEBUG_DISPLAY', null); to wp-config.php use the globally configured setting for
		// display_errors and not force errors to be displayed. Use false to force display_errors off.
		if ( !defined('WP_DEBUG_DISPLAY') )
			define( 'WP_DEBUG_DISPLAY', true );

		// Add define('WP_DEBUG_LOG', true); to enable error logging to wp-content/debug.log.
		if ( !defined('WP_DEBUG_LOG') )
			define('WP_DEBUG_LOG', false);

		if ( !defined('WP_CACHE') )
			define('WP_CACHE', false);

		// Start of run timestamp.
		if ( ! defined( 'WP_START_TIMESTAMP' ) ) {
			define( 'WP_START_TIMESTAMP', microtime( true ) );
		}

		/**
		 * Private
		 */
		if ( !defined('MEDIA_TRASH') )
			define('MEDIA_TRASH', false);

		if ( !defined('SHORTINIT') )
			define('SHORTINIT', false);

		/**
		 * Allows for the plugins directory to be moved from the default location.
		 *
		 * @since 2.6.0
		 */
		if ( !defined('WP_PLUGIN_DIR') )
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' ); // full path, no trailing slash

		/**
		 * Allows for the plugins directory to be moved from the default location.
		 *
		 * @since 2.1.0
		 * @deprecated
		 */
		if ( !defined('PLUGINDIR') )
			define( 'PLUGINDIR', 'wp-content/plugins' ); // Relative to ABSPATH. For back compat.

		/**
		 * Allows for the mu-plugins directory to be moved from the default location.
		 *
		 * @since 2.8.0
		 */
		if ( !defined('WPMU_PLUGIN_DIR') )
			define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins' ); // full path, no trailing slash

		/**
		 * Allows for the mu-plugins directory to be moved from the default location.
		 *
		 * @since 2.8.0
		 * @deprecated
		 */
		if ( !defined( 'MUPLUGINDIR' ) )
			define( 'MUPLUGINDIR', 'wp-content/mu-plugins' ); // Relative to ABSPATH. For back compat.

		
	}

}
