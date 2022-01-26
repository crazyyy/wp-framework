<?php

/**
 * Autoloads files with classes when needed.
 *
 * @since  0.0.0
 * @param  string $class_name Name of the class being requested.
 */
function pd_troubleshoot_autoload_classes( $class_name ) {

	// If our class doesn't have our prefix, don't load it.
	if ( 0 !== strpos( $class_name, 'PDT_' ) ) {
		return;
	}

	// Set up our filename.
	$filename = strtolower( str_replace( '_', '-', substr( $class_name, strlen( 'PDT_' ) ) ) );
	// Include our file.
	PD_Troubleshoot::include_file( 'includes/class-' . $filename );
}
spl_autoload_register( 'pd_troubleshoot_autoload_classes' );

/**
 * Main initiation class.
 *
 * @since  0.0.0
 */
final class PD_Troubleshoot {

	/**
	 * Current version.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	const VERSION = '1.1.9';

	/**
	 * URL of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $url = '';

	/**
	 * Path of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $path = '';

	/**
	 * Plugin basename.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $basename = '';

	/**
	 * Detailed activation error messages.
	 *
	 * @var    array
	 * @since  0.0.0
	 */
	protected $activation_errors = array();

	/**
	 * Singleton instance of plugin.
	 *
	 * @var    PD_Troubleshoot
	 * @since  0.0.0
	 */
	protected static $single_instance = null;

	/**
	 * Instance of PDT_Filesystem
	 *
	 * @since0.0.0
	 * @var PDT_Filesystem
	 */
	protected $filesystem;

	/**
	 * Instance of PDT_Constants
	 *
	 * @since0.0.0
	 * @var PDT_Constants
	 */
	protected $constants;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since   0.0.0
	 * @return  PD_Troubleshoot A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin.
	 *
	 * @since  0.0.0
	 */
	protected function __construct() {
		$this->constants = new PDT_Constants( $this );
		$this->bootstrap = new PDT_Bootstrap( $this );
		
		if ( !defined('WP_CONTENT_URL') )
			define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); // full url - WP_CONTENT_DIR is defined further up

		/**
		 * Allows for the plugins directory to be moved from the default location.
		 *
		 * @since 2.6.0
		 */
		if ( !defined('WP_PLUGIN_URL') )
			define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' ); // full url, no trailing slash

