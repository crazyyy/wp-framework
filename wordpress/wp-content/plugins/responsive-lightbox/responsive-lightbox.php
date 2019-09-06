<?php
/*
Plugin Name: Responsive Lightbox & Gallery
Description: Responsive Lightbox & Gallery allows users to create galleries and view larger versions of images, galleries and videos in a lightbox (overlay) effect optimized for mobile devices.
Version: 2.1.0
Author: dFactory
Author URI: http://www.dfactory.eu/
Plugin URI: http://www.dfactory.eu/plugins/responsive-lightbox/
License: MIT License
License URI: http://opensource.org/licenses/MIT
Text Domain: responsive-lightbox
Domain Path: /languages

Responsive Lightbox & Gallery
Copyright (C) 2013-2018, Digital Factory - info@digitalfactory.pl

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

/*
przy zmianie typu galerii na Featured Content nie dzialają Post Type, Post Status, itd, po zapisie juz tak
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

define( 'RESPONSIVE_LIGHTBOX_URL', plugins_url( '', __FILE__ ) );
define( 'RESPONSIVE_LIGHTBOX_PATH', plugin_dir_path( __FILE__ ) );
define( 'RESPONSIVE_LIGHTBOX_REL_PATH', dirname( plugin_basename( __FILE__ ) ) . DIRECTORY_SEPARATOR );

include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-fast-image.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-galleries.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-folders.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-frontend.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-settings.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-tour.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-welcome.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-widgets.php' );
include_once( RESPONSIVE_LIGHTBOX_PATH . 'includes' . DIRECTORY_SEPARATOR . 'functions.php' );

/**
 * Responsive Lightbox class.
 *
 * @class Responsive_Lightbox
 * @version	2.1.0
 */
class Responsive_Lightbox {

	public $defaults = array(
		'settings' => array(
			'tour'							=> true,
			'script'						=> 'swipebox',
			'selector'						=> 'lightbox',
			'default_gallery'				=> 'default',
			'builder_gallery'				=> 'basicgrid',
			'default_woocommerce_gallery'	=> 'default',
			'galleries'						=> true,
			'gallery_image_size'			=> 'full',
			'gallery_image_title'			=> 'default',
			'gallery_image_caption'			=> 'default',
			'force_custom_gallery'			=> false,
			'woocommerce_gallery_lightbox'	=> false,
			'videos'						=> true,
			'widgets'						=> false,
			'comments'						=> false,
			'image_links'					=> true,
			'image_title'					=> 'default',
			'image_caption'					=> 'default',
			'images_as_gallery'				=> false,
			'deactivation_delete'			=> false,
			'loading_place'					=> 'header',
			'conditional_loading'			=> false,
			'enable_custom_events'			=> false,
			'custom_events'					=> 'ajaxComplete',
			'update_version'				=> 1,
			'update_notice'					=> true,
			'update_delay_date'				=> 0
		),
		'builder' => array(
			'gallery_builder'		=> true,
			'categories'			=> true,
			'tags'					=> true,
			'permalink'				=> 'rl_gallery',
			'permalink_categories'	=> 'rl_category',
			'permalink_tags'		=> 'rl_tag',
			'archives'				=> true,
			'archives_category'		=> 'all'
		),
		'configuration' => array(
			'swipebox' => array(
				'animation'					=> 'css',
				'force_png_icons'			=> false,
				'hide_close_mobile'			=> false,
				'remove_bars_mobile'		=> false,
				'hide_bars'					=> true,
				'hide_bars_delay'			=> 5000,
				'video_max_width'			=> 1080,
				'loop_at_end'				=> false
			),
			'prettyphoto' => array(
				'animation_speed'			=> 'normal',
				'slideshow'					=> false,
				'slideshow_delay'			=> 5000,
				'slideshow_autoplay'		=> false,
				'opacity'					=> 75,
				'show_title'				=> true,
				'allow_resize'				=> true,
				'allow_expand'				=> true,
				'width'						=> 1080,
				'height'					=> 720,
				'separator'					=> '/',
				'theme'						=> 'pp_default',
				'horizontal_padding'		=> 20,
				'hide_flash'				=> false,
				'wmode'						=> 'opaque',
				'video_autoplay'			=> false,
				'modal'						=> false,
				'deeplinking'				=> false,
				'overlay_gallery'			=> true,
				'keyboard_shortcuts'		=> true,
				'social'					=> false
			),
			'fancybox' => array(
				'modal'						=> false,
				'show_overlay'				=> true,
				'show_close_button'			=> true,
				'enable_escape_button'		=> true,
				'hide_on_overlay_click'		=> true,
				'hide_on_content_click'		=> false,
				'cyclic'					=> false,
				'show_nav_arrows'			=> true,
				'auto_scale'				=> true,
				'scrolling'					=> 'yes',
				'center_on_scroll'			=> true,
				'opacity'					=> true,
				'overlay_opacity'			=> 70,
				'overlay_color'				=> '#666',
				'title_show'				=> true,
				'title_position'			=> 'outside',
				'transitions'				=> 'fade',
				'easings'					=> 'swing',
				'speeds'					=> 300,
				'change_speed'				=> 300,
				'change_fade'				=> 100,
				'padding'					=> 5,
				'margin'					=> 5,
				'video_width'				=> 1080,
				'video_height'				=> 720
			),
			'nivo' => array(
				'effect'					=> 'fade',
				'click_overlay_to_close'	=> true,
				'keyboard_nav'				=> true,
				'error_message'				=> 'The requested content cannot be loaded. Please try again later.'
			),
			'imagelightbox' => array(
				'animation_speed'			=> 250,
				'preload_next'				=> true,
				'enable_keyboard'			=> true,
				'quit_on_end'				=> false,
				'quit_on_image_click'		=> false,
				'quit_on_document_click'	=> true
			),
			'tosrus' => array(
				'effect'					=> 'slide',
				'infinite'					=> true,
				'keys'						=> false,
				'autoplay'					=> true,
				'pause_on_hover'			=> false,
				'timeout'					=> 4000,
				'pagination'				=> true,
				'pagination_type'			=> 'thumbnails',
				'close_on_click'			=> false
			),
			'featherlight' => array(
				'open_speed'				=> 250,
				'close_speed'				=> 250,
				'close_on_click'			=> 'background',
				'close_on_esc'				=> true,
				'gallery_fade_in'			=> 100,
				'gallery_fade_out'			=> 300
			),
			'magnific' => array(
				'disable_on'				=> 0,
				'mid_click'					=> true,
				'preloader'					=> true,
				'close_on_content_click'	=> true,
				'close_on_background_click'	=> true,
				'close_button_inside'		=> true,
				'show_close_button'			=> true,
				'enable_escape_key'			=> true,
				'align_top'					=> false,
				'fixed_content_position'	=> 'auto',
				'fixed_background_position'	=> 'auto',
				'auto_focus_last'			=> true
			)
		),
		'folders' => array(
			'active'			=> false,
			'media_taxonomy'	=> 'rl_media_folder',
			// 'jstree_style'		=> 'default',
			'jstree_wholerow'	=> true,
			'show_in_menu'		=> false,
			'folders_removal'	=> true
		),
		'basicgrid_gallery'	=> array(
			'columns_lg'		=> 4,
			'columns_md'		=> 3,
			'columns_sm'		=> 2,
			'columns_xs'		=> 1,
			'gutter'			=> 2,
			'force_height'		=> false,
			'row_height'		=> 150
		),
		'basicslider_gallery' => array(
			'adaptive_height'		=> true,
			'loop'					=> false,
			'captions'				=> 'overlay',
			'init_single'			=> true,
			'responsive'			=> true,
			'preload'				=> 'visible',
			'pager'					=> true,
			'controls'				=> true,
			'hide_on_end'			=> true,
			'slide_margin'			=> 0,
			'transition'			=> 'fade',
			'kenburns_zoom'			=> 120,
			'speed'					=> 800,
			'easing'				=> 'swing',
			'continuous'			=> true,
			'use_css'				=> true,
			'slideshow'				=> true,
			'slideshow_direction'	=> 'next',
			'slideshow_hover'		=> true,
			'slideshow_hover_delay'	=> 100,
			'slideshow_delay'		=> 500,
			'slideshow_pause'		=> 3000
		),
		'basicmasonry_gallery' => array(
			'columns_lg'		=> 4,
			'columns_md'		=> 3,
			'columns_sm'		=> 2,
			'columns_xs'		=> 2,
			'gutter'			=> 20,
			'margin'			=> 20,
			'origin_left'		=> true,
			'origin_top'		=> true
		),
		'version' => '2.1.0',
		'activation_date' => ''
	);
	public $options = array();
	public $gallery_types = array();
	private $version = false;
	private $notices = array();
	private static $_instance;

