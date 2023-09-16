<?php
if ( ! defined( 'ABSPATH' ) ) exit;
final class ACFCG_Core {
	public static $class_prefix = 'ACFCG_';
	public static $db_table = '';
	public static $indent_repeater = 2;
	public static $indent_flexible_content = 3;

	public static $ignored_field_types = array(
		'tab',
		'message',
		'accordion',
		'enhanced_message',
		'row'
	);
	public static $field_types_basic = array(
		'text',
		'textarea',
		'number',
		'range',
		'email',
		'url',
		'wysiwyg',
		'oembed',
		'date_picker',
		'date_time_picker',
		'time_picker',
		'color_picker',
	);
	private static $field_types_basic_pro = array(
		'extended-color-picker',
		'star_rating_field',
		'qtranslate_text',
		'qtranslate_textarea',
		'qtranslate_wysiwyg',
	);

	public static $field_types_all_tc_pro = array(
		
		'repeater',
		'flexible_content',
		'gallery',
		'clone',

		
		'font-awesome',
		'google_font_selector',
		'image_crop',
		'markdown',
		'rgba_color',
		'sidebar_selector',
		'smart_button',
		'table',
		'tablepress_field',
		'address',
		'number_slider',
		'posttype_select',
		'acf_code_field',
		'link_picker',
		'youtubepicker',
		'focal_point',
		'color_palette', 
		'forms', 
		'icon-picker', 
		'svg_icon',
		'swatch', 
		'image_aspect_ratio_crop',
		'qtranslate_file', 
		'qtranslate_image', 
		'nav_menu',

		
		'extended-color-picker', 
		'star_rating_field', 
		'qtranslate_text',
		'qtranslate_textarea',
		'qtranslate_wysiwyg',
	);

	/**
	 * ACFCG_Core constructor
	 */
	public function __construct() {

		$this->set_class_prefix();
		$this->set_basic_field_types();
		$this->add_core_actions();

	}

    /**
	 * Set class prefix
	 */
	private function set_class_prefix() {

		

	}

    /**
	 * Set extra basic field types
	 */
	private function set_basic_field_types() {

		

	}

	/**
	 * Add plugin actions
	 **/
	private function add_core_actions() {
		add_action( 'admin_init', array($this, 'set_db_table') );
		add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );		
	}

	/**
	 * Set the DB Table (as this changes between version 4 and 5)
	 * So we need to check if we're using version 4 or version 5 of ACF
	 * This includes ACF 5 in a theme or ACF 4 or 5 installed via a plugin
	 */
	public function set_db_table() {

		
		if ( ! class_exists( 'acf' )  ) {

			
			return;

		 }

		
		if ( function_exists( 'acf_get_setting' ) ) {

			
			
			$version = acf_get_setting( 'version' );

		} else {
			$version = apply_filters( 'acf/get_info', 'version' );
		}

		
		$major_version = substr( $version, 0 , 1 );

		
		if( $major_version == '5' ) {

			
			self::$db_table = 'posts';

		
		} elseif( $major_version == '4' ) {

			
			self::$db_table = 'postmeta';

		}

	}


	/**
	 * Register meta box
	 */
	public function register_meta_boxes() {

		add_meta_box(
			'acftc-meta-box',
			__( 'Theme Code', 'acftc-textdomain' ), 
			array( $this, 'display_callback'),
			array( 'acf', 'acf-field-group' )
		);

	}


	/**
	 * Meta box display callback
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function display_callback( $field_group_post_obj ) {

		$locations_class_name = self::$class_prefix . 'Locations';
		$locations_ui = new $locations_class_name( $field_group_post_obj );

        echo $locations_ui->get_locations_html();
	}
	public function enqueue( $hook ) {
		global $post_type;
		$page = $GLOBALS['plugin_page'];
		if( 'acf-field-group' == $post_type || 'acf' == $post_type || 'acf-tools' == $page ) {
			wp_enqueue_style( 'ACFCG_css', ACFCG_PLUGIN_DIR_URL . 'assets/acfcg_style.css', '' , ACFCG_PLUGIN_VERSION);
			wp_enqueue_style( 'ACFCG_prism_css', ACFCG_PLUGIN_DIR_URL . 'assets/prism.css', '' , ACFCG_PLUGIN_VERSION);
			wp_enqueue_script( 'ACFCG_prism_js', ACFCG_PLUGIN_DIR_URL . 'assets/prism.js', '' , ACFCG_PLUGIN_VERSION);
			wp_enqueue_script( 'ACFCG_clipboard_js', ACFCG_PLUGIN_DIR_URL . 'assets/acfcg_clipboard.min.js', '' , ACFCG_PLUGIN_VERSION);
			wp_enqueue_script( 'ACFCG_js', ACFCG_PLUGIN_DIR_URL . 'assets/acfcg_script.js', array( 'ACFCG_clipboard_js' ), '', ACFCG_PLUGIN_VERSION, true );
		}
	}
}