		/**
		 * Allows for the mu-plugins directory to be moved from the default location.
		 *
		 * @since 2.8.0
		 */
		if ( !defined('WPMU_PLUGIN_URL') )
			define( 'WPMU_PLUGIN_URL', WP_CONTENT_URL . '/mu-plugins' ); // full url, no trailing slash


		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );

		$this->plugin_classes();
	}

	public static function maybe_fix_protocol( $url, $desired_protocol = null ) {
		$pos_of_colon_slash_slash = strpos( $url, '://' );
		if ( $pos_of_colon_slash_slash === false ) {
			return $url;
		}

		if ( empty( $desired_protocol ) ) {
			if ( defined( 'PD_PROTOCOL' ) && str_to_lower( PD_PROTOCOL ) === 'https' ) {
				$desired_protocol = 'https';
			} else {
				$desired_protocol = 'http';
			}
			if ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) {
				$desired_protocol = 'https';
			} elseif ( !empty( $_SERVER['REDIRECT_HTTPS'] ) && $_SERVER['REDIRECT_HTTPS'] !== 'off' ) {
				$desired_protocol = 'https';
			} elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
				$desired_protocol = 'https';
			} elseif ( !empty( $_SERVER['protocol'] ) ) {
				$desired_protocol = strtolower( substr( $_SERVER["SERVER_PROTOCOL"], 0, 5 ) ) == 'https' ? 'https' : 'http';
			}
		}

		$url = $desired_protocol . '://' . substr( $url, $pos_of_colon_slash_slash + 3 );

		return $url;
	}

	public static function maybe_fix_www_prefix( $url, $should_be_www = null ) {
		$pos_of_colon_slash_slash = strpos( $url, '://' );
		if ( $pos_of_colon_slash_slash === false ) {
			return $url;
		}

		if ( $should_be_www === null ) {
			if ( strpos( $_SERVER['HTTP_HOST'], 'www.' ) === 0 ) {
				$should_be_www = true;
			} else {
				$should_be_www = false;
			}
		}

		if ( !empty( $should_be_www ) ) {
			$url = str_replace( array(
				'://',
				'://www.www.',
			), array( 
				'://www.',
				'://www.',
			), $url );
		} else {
			$url = str_replace( array(
				'://www.www.',
				'://www.',
			), array( 
				'://',
				'://',
			), $url );
		}

		return $url;
	}

	public function get_api_params() {
		return array(
			'site_url' => self::maybe_fix_www_prefix( self::maybe_fix_protocol( site_url() ) ),
			'api_url' => self::maybe_fix_www_prefix( self::maybe_fix_protocol( $this->url( 'api.php' ) ) ),
			'static_url' => self::maybe_fix_www_prefix( self::maybe_fix_protocol( $this->url( 'app/dist/static' ) ) ),
		);
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since  0.0.0
	 */
	public function plugin_classes() {
		$this->filesystem = new PDT_Filesystem( $this );
		$this->auth = new PDT_Auth( $this );
		$this->api = new PDT_Api( $this );
		$this->plugins = new PDT_Plugins( $this );
		$this->installed = new PDT_Installed( $this );
		$this->cases = new PDT_Cases( $this );
		$this->clues = new PDT_Clues( $this );
		$this->detective = new PDT_Detective( $this );
	} // END OF PLUGIN CLASSES FUNCTION

	/**
	 * Activate the plugin.
	 *
	 * @since  0.0.0
	 */
	public function _activate() {
		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin.
	 * Uninstall routines should be in uninstall.php.
	 *
	 * @since  0.0.0
	 */
	public function _deactivate() {
		// Add deactivation cleanup functionality here.
	}

	/**
	 * Init hooks
	 *
	 * @since  0.0.0
	 */
	public function init() {

		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Load translated strings for plugin.
		load_plugin_textdomain( 'plugin-detective', false, dirname( $this->basename ) . '/languages/' );


		// Initialize plugin classes.
		$this->plugin_classes();
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  0.0.0
	 *
	 * @return boolean True if requirements met, false if not.
	 */
	public function check_requirements() {

		// Bail early if plugin meets requirements.
		if ( $this->meets_requirements() ) {
			return true;
		}

		// Add a dashboard notice.
		add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

		// Deactivate our plugin.
		add_action( 'admin_init', array( $this, 'deactivate_me' ) );

		// Didn't meet the requirements.
		return false;
	}

	/**
	 * Deactivates this plugin, hook this function on admin_init.
	 *
	 * @since  0.0.0
	 */
	public function deactivate_me() {

		// We do a check for deactivate_plugins before calling it, to protect
		// any developers from accidentally calling it too early and breaking things.
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

	/**
	 * Check that all plugin requirements are met.
	 *
	 * @since  0.0.0
	 *
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {

		// Do checks for required classes / functions or similar.
		// Add detailed messages to $this->activation_errors array.
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met.
	 *
	 * @since  0.0.0
	 */
	public function requirements_not_met_notice() {

		// Compile default message.
		$default_message = sprintf( __( 'Troubleshoot is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'troubleshoot' ), admin_url( 'plugins.php' ) );

		// Default details to null.
		$details = null;

		// Add details if any exist.
		if ( $this->activation_errors && is_array( $this->activation_errors ) ) {
			$details = '<small>' . implode( '</small><br /><small>', $this->activation_errors ) . '</small>';
		}

		// Output errors.
		?>
		<div id="message" class="error">
			<p><?php echo wp_kses_post( $default_message ); ?></p>
			<?php echo wp_kses_post( $details ); ?>
		</div>
		<?php
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  0.0.0
	 *
	 * @param  string $field Field to get.
	 * @throws Exception     Throws an exception if the field is invalid.
	 * @return mixed         Value of the field.
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::VERSION;
			case 'basename':
			case 'url':
			case 'path':
			case 'filesystem':
			case 'constants':
			case 'bootstrap':
			case 'auth':
			case 'api':
			case 'plugins':
			case 'installed':
			case 'cases':
			case 'clues':
			case 'detective':
				return $this->$field;
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}

	/**
	 * Include a file from the includes directory.
	 *
	 * @since  0.0.0
	 *
	 * @param  string $filename Name of the file to be included.
	 * @return boolean          Result of include call.
	 */
	public static function include_file( $filename ) {
		$file = self::dir( $filename . '.php' );
		if ( file_exists( $file ) ) {
			return include_once( $file );
		}
		return false;
	}

	/**
	 * This plugin's directory.
	 *
	 * @since  0.0.0
	 *
	 * @param  string $path (optional) appended path.
	 * @return string       Directory and path.
	 */
	public static function dir( $path = '' ) {
		static $dir;
		$dir = $dir ? $dir : rtrim( dirname( __FILE__ ), '/\\' ).'/';
		return $dir . $path;
	}

	/**
	 * This plugin's url.
	 *
	 * @since  0.0.0
	 *
	 * @param  string $path (optional) appended path.
	 * @return string       URL and path.
	 */
	public static function url( $path = '' ) {
		static $url;
		$url = $url ? $url : trailingslashit( plugin_dir_url( __FILE__ ) );
		return $url . $path;
	}

	public function get_translations() {
		include dirname( $this->dir() ) .  '/languages/troubleshoot-app-translations.php';

		return $translations;
	}
}

/**
 * Grab the PD_Troubleshoot object and return it.
 * Wrapper for PD_Troubleshoot::get_instance().
 *
 * @since  0.0.0
 * @return PD_Troubleshoot  Singleton instance of plugin class.
 */
function pd_troubleshoot() {
	return PD_Troubleshoot::get_instance();
}