	private function __clone() {}
	private function __wakeup() {}

	/**
	 * Main Responsive Lightbox instance.
	 * 
	 * @return object
	 */
	public static function instance() {
		if ( self::$_instance === null )
			self::$_instance = new self();

		return self::$_instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'activate_multisite' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate_multisite' ) );

		// change from older versions
		$this->version = $db_version = get_option( 'responsive_lightbox_version' );

		// legacy version update
		if ( version_compare( ( $db_version === false ? '1.0.0' : $db_version ), '1.0.5', '<' ) ) {
			if ( ( $array = get_option( 'rl_settings' ) ) !== false ) {
				update_option( 'responsive_lightbox_settings', $array );
				delete_option( 'rl_settings' );
			}

			if ( ( $array = get_option( 'rl_configuration' ) ) !== false ) {
				update_option( 'responsive_lightbox_configuration', $array );
				delete_option( 'rl_configuration' );
			}
		// plugin version update
		} elseif ( version_compare( ( $db_version === false ? '1.0.0' : $db_version ), $this->defaults['version'], '<' ) )
			update_option( 'responsive_lightbox_version', $this->defaults['version'], false );

		$this->options['settings'] = array_merge( $this->defaults['settings'], ( ( $array = get_option( 'responsive_lightbox_settings' ) ) === false ? array() : $array ) );
		$this->options['folders'] = array_merge( $this->defaults['folders'], ( ( $array = get_option( 'responsive_lightbox_folders' ) ) === false ? array() : $array ) );
		$this->options['builder'] = array_merge( $this->defaults['builder'], ( ( $array = get_option( 'responsive_lightbox_builder' ) ) === false ? array() : $array ) );

		// for multi arrays we have to merge them separately
		$db_conf_opts = ( ( $base = get_option( 'responsive_lightbox_configuration' ) ) === false ? array() : $base );

		foreach ( $this->defaults['configuration'] as $script => $settings ) {
			$this->options['configuration'][$script] = array_merge( $settings, ( isset( $db_conf_opts[$script] ) ? $db_conf_opts[$script] : array() ) );
		}

		// add default galleries options
		$this->options['basicgrid_gallery'] = array_merge( $this->defaults['basicgrid_gallery'], ( ( $array = get_option( 'responsive_lightbox_basicgrid_gallery', $this->defaults['basicgrid_gallery'] ) ) == false ? array() : $array ) );
		$this->options['basicslider_gallery'] = array_merge( $this->defaults['basicslider_gallery'], ( ( $array = get_option( 'responsive_lightbox_basicslider_gallery', $this->defaults['basicslider_gallery'] ) ) == false ? array() : $array ) );
		$this->options['basicmasonry_gallery'] = array_merge( $this->defaults['basicmasonry_gallery'], ( ( $array = get_option( 'responsive_lightbox_basicmasonry_gallery', $this->defaults['basicmasonry_gallery'] ) ) == false ? array() : $array ) );

		// actions
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this, 'init_galleries' ) );
		add_action( 'init', array( $this, 'init_folders' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts_styles' ) );
		add_action( 'sidebar_admin_setup', array( $this, 'sidebar_admin_setup' ) );
		add_action( 'admin_init', array( $this, 'update_notice' ) );
		add_action( 'wp_ajax_rl_dismiss_notice', array( $this, 'dismiss_notice' ) );

		// filters
		add_filter( 'plugin_action_links', array( $this, 'plugin_settings_link' ), 10, 2 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_extend_links' ), 10, 2 );
	}

	/**
	 * Single site activation function.
	 */
	public function activate_single() {
		// transient for welcome screen
		if ( get_option( 'responsive_lightbox_activation_date', false ) === false )
			set_transient( 'rl_activation_redirect', 1, 3600 );
		elseif ( $this->version !== false ) {
			// activated from old version
			if ( version_compare( $this->version, '2.0.0', '<' ) ) {
				set_transient( 'rl_activation_redirect', 1, 3600 );
			}
		} else
			set_transient( 'rl_activation_redirect', 1, 3600 );

		add_option( 'responsive_lightbox_settings', $this->defaults['settings'], '', 'no' );
		add_option( 'responsive_lightbox_configuration', $this->defaults['configuration'], '', 'no' );
		add_option( 'responsive_lightbox_folders', $this->defaults['folders'], '', 'no' );
		add_option( 'responsive_lightbox_builder', $this->defaults['builder'], '', 'no' );
		add_option( 'responsive_lightbox_version', $this->defaults['version'], '', 'no' );

		// permalinks
		flush_rewrite_rules();
	}
	
	/**
	 * Single site deactivation function.
	 * 
	 * @param bool $multi
	 */
	public function deactivate_single( $multi = false ) {
		if ( $multi === true ) {
			$options = get_option( 'responsive_lightbox_settings' );
			$check = $options['deactivation_delete'];
		} else
			$check = $this->options['settings']['deactivation_delete'];

		if ( $check ) {
			delete_option( 'responsive_lightbox_settings' );
			delete_option( 'responsive_lightbox_configuration' );
			delete_option( 'responsive_lightbox_folders' );
			delete_option( 'responsive_lightbox_builder' );
			delete_option( 'responsive_lightbox_version' );
		}

		// permalinks
		flush_rewrite_rules();
	}

	/**
	 * Activation function.
	 * 
	 * @param bool $networkwide
	 */
	public function activate_multisite( $networkwide ) {
		if ( is_multisite() && $networkwide ) {
			global $wpdb;

			$activated_blogs = array();
			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT blog_id FROM ' . $wpdb->blogs, '' ) );

			foreach ( $blogs_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->activate_single();
				$activated_blogs[] = (int) $blog_id;
			}

			switch_to_blog( $current_blog_id );
			update_site_option( 'responsive_lightbox_activated_blogs', $activated_blogs, array() );
		} else
			$this->activate_single();
	}

	/**
	 * Dectivation function.
	 * 
	 * @param bool $networkwide
	 */
	public function deactivate_multisite( $networkwide ) {
		if ( is_multisite() && $networkwide ) {
			global $wpdb;

			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT blog_id FROM ' . $wpdb->blogs, '' ) );

			if ( ($activated_blogs = get_site_option( 'responsive_lightbox_activated_blogs', false, false )) === false )
				$activated_blogs = array();

			foreach ( $blogs_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->deactivate_single( true );

				if ( in_array( (int) $blog_id, $activated_blogs, true ) )
					unset( $activated_blogs[array_search( $blog_id, $activated_blogs )] );
			}

			switch_to_blog( $current_blog_id );
			update_site_option( 'responsive_lightbox_activated_blogs', $activated_blogs );
		} else
			$this->deactivate_single();
	}

	/**
	 * Load textdomain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'responsive-lightbox', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		// gallery types
		$this->gallery_types = array(
			'default'		=> __( 'Default', 'responsive-lightbox' ),
			'basicgrid'		=> __( 'Basic Grid', 'responsive-lightbox' ),
			'basicslider'	=> __( 'Basic Slider', 'responsive-lightbox' ),
			'basicmasonry'	=> __( 'Basic Masonry', 'responsive-lightbox' )
		);
	}

	/**
	 * Update notice.
	 */
	public function update_notice() {
		if ( ! current_user_can( 'install_plugins' ) )
			return;

		$current_update = 2;

		// get current time
		$current_time = time();

		if ( $this->options['settings']['update_version'] < $current_update ) {
			// check version, if update ver is lower than plugin ver, set update notice to true
			$this->options['settings'] = array_merge( $this->options['settings'], array( 'update_version' => $current_update, 'update_notice' => true ) );

			update_option( 'responsive_lightbox_settings', $this->options['settings'] );

			// set activation date
			$activation_date = get_option( 'responsive_lightbox_activation_date' );

			if ( $activation_date === false )
				update_option( 'responsive_lightbox_activation_date', $current_time );
		}

		// display current version notice
		if ( $this->options['settings']['update_notice'] === true ) {
			// include notice js, only if needed
			add_action( 'admin_print_scripts', array( $this, 'admin_inline_js' ), 999 );

			// get activation date
			$activation_date = get_option( 'responsive_lightbox_activation_date' );

			if ( (int) $this->options['settings']['update_delay_date'] === 0 ) {
				if ( $activation_date + 1209600 > $current_time )
					$this->options['settings']['update_delay_date'] = $activation_date + 1209600;
				else
					$this->options['settings']['update_delay_date'] = $current_time;

				update_option( 'responsive_lightbox_settings', $this->options['settings'] );
			}

			if ( ( ! empty( $this->options['settings']['update_delay_date'] ) ? (int) $this->options['settings']['update_delay_date'] : $current_time ) <= $current_time )
				$this->add_notice( sprintf( __( "Hey, you've been using <strong>Responsive Lightbox & Gallery</strong> for more than %s", 'responsive-lightbox' ), human_time_diff( $activation_date, $current_time ) ) . '<br />' . __( 'Could you please do me a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation.', 'responsive-lightbox' ) . '<br /><br />' . __( 'Your help is much appreciated. Thank you very much', 'responsive-lightbox' ) . ' ~ <strong>Bartosz Arendt</strong>, ' . sprintf( __( 'founder of <a href="%s" target="_blank">dFactory</a> plugins.', 'responsive-lightbox' ), 'https://dfactory.eu/' ) . '<br /><br />' . sprintf( __( '<a href="%s" class="rl-dismissible-notice" target="_blank" rel="noopener">Ok, you deserve it</a><br /><a href="javascript:void(0);" class="rl-dismissible-notice rl-delay-notice" rel="noopener">Nope, maybe later</a><br /><a href="javascript:void(0);" class="rl-dismissible-notice" rel="noopener">I already did</a>', 'responsive-lightbox' ), 'https://wordpress.org/support/plugin/responsive-lightbox/reviews/?filter=5#new-post' ), 'notice notice-info is-dismissible rl-notice' );
		}
	}
	
	/**
	 * Dismiss notice.
	 */
	public function dismiss_notice() {
		if ( ! current_user_can( 'install_plugins' ) )
			return;

		if ( wp_verify_nonce( esc_attr( $_REQUEST['nonce'] ), 'rl_dismiss_notice' ) ) {
			$notice_action = empty( $_REQUEST['notice_action'] ) || $_REQUEST['notice_action'] === 'hide' ? 'hide' : esc_attr( $_REQUEST['notice_action'] );

			switch ( $notice_action ) {
				// delay notice
				case 'delay':
					// set delay period to 1 week from now
					$this->options['settings'] = array_merge( $this->options['settings'], array( 'update_delay_date' => time() + 1209600 ) );
					update_option( 'responsive_lightbox_settings', $this->options['settings'] );
					break;

				// hide notice
				default:
					$this->options['settings'] = array_merge( $this->options['settings'], array( 'update_notice' => false ) );
					$this->options['settings'] = array_merge( $this->options['settings'], array( 'update_delay_date' => 0 ) );

					update_option( 'responsive_lightbox_settings', $this->options['settings'] );
			}
		}

		exit;
	}
	
	/**
	 * Add admin notices.
	 * 
	 * @param string $html
	 * @param string $status
	 * @param bool $paragraph
	 * @param bool $network
	 */
	public function add_notice( $html = '', $status = 'error', $paragraph = true, $network = false ) {
		$this->notices[] = array(
			'html' 		=> $html,
			'status' 	=> $status,
			'paragraph' => $paragraph
		);

		add_action( 'admin_notices', array( $this, 'display_notice') );

		if ( $network )
			add_action( 'network_admin_notices', array( $this, 'display_notice') );
	}
	
	/**
	 * Print admin notices.
	 * 
	 * @return mixed
	 */
	public function display_notice() {
		foreach( $this->notices as $notice ) {
			echo '
			<div class="' . $notice['status'] . '">
				' . ( $notice['paragraph'] ? '<p>' : '' ) . '
				' . $notice['html'] . '
				' . ( $notice['paragraph'] ? '</p>' : '' ) . '
			</div>';
		}
	}
	
	/**
	 * Print admin scripts.
	 * 
	 * @return mixed
	 */
	public function admin_inline_js() {
		if ( ! current_user_can( 'install_plugins' ) )
			return;
		?>
		<script type="text/javascript">
			( function ( $ ) {
				$( document ).ready( function () {
					// save dismiss state
					$( '.rl-notice.is-dismissible' ).on( 'click', '.notice-dismiss, .rl-dismissible-notice', function ( e ) {
						var notice_action = 'hide';
						
						if ( $( e.currentTarget ).hasClass( 'rl-delay-notice' ) ) {
							notice_action = 'delay'
						}
						
						$.post( ajaxurl, {
							action: 'rl_dismiss_notice',
							notice_action: notice_action,
							url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
							nonce: '<?php echo wp_create_nonce( 'rl_dismiss_notice' ); ?>'
						} );
					
						$( e.delegateTarget ).slideUp( 'fast' );
					} );
				} );
			} )( jQuery );
		</script>
		<?php
	}
	
	/**
	 * Add links to Support Forum.
	 * 
	 * @param array $links
	 * @param string $file
	 * @return array
	 */
	public function plugin_extend_links( $links, $file ) {
		if ( ! current_user_can( 'install_plugins' ) )
			return $links;

		$plugin = plugin_basename( __FILE__ );

		if ( $file == $plugin ) {
			return array_merge(
				$links, array( sprintf( '<a href="https://dfactory.eu/support/forum/responsive-lightbox/" target="_blank">%s</a>', __( 'Support', 'responsive-lightbox' ) ) )
			);
		}

		return $links;
	}

	/**
	 * Add links to Settings page.
	 * 
	 * @param array $links
	 * @param string $file
	 * @return array
	 */
	public function plugin_settings_link( $links, $file ) {
		if ( ! is_admin() || ! current_user_can( apply_filters( 'rl_lightbox_settings_capability', 'manage_options' ) ) )
			return $links;

		static $plugin;

		$plugin = plugin_basename( __FILE__ );

		if ( $file == $plugin ) {
			$settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php' ) . '?page=responsive-lightbox-settings', __( 'Settings', 'responsive-lightbox' ) );
			array_unshift( $links, $settings_link );
			
			$links[] = sprintf( '<a href="%s" style="color: green;">%s</a>', admin_url( 'admin.php' ) . '?page=responsive-lightbox-addons', __( 'Add-ons', 'responsive-lightbox' ) );
		}

		return $links;
	}

	/**
	 * Initialize galleries.
	 *
	 * @return void
	 */
	public function init_galleries() {
		// initialize gallery class
		new Responsive_Lightbox_Galleries( ! $this->options['builder']['gallery_builder'] );

		// end if in read only mode
		if ( ! $this->options['builder']['gallery_builder'] )
			return;

		$taxonomies = array();

		if ( $this->options['builder']['categories'] ) {
			$taxonomies[] = 'rl_category';

			register_taxonomy( 'rl_category', 'rl_gallery', array(
				'public'				 => true,
				'hierarchical'			 => true,
				'labels'				 => array(
					'name'				 => _x( 'Gallery Categories', 'taxonomy general name', 'responsive-lightbox' ),
					'singular_name'		 => _x( 'Gallery Category', 'taxonomy singular name', 'responsive-lightbox' ),
					'search_items'		 => __( 'Search Gallery Categories', 'responsive-lightbox' ),
					'all_items'			 => __( 'All Gallery Categories', 'responsive-lightbox' ),
					'parent_item'		 => __( 'Parent Gallery Category', 'responsive-lightbox' ),
					'parent_item_colon'	 => __( 'Parent Gallery Category:', 'responsive-lightbox' ),
					'edit_item'			 => __( 'Edit Gallery Category', 'responsive-lightbox' ),
					'view_item'			 => __( 'View Gallery Category', 'responsive-lightbox' ),
					'update_item'		 => __( 'Update Gallery Category', 'responsive-lightbox' ),
					'add_new_item'		 => __( 'Add New Gallery Category', 'responsive-lightbox' ),
					'new_item_name'		 => __( 'New Gallery Category Name', 'responsive-lightbox' ),
					'menu_name'			 => __( 'Categories', 'responsive-lightbox' )
				),
				'show_ui'				 => true,
				'show_admin_column'		 => true,
				'update_count_callback'	 => '_update_post_term_count',
				'query_var'				 => true,
				'rewrite'				 => array(
					'slug'			 => $this->options['builder']['permalink_categories'],
					'with_front'	 => false,
					'hierarchical'	 => false
				)
			) );
		}

		if ( $this->options['builder']['tags'] ) {
			$taxonomies[] = 'rl_tag';

			register_taxonomy( 'rl_tag', 'rl_gallery', array(
				'public'				 => true,
				'hierarchical'			 => false,
				'labels'				 => array(
					'name'						 => _x( 'Gallery Tags', 'taxonomy general name', 'responsive-lightbox' ),
					'singular_name'				 => _x( 'Gallery Tag', 'taxonomy singular name', 'responsive-lightbox' ),
					'search_items'				 => __( 'Search Gallery Tags', 'responsive-lightbox' ),
					'popular_items'				 => __( 'Popular Gallery Tags', 'responsive-lightbox' ),
					'all_items'					 => __( 'All Gallery Tags', 'responsive-lightbox' ),
					'parent_item'				 => null,
					'parent_item_colon'			 => null,
					'edit_item'					 => __( 'Edit Gallery Tag', 'responsive-lightbox' ),
					'update_item'				 => __( 'Update Gallery Tag', 'responsive-lightbox' ),
					'add_new_item'				 => __( 'Add New Gallery Tag', 'responsive-lightbox' ),
					'new_item_name'				 => __( 'New Gallery Tag Name', 'responsive-lightbox' ),
					'separate_items_with_commas' => __( 'Separate gallery tags with commas', 'responsive-lightbox' ),
					'add_or_remove_items'		 => __( 'Add or remove gallery tags', 'responsive-lightbox' ),
					'choose_from_most_used'		 => __( 'Choose from the most used gallery tags', 'responsive-lightbox' ),
					'menu_name'					 => __( 'Tags', 'responsive-lightbox' )
				),
				'show_ui'				 => true,
				'show_admin_column'		 => true,
				'update_count_callback'	 => '_update_post_term_count',
				'query_var'				 => true,
				'rewrite'				 => array(
					'slug'			 => $this->options['builder']['permalink_tags'],
					'with_front'	 => false,
					'hierarchical'	 => false
				)
			) );
		}

		// register rl_gallery
		register_post_type(
			'rl_gallery',
			array(
				'labels'				 => array(
					'name'				 => _x( 'Galleries', 'post type general name', 'responsive-lightbox' ),
					'singular_name'		 => _x( 'Gallery', 'post type singular name', 'responsive-lightbox' ),
					'add_new'			 => __( 'Add New', 'responsive-lightbox' ),
					'add_new_item'		 => __( 'Add New Gallery', 'responsive-lightbox' ),
					'edit_item'			 => __( 'Edit Gallery', 'responsive-lightbox' ),
					'new_item'			 => __( 'New Gallery', 'responsive-lightbox' ),
					'view_item'			 => __( 'View Gallery', 'responsive-lightbox' ),
					'view_items'		 => __( 'View Galleries', 'responsive-lightbox' ),
					'search_items'		 => __( 'Search Galleries', 'responsive-lightbox' ),
					'not_found'			 => __( 'No galleries found', 'responsive-lightbox' ),
					'not_found_in_trash' => __( 'No galleries found in trash', 'responsive-lightbox' ),
					'all_items'			 => __( 'All Galleries', 'responsive-lightbox' ),
					'menu_name'			 => __( 'Gallery', 'responsive-lightbox' )
				),
				'description'			 => '',
				'public'				 => true,
				'exclude_from_search'	 => false,
				'publicly_queryable'	 => true,
				'show_ui'				 => true,
				'show_in_menu'			 => true,
				'show_in_admin_bar'		 => true,
				'show_in_nav_menus'		 => true,
				'menu_position'			 => 57,
				'menu_icon'				 => 'dashicons-format-gallery',
				'map_meta_cap'			 => true,
				'hierarchical'			 => false,
				'supports'				 => array( 'title', 'author', 'thumbnail' ),
				'has_archive'			 => $this->options['builder']['archives'],
				'query_var'				 => true,
				'can_export'			 => true,
				'rewrite'				 => array(
					'slug'		 => $this->options['builder']['permalink'],
					'with_front' => false,
					'feed'		 => true,
					'pages'		 => true
				),
				'taxonomies'			 => $taxonomies
			)
		);

		if ( $this->options['builder']['archives'] && $this->options['builder']['archives_category'] !== 'all' && ! is_admin() )
			add_action( 'pre_get_posts', array( $this, 'gallery_archives' ) );

		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
	}

	/**
	 * Gallery update messages.
	 *
	 * @param array $messages
	 * @return array
	 */
	public function gallery_archives( $query ) {
		if ( is_post_type_archive( 'rl_gallery' ) ) {
			$query->set(
				'tax_query',
				array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'rl_category',
						'field'    => 'slug',
						'terms'    => $this->options['builder']['archives_category']
					)
				)
			);
		}
	}

	/**
	 * Gallery update messages.
	 *
	 * @param array $messages
	 * @return array
	 */
	public function post_updated_messages( $messages ) {
		$post = get_post();
		$post_type = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['rl_gallery'] = array(
			1	 => __( 'Gallery updated.', 'responsive-lightbox' ),
			4	 => __( 'Gallery updated.', 'responsive-lightbox' ),
			5	 => isset( $_GET['revision'] ) ? sprintf( __( 'Gallery restored to revision from %s', 'responsive-lightbox' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6	 => __( 'Gallery published.', 'responsive-lightbox' ),
			7	 => __( 'Gallery saved.', 'responsive-lightbox' ),
			8	 => __( 'Gallery submitted.', 'responsive-lightbox' ),
			9	 => sprintf(
			__( 'Gallery scheduled for: <strong>%1$s</strong>.', 'responsive-lightbox' ),
			date_i18n( __( 'M j, Y @ G:i', 'responsive-lightbox' ), strtotime( $post->post_date ) )
			),
			10	 => __( 'Gallery draft updated.', 'responsive-lightbox' )
		);

		if ( $post_type_object->publicly_queryable && 'rl_gallery' === $post_type ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View gallery', 'responsive-lightbox' ) );
			$messages[$post_type][1] .= $view_link;
			$messages[$post_type][6] .= $view_link;
			$messages[$post_type][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview gallery', 'responsive-lightbox' ) );
			$messages[$post_type][8] .= $preview_link;
			$messages[$post_type][10] .= $preview_link;
		}

		return $messages;
	}

	/**
	 * Initialize folders.
	 *
	 * @return void
	 */
	public function init_folders() {
		// initialize folder class
		new Responsive_Lightbox_Folders( ! $this->options['folders']['active'] );

		// end if in read only mode
		if ( ! $this->options['folders']['active'] )
			return;

		$this->register_media_taxonomy( 'rl_media_folder' );

		// get non-builtin hierarchical taxonomies
		$taxonomies = get_taxonomies(
			array(
				'object_type'	=> array( 'attachment' ),
				'hierarchical'	=> true,
				'_builtin'		=> false
			),
			'objects',
			'and'
		);

		$media_taxonomies = array();

		foreach ( $taxonomies as $taxonomy => $object ) {
			$media_taxonomies[$taxonomy] = $taxonomy . ' (' . $object->labels->menu_name . ')';
		}

		$tax = $this->options['folders']['media_taxonomy'];

		// selected hierarchical taxonomy does not exists?
		if ( ! in_array( $tax, $media_taxonomies, true ) ) {
			// check taxonomy existence
			if ( ( $taxonomy = get_taxonomy( $tax ) ) !== false ) {
				// update
				$media_taxonomies[$tax] = $tax . ' (' . $taxonomy->labels->menu_name . ')';
			// is it really old taxonomy?
			} elseif ( in_array( $tax, Responsive_Lightbox()->folders->get_taxonomies(), true ) ) {
				$this->register_media_taxonomy( $tax );

				$media_taxonomies[$tax] = $tax;
			// use default taxonomy
			} else {
				$media_taxonomies[$tax] = $tax;
				$this->options['folders']['media_taxonomy'] = $this->defaults['folders']['media_taxonomy'];

				update_option( 'responsive_lightbox_folders', $this->options['folders'] );
			}
		}

		$this->settings->settings['folders']['fields']['media_taxonomy']['options'] = $media_taxonomies;
	}

	/**
	 * Register media taxonomy.
	 */
	public function register_media_taxonomy( $taxonomy ) {
		register_taxonomy(
			$taxonomy,
			'attachment',
			array(
				'public'				=> true,
				'hierarchical'			=> true,
				'labels'				=> array(
					'name'				=> _x( 'Folders', 'taxonomy general name', 'responsive-lightbox' ),
					'singular_name'		=> _x( 'Folder', 'taxonomy singular name', 'responsive-lightbox' ),
					'search_items'		=> __( 'Search Folders', 'responsive-lightbox' ),
					'all_items'			=> __( 'All Files', 'responsive-lightbox' ),
					'parent_item'		=> __( 'Parent Folder', 'responsive-lightbox' ),
					'parent_item_colon'	=> __( 'Parent Folder:', 'responsive-lightbox' ),
					'edit_item'			=> __( 'Edit Folder', 'responsive-lightbox' ),
					'update_item'		=> __( 'Update Folder', 'responsive-lightbox' ),
					'add_new_item'		=> __( 'Add New Folder', 'responsive-lightbox' ),
					'new_item_name'		=> __( 'New Folder Name', 'responsive-lightbox' ),
					'not_found'			=> __( 'No folders found.', 'responsive-lightbox' ),
					'menu_name'			=> _x( 'Folders', 'taxonomy general name', 'responsive-lightbox' ),
				),
				'show_ui'				=> ! ( $taxonomy === 'rl_media_folder' && $this->options['folders']['media_taxonomy'] !== 'rl_media_folder' ),
				'show_in_menu'			=> ( $this->options['folders']['show_in_menu'] && ( ( $taxonomy === 'rl_media_folder' && $this->options['folders']['media_taxonomy'] === 'rl_media_folder' ) || ( $taxonomy !== 'rl_media_folder' && $this->options['folders']['media_taxonomy'] !== 'rl_media_folder' ) ) ),
				'show_in_nav_menus'		=> false,
				'show_in_quick_edit'	=> true,
				'show_tagcloud'			=> false,
				'show_admin_column'		=> true,
				'update_count_callback'	=> '_update_generic_term_count',
				'query_var'				=> false,
				'rewrite'				=> false
			)
		);
	}

	/**
	 * Enqueue admin scripts and styles.
	 * 
	 * @param string $page
	 */
	public function admin_scripts_styles( $page ) {
		if ( preg_match( '/^(toplevel|lightbox)_page_responsive-lightbox-(' . implode( '|', array_keys( Responsive_Lightbox()->settings->tabs ) ) . ')$/', $page ) === 1 ) {
			wp_enqueue_script( 'responsive-lightbox-admin', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), $this->defaults['version'] );

			wp_localize_script(
				'responsive-lightbox-admin',
				'rlArgs',
				array(
					'resetSettingsToDefaults'	=> __( 'Are you sure you want to reset these settings to defaults?', 'responsive-lightbox' ),
					'resetScriptToDefaults'		=> __( 'Are you sure you want to reset this script settings to defaults?', 'responsive-lightbox' ),
					'resetGalleryToDefaults'	=> __( 'Are you sure you want to reset this gallery settings to defaults?', 'responsive-lightbox' ),
					'tax_nonce'					=> wp_create_nonce( 'rl-folders-ajax-taxonomies-nonce' ),
				)
			);

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style( 'responsive-lightbox-admin', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->defaults['version'] );
		} elseif ( in_array( $page, array( 'post.php', 'edit.php', 'post-new.php' ), true ) && get_post_type() === 'rl_gallery' ) {
			wp_enqueue_media();

			wp_enqueue_script( 'responsive-lightbox-admin-galleries-select2', RESPONSIVE_LIGHTBOX_URL . '/assets/select2/js/select2.full' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', array( 'jquery' ), $this->defaults['version'] );

			wp_enqueue_script( 'responsive-lightbox-admin-galleries', RESPONSIVE_LIGHTBOX_URL . '/js/admin-galleries.js', array( 'jquery', 'wp-color-picker' ), $this->defaults['version'] );

			wp_localize_script(
				'responsive-lightbox-admin-galleries',
				'rlArgs',
				array(
					'mediaItemTemplate'	=> $this->galleries->media_item_template,
					'textSelectImages'	=> __( 'Select images', 'responsive-lightbox' ),
					'textUseImages'		=> __( 'Use these images', 'responsive-lightbox' ),
					'editTitle'			=> __( 'Edit attachment', 'responsive-lightbox' ),
					'buttonEditFile'	=> __( 'Save attachment', 'responsive-lightbox' ),
					'nonce'				=> wp_create_nonce( 'rl-gallery' ),
					'post_id'			=> get_the_ID()
				)
			);

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style( 'responsive-lightbox-admin-galleries-select2', RESPONSIVE_LIGHTBOX_URL . '/assets/select2/css/select2' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', array(), $this->defaults['version'] );

			wp_enqueue_style( 'responsive-lightbox-admin-galleries', RESPONSIVE_LIGHTBOX_URL . '/css/admin-galleries.css', array(), $this->defaults['version'] );
		}
	}

	/**
	 * Enqueue admin widget scripts.
	 */
	public function sidebar_admin_setup() {
		wp_enqueue_media();

		wp_enqueue_script( 'responsive-lightbox-admin-widgets', plugins_url( 'js/admin-widgets.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'] );

		wp_localize_script(
			'responsive-lightbox-admin-widgets',
			'rlArgs',
			array(
				'textRemoveImage'		=> __( 'Remove image', 'responsive-lightbox' ),
				'textSelectImages'		=> __( 'Select images', 'responsive-lightbox' ),
				'textSelectImage'		=> __( 'Select image', 'responsive-lightbox' ),
				'textUseImages'			=> __( 'Use these images', 'responsive-lightbox' ),
				'textUseImage'			=> __( 'Use this image', 'responsive-lightbox' )
			)
		);

		wp_register_style(
			'responsive-lightbox-admin', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->defaults['version']
		);
		wp_enqueue_style( 'responsive-lightbox-admin' );
	}

	/**
	 * Enqueue frontend scripts and styles.
	 */
	public function front_scripts_styles() {
		$args = apply_filters( 'rl_lightbox_args', array(
			'script'			 => $this->options['settings']['script'],
			'selector'			 => $this->options['settings']['selector'],
			'customEvents'		 => ( $this->options['settings']['enable_custom_events'] === true ? ' ' . $this->options['settings']['custom_events'] : '' ),
			'activeGalleries'	 => $this->get_boolean_value( $this->options['settings']['galleries'] )
		) );

		$scripts = array();
		$styles = array();

		switch ( $args['script'] ) {
			case 'prettyphoto':
				wp_register_script(
					'responsive-lightbox-prettyphoto', plugins_url( 'assets/prettyphoto/js/jquery.prettyPhoto' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
				);

				wp_register_style(
					'responsive-lightbox-prettyphoto', plugins_url( 'assets/prettyphoto/css/prettyPhoto' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version']
				);

				$scripts[] = 'responsive-lightbox-prettyphoto';
				$styles[] = 'responsive-lightbox-prettyphoto';

				$args = array_merge(
					$args, array(
					'animationSpeed'	 => $this->options['configuration']['prettyphoto']['animation_speed'],
					'slideshow'			 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['slideshow'] ),
					'slideshowDelay'	 => $this->options['configuration']['prettyphoto']['slideshow_delay'],
					'slideshowAutoplay'	 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['slideshow_autoplay'] ),
					'opacity'			 => sprintf( '%.2f', ($this->options['configuration']['prettyphoto']['opacity'] / 100 ) ),
					'showTitle'			 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['show_title'] ),
					'allowResize'		 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['allow_resize'] ),
					'allowExpand'		 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['allow_expand'] ),
					'width'				 => $this->options['configuration']['prettyphoto']['width'],
					'height'			 => $this->options['configuration']['prettyphoto']['height'],
					'separator'			 => $this->options['configuration']['prettyphoto']['separator'],
					'theme'				 => $this->options['configuration']['prettyphoto']['theme'],
					'horizontalPadding'	 => $this->options['configuration']['prettyphoto']['horizontal_padding'],
					'hideFlash'			 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['hide_flash'] ),
					'wmode'				 => $this->options['configuration']['prettyphoto']['wmode'],
					'videoAutoplay'		 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['video_autoplay'] ),
					'modal'				 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['modal'] ),
					'deeplinking'		 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['deeplinking'] ),
					'overlayGallery'	 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['overlay_gallery'] ),
					'keyboardShortcuts'	 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['keyboard_shortcuts'] ),
					'social'			 => $this->get_boolean_value( $this->options['configuration']['prettyphoto']['social'] )
					)
				);
				break;

			case 'swipebox':
				wp_register_script(
					'responsive-lightbox-swipebox', plugins_url( 'assets/swipebox/js/jquery.swipebox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
				);

				wp_register_style(
					'responsive-lightbox-swipebox', plugins_url( 'assets/swipebox/css/swipebox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version']
				);

				$scripts[] = 'responsive-lightbox-swipebox';
				$styles[] = 'responsive-lightbox-swipebox';

				$args = array_merge(
					$args, array(
					'animation'					=> $this->get_boolean_value( ($this->options['configuration']['swipebox']['animation'] === 'css' ? true : false ) ),
					'hideCloseButtonOnMobile'	=> $this->get_boolean_value( $this->options['configuration']['swipebox']['hide_close_mobile'] ),
					'removeBarsOnMobile'		=> $this->get_boolean_value( $this->options['configuration']['swipebox']['remove_bars_mobile'] ),
					'hideBars'					=> $this->get_boolean_value( $this->options['configuration']['swipebox']['hide_bars'] ),
					'hideBarsDelay'				=> $this->options['configuration']['swipebox']['hide_bars_delay'],
					'videoMaxWidth'				=> $this->options['configuration']['swipebox']['video_max_width'],
					'useSVG'					=> ! $this->options['configuration']['swipebox']['force_png_icons'],
					'loopAtEnd'					=> $this->get_boolean_value( $this->options['configuration']['swipebox']['loop_at_end'] )
					)
				);
				break;

			case 'fancybox':
				wp_register_script(
					'responsive-lightbox-fancybox', plugins_url( 'assets/fancybox/jquery.fancybox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
				);

				wp_register_style(
					'responsive-lightbox-fancybox', plugins_url( 'assets/fancybox/jquery.fancybox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version']
				);

				$scripts[] = 'responsive-lightbox-fancybox';
				$styles[] = 'responsive-lightbox-fancybox';

				$args = array_merge(
					$args, array(
					'modal'				 => $this->get_boolean_value( $this->options['configuration']['fancybox']['modal'] ),
					'showOverlay'		 => $this->get_boolean_value( $this->options['configuration']['fancybox']['show_overlay'] ),
					'showCloseButton'	 => $this->get_boolean_value( $this->options['configuration']['fancybox']['show_close_button'] ),
					'enableEscapeButton' => $this->get_boolean_value( $this->options['configuration']['fancybox']['enable_escape_button'] ),
					'hideOnOverlayClick' => $this->get_boolean_value( $this->options['configuration']['fancybox']['hide_on_overlay_click'] ),
					'hideOnContentClick' => $this->get_boolean_value( $this->options['configuration']['fancybox']['hide_on_content_click'] ),
					'cyclic'			 => $this->get_boolean_value( $this->options['configuration']['fancybox']['cyclic'] ),
					'showNavArrows'		 => $this->get_boolean_value( $this->options['configuration']['fancybox']['show_nav_arrows'] ),
					'autoScale'			 => $this->get_boolean_value( $this->options['configuration']['fancybox']['auto_scale'] ),
					'scrolling'			 => $this->options['configuration']['fancybox']['scrolling'],
					'centerOnScroll'	 => $this->get_boolean_value( $this->options['configuration']['fancybox']['center_on_scroll'] ),
					'opacity'			 => $this->get_boolean_value( $this->options['configuration']['fancybox']['opacity'] ),
					'overlayOpacity'	 => $this->options['configuration']['fancybox']['overlay_opacity'],
					'overlayColor'		 => $this->options['configuration']['fancybox']['overlay_color'],
					'titleShow'			 => $this->get_boolean_value( $this->options['configuration']['fancybox']['title_show'] ),
					'titlePosition'		 => $this->options['configuration']['fancybox']['title_position'],
					'transitions'		 => $this->options['configuration']['fancybox']['transitions'],
					'easings'			 => $this->options['configuration']['fancybox']['easings'],
					'speeds'			 => $this->options['configuration']['fancybox']['speeds'],
					'changeSpeed'		 => $this->options['configuration']['fancybox']['change_speed'],
					'changeFade'		 => $this->options['configuration']['fancybox']['change_fade'],
					'padding'			 => $this->options['configuration']['fancybox']['padding'],
					'margin'			 => $this->options['configuration']['fancybox']['margin'],
					'videoWidth'		 => $this->options['configuration']['fancybox']['video_width'],
					'videoHeight'		 => $this->options['configuration']['fancybox']['video_height']
					)
				);
				break;

			case 'nivo':
				wp_register_script(
					'responsive-lightbox-nivo', plugins_url( 'assets/nivo/nivo-lightbox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true ), $this->defaults['version']
				);

				wp_register_style(
					'responsive-lightbox-nivo', plugins_url( 'assets/nivo/nivo-lightbox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version']
				);

				wp_register_style(
					'responsive-lightbox-nivo-default', plugins_url( 'assets/nivo/themes/default/default.css', __FILE__ ), array(), $this->defaults['version']
				);
				
				$scripts[] = 'responsive-lightbox-nivo';
				$styles[] = 'responsive-lightbox-nivo';
				$styles[] = 'responsive-lightbox-nivo-default';
	
				$args = array_merge(
					$args, array(
					'effect'				 => $this->options['configuration']['nivo']['effect'],
					'clickOverlayToClose'	 => $this->get_boolean_value( $this->options['configuration']['nivo']['click_overlay_to_close'] ),
					'keyboardNav'			 => $this->get_boolean_value( $this->options['configuration']['nivo']['keyboard_nav'] ),
					'errorMessage'			 => esc_attr( $this->options['configuration']['nivo']['error_message'] )
					)
				);
				break;

			case 'imagelightbox':
				wp_register_script(
					'responsive-lightbox-imagelightbox', plugins_url( 'assets/imagelightbox/js/imagelightbox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
				);

				wp_register_style(
					'responsive-lightbox-imagelightbox', plugins_url( 'assets/imagelightbox/css/imagelightbox' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version']
				);

				$scripts[] = 'responsive-lightbox-imagelightbox';
				$styles[] = 'responsive-lightbox-imagelightbox';

				$args = array_merge(
					$args, array(
					'animationSpeed'		 => $this->options['configuration']['imagelightbox']['animation_speed'],
					'preloadNext'			 => $this->get_boolean_value( $this->options['configuration']['imagelightbox']['preload_next'] ),
					'enableKeyboard'		 => $this->get_boolean_value( $this->options['configuration']['imagelightbox']['enable_keyboard'] ),
					'quitOnEnd'				 => $this->get_boolean_value( $this->options['configuration']['imagelightbox']['quit_on_end'] ),
					'quitOnImageClick'		 => $this->get_boolean_value( $this->options['configuration']['imagelightbox']['quit_on_image_click'] ),
					'quitOnDocumentClick'	 => $this->get_boolean_value( $this->options['configuration']['imagelightbox']['quit_on_document_click'] ),
					)
				);
				break;

			case 'tosrus':
				// swipe support, enqueue Hammer.js on mobile devices only
				if ( wp_is_mobile() ) {
					wp_register_script(
						'responsive-lightbox-hammer-js', plugins_url( 'assets/tosrus/js/hammer' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array(), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
					);
					$scripts[] = 'responsive-lightbox-hammer-js';
				}

				wp_register_script(
					'responsive-lightbox-tosrus', plugins_url( 'assets/tosrus/js/jquery.tosrus' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.all.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
				);

				wp_register_style(
					'responsive-lightbox-tosrus', plugins_url( 'assets/tosrus/css/jquery.tosrus' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.all.css', __FILE__ ), array(), $this->defaults['version']
				);

				$scripts[] = 'responsive-lightbox-tosrus';
				$styles[] = 'responsive-lightbox-tosrus';

				$args = array_merge( $args, array(
					'effect'					=> $this->options['configuration']['tosrus']['effect'],
					'infinite'	 				=> $this->get_boolean_value( $this->options['configuration']['tosrus']['infinite'] ),
					'keys'	 					=> $this->get_boolean_value( $this->options['configuration']['tosrus']['keys'] ),
					'autoplay'	 				=> $this->get_boolean_value( $this->options['configuration']['tosrus']['autoplay'] ),
					'pauseOnHover'	 			=> $this->get_boolean_value( $this->options['configuration']['tosrus']['pause_on_hover'] ),
					'timeout'	 				=> $this->options['configuration']['tosrus']['timeout'],
					'pagination'	 			=> $this->get_boolean_value( $this->options['configuration']['tosrus']['pagination'] ),
					'paginationType'	 		=> $this->options['configuration']['tosrus']['pagination_type'],
					'closeOnClick'				=> $this->get_boolean_value( $this->options['configuration']['tosrus']['close_on_click'] )
					)
				);
				break;

			case 'featherlight':
				wp_register_script(
					'responsive-lightbox-featherlight', plugins_url( 'assets/featherlight/featherlight' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
				);

				wp_register_style(
					'responsive-lightbox-featherlight', plugins_url( 'assets/featherlight/featherlight' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version']
				);

				wp_register_script(
					'responsive-lightbox-featherlight-gallery', plugins_url( 'assets/featherlight/featherlight.gallery' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ($this->options['settings']['loading_place'] === 'header' ? false : true )
				);

				wp_register_style(
					'responsive-lightbox-featherlight-gallery', plugins_url( 'assets/featherlight/featherlight.gallery' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version']
				);

				$scripts[] = 'responsive-lightbox-featherlight';
				$styles[] = 'responsive-lightbox-featherlight';
				$scripts[] = 'responsive-lightbox-featherlight-gallery';
				$styles[] = 'responsive-lightbox-featherlight-gallery';

				$args = array_merge(
					$args, array(
					'openSpeed'				=> $this->options['configuration']['featherlight']['open_speed'],
					'closeSpeed'			=> $this->options['configuration']['featherlight']['close_speed'],
					'closeOnClick'			=> $this->options['configuration']['featherlight']['close_on_click'],
					'closeOnEsc'			=> $this->get_boolean_value( $this->options['configuration']['featherlight']['close_on_esc'] ),
					'galleryFadeIn'			=> $this->options['configuration']['featherlight']['gallery_fade_in'],
					'galleryFadeOut'		=> $this->options['configuration']['featherlight']['gallery_fade_out']
					)
				);
				break;

			case 'magnific':
				wp_register_script( 'responsive-lightbox-magnific', plugins_url( 'assets/magnific/jquery.magnific-popup' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], ( $this->options['settings']['loading_place'] === 'header' ? false : true ) );

				wp_register_style( 'responsive-lightbox-magnific', plugins_url( 'assets/magnific/magnific-popup' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', __FILE__ ), array(), $this->defaults['version'] );

				$scripts[] = 'responsive-lightbox-magnific';
				$styles[] = 'responsive-lightbox-magnific';

				$args = array_merge(
					$args,
					array(
						'disableOn'				=> $this->options['configuration']['magnific']['disable_on'],
						'midClick'				=> $this->options['configuration']['magnific']['mid_click'],
						'preloader'				=> $this->options['configuration']['magnific']['preloader'],
						'closeOnContentClick'	=> $this->options['configuration']['magnific']['close_on_content_click'],
						'closeOnBgClick'		=> $this->options['configuration']['magnific']['close_on_background_click'],
						'closeBtnInside'		=> $this->options['configuration']['magnific']['close_button_inside'],
						'showCloseBtn'			=> $this->options['configuration']['magnific']['show_close_button'],
						'enableEscapeKey'		=> $this->options['configuration']['magnific']['enable_escape_key'],
						'alignTop'				=> $this->options['configuration']['magnific']['align_top'],
						'fixedContentPos'		=> $this->options['configuration']['magnific']['fixed_content_position'],
						'fixedBgPos'			=> $this->options['configuration']['magnific']['fixed_background_position'],
						'autoFocusLast'			=> $this->options['configuration']['magnific']['auto_focus_last']
					)
				);
				break;

			default:
				do_action( 'rl_lightbox_enqueue_scripts' );

				$scripts = apply_filters( 'rl_lightbox_scripts', $scripts );
				$styles = apply_filters( 'rl_lightbox_styles', $styles );
		}

		// run scripts by default
		$contitional_scripts = true;

		if ( $this->options['settings']['conditional_loading'] === true ) {
			global $post;

			if ( is_object( $post ) ) {
				// is gallery present in content
				$has_gallery = has_shortcode( $post->post_content, 'gallery' ) || has_shortcode( $post->post_content, 'rl_gallery' );

				// are images present in content
				preg_match_all( '/<a(.*?)href=(?:\'|")([^<]*?).(bmp|gif|jpeg|jpg|png|webp)(?:\'|")(.*?)>/i', $post->post_content, $links );

				$has_images = (bool) $links[0];

				if ( $has_gallery === false && $has_images === false )
					$contitional_scripts = false;
			}
		}

		if ( ! empty( $args['script'] ) && ! empty( $args['selector'] ) && apply_filters( 'rl_lightbox_conditional_loading', $contitional_scripts ) != false ) {
			wp_register_script( 'responsive-lightbox-infinite-scroll', RESPONSIVE_LIGHTBOX_URL . '/assets/infinitescroll/infinite-scroll.pkgd' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', array( 'jquery' ) );
			wp_register_script( 'responsive-lightbox-images-loaded', RESPONSIVE_LIGHTBOX_URL . '/assets/imagesloaded/imagesloaded.pkgd' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', array( 'jquery' ) );
			wp_register_script( 'responsive-lightbox-masonry', RESPONSIVE_LIGHTBOX_URL . '/assets/masonry/masonry.pkgd' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', array( 'jquery' ), Responsive_Lightbox()->defaults['version'], ( Responsive_Lightbox()->options['settings']['loading_place'] === 'footer' ) );

			wp_register_script( 'responsive-lightbox', plugins_url( 'js/front.js', __FILE__ ), array( 'jquery', 'responsive-lightbox-infinite-scroll' ), $this->defaults['version'], ( $this->options['settings']['loading_place'] === 'header' ? false : true ) );

			$args['woocommerce_gallery'] = 0;

			if ( class_exists( 'WooCommerce' ) ) {
				global $woocommerce;

				if ( ! empty( Responsive_Lightbox()->options['settings']['default_woocommerce_gallery'] ) && Responsive_Lightbox()->options['settings']['default_woocommerce_gallery'] !== 'default' ) {
					if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] === true ) {
						if ( version_compare( $woocommerce->version, '3.0', ">=" ) )
							$args['woocommerce_gallery'] = 1;
					}
				// default gallery?
				} else {
					// replace default WooCommerce lightbox?
					if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] === true ) {
						if ( version_compare( $woocommerce->version, '3.0', ">=" ) )
							$args['woocommerce_gallery'] = 1;
					}
				}
			}

			$scripts[] = 'responsive-lightbox';

			$args['ajaxurl'] = admin_url( 'admin-ajax.php' );
			$args['nonce'] = wp_create_nonce( 'rl_nonce' );

			// enqueue scripts
			if ( $scripts && is_array( $scripts ) ) {
				foreach ( $scripts as $script ) {
					wp_enqueue_script( $script );
				}
				
				wp_localize_script(	'responsive-lightbox', 'rlArgs', $args );
			}

			// enqueue styles
			if ( $styles && is_array( $styles ) ) {
				foreach ( $styles as $style ) {
					wp_enqueue_style( $style );
				}
			}
		}
		
		// gallery style
		wp_register_style( 'responsive-lightbox-gallery',  plugins_url( 'css/gallery.css', __FILE__ ), array(), Responsive_Lightbox()->defaults['version'] );
	}

	/**
	 * Helper: convert value to boolean
	 * 
	 * @param int $option
	 * @return bool
	 */
	private function get_boolean_value( $option ) {
		return ( $option == true ? 1 : 0 );
	}
	
	/**
	 * Helper: convert hex color to rgb color.
	 * 
	 * @param type $color
	 * @return array
	 */
	public function hex2rgb( $color ) {
		if ( $color[0] == '#' )
			$color = substr( $color, 1 );

		if ( strlen( $color ) == 6 )
			list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		elseif ( strlen( $color ) == 3 )
			list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		else
			return false;

		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );

		return array( $r, $g, $b );
	}
}

/**
 * Initialize Responsive Lightbox.
 */
function Responsive_Lightbox() {
	static $instance;

	// first call to instance() initializes the plugin
	if ( $instance === null || ! ($instance instanceof Responsive_Lightbox) ) {
		$instance = Responsive_Lightbox::instance();
	}

	return $instance;
}

$responsive_lightbox = Responsive_Lightbox();