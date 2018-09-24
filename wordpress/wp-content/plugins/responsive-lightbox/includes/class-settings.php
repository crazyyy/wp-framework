<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

new Responsive_Lightbox_Settings();

/**
 * Responsive Lightbox settings class.
 *
 * @class Responsive_Lightbox_Settings
 */
class Responsive_Lightbox_Settings {

	public $settings 		= array();
	public $tabs 			= array();
	public $scripts 		= array();
	private $choices 		= array();
	private $loading_places	= array();
	private $api_url		= 'http://dfactory.eu';

	public function __construct() {
		
		// set instance
		Responsive_Lightbox()->settings = $this;

		// actions
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu_options' ) );
		add_action( 'after_setup_theme', array( $this, 'load_defaults' ) );
		add_action( 'init', array( $this, 'init_builder' ) );
	}

	/**
	 * Initialize additional stuff for builder.
	 * 
	 * @return void
	 */
	public function init_builder() {
		// add categories
		if ( Responsive_Lightbox()->options['builder']['gallery_builder'] && Responsive_Lightbox()->options['builder']['categories'] && Responsive_Lightbox()->options['builder']['archives'] ) {
			$terms = get_terms( array( 'taxonomy' => 'rl_category', 'hide_empty' => false ) );

			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$this->settings['builder']['fields']['archives_category']['options'][$term->slug] = $term->name;
				}
			}
		}

		// flush rewrite rules if needed
		if ( isset( $_GET['flush_rules'] ) )
			flush_rewrite_rules();
	}

	/**
	 * Load default settings.
	 * 
	 * @return void
	 */
	public function load_defaults() {
		$this->scripts = apply_filters( 'rl_settings_scripts', array(
			'swipebox'		 => array(
				'name'		 => __( 'SwipeBox', 'responsive-lightbox' ),
				'animations' => array(
					'css'	 => __( 'CSS', 'responsive-lightbox' ),
					'jquery' => __( 'jQuery', 'responsive-lightbox' )
				),
				'supports'	=> array( 'title' )
			),
			'prettyphoto'	 => array(
				'name'				 => __( 'prettyPhoto', 'responsive-lightbox' ),
				'animation_speeds'	 => array(
					'slow'	 => __( 'slow', 'responsive-lightbox' ),
					'normal' => __( 'normal', 'responsive-lightbox' ),
					'fast'	 => __( 'fast', 'responsive-lightbox' )
				),
				'themes'			 => array(
					'pp_default'	 => __( 'default', 'responsive-lightbox' ),
					'light_rounded'	 => __( 'light rounded', 'responsive-lightbox' ),
					'dark_rounded'	 => __( 'dark rounded', 'responsive-lightbox' ),
					'light_square'	 => __( 'light square', 'responsive-lightbox' ),
					'dark_square'	 => __( 'dark square', 'responsive-lightbox' ),
					'facebook'		 => __( 'facebook', 'responsive-lightbox' )
				),
				'wmodes'			 => array(
					'window'		 => __( 'window', 'responsive-lightbox' ),
					'transparent'	 => __( 'transparent', 'responsive-lightbox' ),
					'opaque'		 => __( 'opaque', 'responsive-lightbox' ),
					'direct'		 => __( 'direct', 'responsive-lightbox' ),
					'gpu'			 => __( 'gpu', 'responsive-lightbox' )
				),
				'supports'	=> array( 'inline', 'iframe', 'ajax', 'title', 'caption' )
			),
			'fancybox'		 => array(
				'name'			 => __( 'FancyBox', 'responsive-lightbox' ),
				'transitions'	 => array(
					'elastic'	 => __( 'elastic', 'responsive-lightbox' ),
					'fade'		 => __( 'fade', 'responsive-lightbox' ),
					'none'		 => __( 'none', 'responsive-lightbox' )
				),
				'scrollings'	 => array(
					'auto'	 => __( 'auto', 'responsive-lightbox' ),
					'yes'	 => __( 'yes', 'responsive-lightbox' ),
					'no'	 => __( 'no', 'responsive-lightbox' )
				),
				'easings'		 => array(
					'swing'	 => __( 'swing', 'responsive-lightbox' ),
					'linear' => __( 'linear', 'responsive-lightbox' )
				),
				'positions'		 => array(
					'outside'	 => __( 'outside', 'responsive-lightbox' ),
					'inside'	 => __( 'inside', 'responsive-lightbox' ),
					'over'		 => __( 'over', 'responsive-lightbox' )
				),
				'supports'	=> array( 'inline', 'iframe', 'ajax', 'title' )
			),
			'nivo'			=> array(
				'name'		=> __( 'Nivo Lightbox', 'responsive-lightbox' ),
				'effects'	=> array(
					'fade'		 => __( 'fade', 'responsive-lightbox' ),
					'fadeScale'	 => __( 'fade scale', 'responsive-lightbox' ),
					'slideLeft'	 => __( 'slide left', 'responsive-lightbox' ),
					'slideRight' => __( 'slide right', 'responsive-lightbox' ),
					'slideUp'	 => __( 'slide up', 'responsive-lightbox' ),
					'slideDown'	 => __( 'slide down', 'responsive-lightbox' ),
					'fall'		 => __( 'fall', 'responsive-lightbox' )
				),
				'supports'	=> array( 'inline', 'iframe', 'ajax', 'title' )
			),
			'imagelightbox'	=> array(
				'name'		=> __( 'Image Lightbox', 'responsive-lightbox' ),
				'supports'	=> array()
			),
			'tosrus'		=> array(
				'name'		=> __( 'TosRUs', 'responsive-lightbox' ),
				'supports'	=> array( 'inline', 'title' )
			),
			'featherlight'	=> array(
				'name'		=> __( 'Featherlight', 'responsive-lightbox' ),
				'supports'	=> array( 'inline', 'iframe', 'ajax' )
			),
			'magnific'	 	=> array(
				'name'		=> __( 'Magnific Popup', 'responsive-lightbox' ),
				'supports'	=> array( 'inline', 'iframe', 'ajax', 'title', 'caption' )
			)
		) );

		$this->image_titles = array(
			'default'		=> __( 'None', 'responsive-lightbox' ),
			'title'	 		=> __( 'Image Title', 'responsive-lightbox' ),
			'caption'		=> __( 'Image Caption', 'responsive-lightbox' ),
			'alt'	 		=> __( 'Image Alt Text', 'responsive-lightbox' ),
			'description'	=> __( 'Image Description', 'responsive-lightbox' )
		);
		
		$this->image_icons = array(
			'0' => __( 'none', 'responsive-lightbox' ),
			'1' => '',
			'2' => '',
			'3' => '',
			'4' => '',
			'5' => '',
			'6' => '',
			'7' => '',
			'8' => '',
			'9' => '',
			'10' => ''
		);

		$this->loading_places = array(
			'header' => __( 'Header', 'responsive-lightbox' ),
			'footer' => __( 'Footer', 'responsive-lightbox' )
		);
		
		// get scripts
		foreach ( $this->scripts as $key => $value ) {
			$scripts[$key] = $value['name'];
		}

		// get image sizes
		$sizes = apply_filters( 'image_size_names_choose', array(
			'thumbnail' => __( 'Thumbnail', 'responsive-lightbox' ),
			'medium'    => __( 'Medium', 'responsive-lightbox' ),
			'large'     => __( 'Large', 'responsive-lightbox' ),
			'full'      => __( 'Full Size', 'responsive-lightbox' ),
		) );

		// prepare galeries
		$galleries = $builder_galleries = wp_parse_args( apply_filters( 'rl_gallery_types', array() ), Responsive_Lightbox()->gallery_types );

		unset( $builder_galleries['default'] );

		$this->settings = array(
			'settings' => array(
				'option_group'	=> 'responsive_lightbox_settings',
				'option_name'	=> 'responsive_lightbox_settings',
				'sections'		=> array(
					'responsive_lightbox_settings' => array(
						'title' 		=> __( 'General settings', 'responsive-lightbox' )
					)
				),
				'prefix'		=> 'rl',
				'fields' => array(
					'tour' => array(
						'title' => __( 'Introduction Tour', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'button',
						'label' => __( 'Start Tour', 'responsive-lightbox' ),
						'description' => __( 'Take this tour to quickly learn about the use of this plugin.', 'responsive-lightbox' )
					),
					'script' => array(
						// 'name' => '',
						'title' => __( 'Default lightbox', 'responsive-lightbox' ),
						// 'callback' => '',
						// 'page' => '',
						'section' => 'responsive_lightbox_settings',
						'type' => 'radio',
						'label' => '',
						'description' => sprintf(__( 'Select your preferred ligthbox effect script or get our <a href="%s">premium extensions</a>.', 'responsive-lightbox' ), wp_nonce_url( add_query_arg( array( 'action' => 'rl-hide-notice' ), admin_url( 'admin.php?page=responsive-lightbox-addons' ) ), 'rl_action', 'rl_nonce' ) ),
						'options' => $scripts
						// 'options_cb' => '',
						// 'id' => '',
						// 'class' => array(),
					),
					'selector' => array(
						'title' => __( 'Selector', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'text',
						'description' => __( 'Enter the rel selector lightbox effect will be applied to.', 'responsive-lightbox' )
					),
					'image_links' => array(
						'title' => __( 'Images', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Enable lightbox for WordPress image links.', 'responsive-lightbox' )
					),
					'image_title' => array(
						'title' => __( 'Single image title', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'select',
						'description' => __( 'Select title for single images.', 'responsive-lightbox' ),
						'options' => $this->image_titles
					),
					'image_caption' => array(
						'title' => __( 'Single image caption', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'select',
						'description' => __( 'Select caption for single images (if supported by selected lightbox and/or gallery).', 'responsive-lightbox' ),
						'options' => $this->image_titles
					),
					'images_as_gallery' => array(
						'title' => __( 'Single images as gallery', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Display single post images as a gallery.', 'responsive-lightbox' )
					),
					'galleries' => array(
						'title' => __( 'Galleries', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Enable lightbox for WordPress image galleries.', 'responsive-lightbox' )
					),
					'default_gallery' => array(
						'title' => __( 'WordPress gallery', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'radio',
						'description' => __( 'Select your preferred default WordPress gallery style.', 'responsive-lightbox' ),
						'options' => $galleries
					),
					'builder_gallery' => array(
						'title' => __( 'Builder gallery', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'radio',
						'description' => __( 'Select your preferred default builder gallery style.', 'responsive-lightbox' ),
						'options' => $builder_galleries
					),
					'default_woocommerce_gallery' => array(
						'title' => __( 'WooCommerce gallery', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'radio',
						'disabled' => ! class_exists( 'WooCommerce' ),
						'description' => __( 'Select your preferred gallery style for WooCommerce product gallery.', 'responsive-lightbox' ),
						'options' => $galleries
					),
					'gallery_image_size' => array(
						'title' => __( 'Gallery image size', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'select',
						'description' => __( 'Select image size for gallery image links.', 'responsive-lightbox' ),
						'options' => $sizes
					),
					'gallery_image_title' => array(
						'title' => __( 'Gallery image title', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'select',
						'description' => __( 'Select title for the gallery images.', 'responsive-lightbox' ),
						'options' => $this->image_titles
					),
					'gallery_image_caption' => array(
						'title' => __( 'Gallery image caption', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'select',
						'description' => __( 'Select caption for the gallery images (if supported by selected lightbox and/or gallery).', 'responsive-lightbox' ),
						'options' => $this->image_titles
					),
					'videos' => array(
						'title' => __( 'Videos', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Enable lightbox for YouTube and Vimeo video links.', 'responsive-lightbox' )
					),
					'widgets' => array(
						'title' => __( 'Widgets', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Enable lightbox for widgets content.', 'responsive-lightbox' )
					),
					'comments' => array(
						'title' => __( 'Comments', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Enable lightbox for comments content.', 'responsive-lightbox' )
					),
					'force_custom_gallery' => array(
						'title' => __( 'Force lightbox', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Try to force lightbox for custom WP gallery replacements, like Jetpack or Visual Composer galleries.', 'responsive-lightbox' )
					),
					'woocommerce_gallery_lightbox' => array(
						'title' => __( 'WooCommerce lightbox', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Replace WooCommerce product gallery lightbox.', 'responsive-lightbox' ),
						'disabled' => ! class_exists( 'WooCommerce' )
					),
					'enable_custom_events' => array(
						'title' => __( 'Custom events', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'multiple',
						'fields' => array(
							'enable_custom_events' => array(
								'type' => 'boolean',
								'label' => __( 'Enable triggering lightbox on custom jQuery events.', 'responsive-lightbox' )
							),
							'custom_events' => array(
								'type' => 'text',
								'description' => __( 'Enter a space separated list of events.', 'responsive-lightbox' )
							)
						)
					),
					'loading_place' => array(
						'title' => __( 'Loading place', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'radio',
						'description' => __( 'Select where all the lightbox scripts should be placed.', 'responsive-lightbox' ),
						'options' => $this->loading_places
					),
					'conditional_loading' => array(
						'title' => __( 'Conditional loading', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Enable to load scripts and styles only on pages that have images or galleries in post content.', 'responsive-lightbox' )
					),
					'deactivation_delete' => array(
						'title' => __( 'Delete data', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_settings',
						'type' => 'boolean',
						'label' => __( 'Delete all plugin settings on deactivation.', 'responsive-lightbox' )
					)
				)
			),
			'builder' => array(
				'option_group'	=> 'responsive_lightbox_builder',
				'option_name'	=> 'responsive_lightbox_builder',
				'sections'		=> array(
					'responsive_lightbox_builder' => array(
						'title' 		=> __( 'Gallery Builder Settings', 'responsive-lightbox' )
					)
				),
				'prefix'		=> 'rl',
				'fields' => array(
					'gallery_builder' => array(
						'title' => __( 'Gallery Builder', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'boolean',
						'label' => __( 'Enable advanced gallery builder.', 'responsive-lightbox' )
					),
					'categories' => array(
						'title' => __( 'Categories', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'boolean',
						'label' => __( 'Enable Gallery Categories.', 'responsive-lightbox' ),
						'description' => __( 'Enable if you want to use Gallery Categories.', 'responsive-lightbox' )
					),
					'tags' => array(
						'title' => __( 'Tags', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'boolean',
						'label' => __( 'Enable Gallery Tags.', 'responsive-lightbox' ),
						'description' => __( 'Enable if you want to use Gallery Tags.', 'responsive-lightbox' )
					),
					'permalink' => array(
						'title' => __( 'Gallery Permalink', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'text',
						'description' => '<code>' . site_url() . '/<strong>' . untrailingslashit( esc_html( Responsive_Lightbox()->options['builder']['permalink'] ) ) . '</strong>/</code><br />' . __( 'Enter gallery page slug.', 'responsive-lightbox' )
					),
					'permalink_categories' => array(
						'title' => __( 'Categories Permalink', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'text',
						'description' => '<code>' . site_url() . '/<strong>' . untrailingslashit( esc_html( Responsive_Lightbox()->options['builder']['permalink_categories'] ) ) . '</strong>/</code><br />' . __( 'Enter gallery categories archive page slug.', 'responsive-lightbox' )
					),
					'permalink_tags' => array(
						'title' => __( 'Tags Permalink', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'text',
						'description' => '<code>' . site_url() . '/<strong>' . untrailingslashit( esc_html( Responsive_Lightbox()->options['builder']['permalink_tags'] ) ) . '</strong>/</code><br />' . __( 'Enter gallery tags archive page slug.', 'responsive-lightbox' )
					),
					'archives' => array(
						'title' => __( 'Archives', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'boolean',
						'label' => __( 'Enable gallery archives.', 'responsive-lightbox' )
					),
					'archives_category' => array(
						'title' => __( 'Archives category', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_builder',
						'type' => 'select',
						'description' => __( 'Select category for gallery archives.', 'responsive-lightbox' ),
						'options' => array(
							'all' => __( 'All', 'responsive-lightbox' )
						)
					)
				)
			),
			'configuration' => array(
				'option_group'	=> 'responsive_lightbox_configuration',
				'option_name'	=> 'responsive_lightbox_configuration',
				'sections'		=> array(
					'responsive_lightbox_configuration' => array(
						'title' 		=> sprintf( __( '%s settings', 'responsive-lightbox' ), ( isset( $this->scripts[Responsive_Lightbox()->options['settings']['script']]['name'] ) ? $this->scripts[Responsive_Lightbox()->options['settings']['script']]['name'] : $this->scripts[Responsive_Lightbox()->defaults['settings']['script']]['name'] ) )
					),
				),
				'prefix'		=> 'rl',
				'fields' => array(
				)
			),
			'basicgrid_gallery' => array(
				'option_group' => 'responsive_lightbox_basicgrid_gallery',
				'option_name' => 'responsive_lightbox_basicgrid_gallery',
				'sections' => array(
					'responsive_lightbox_basicgrid_gallery' => array(
						'title' => __( 'Basic Grid Gallery settings', 'responsive-lightbox' )
					)
				),
				'prefix' => 'rl',
				'fields' => array(
					'screen_size_columns' => array(
						'title' => __( 'Screen sizes', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicgrid_gallery',
						'type' => 'multiple',
						'description' => __( 'Number of columns in a gallery depending on the device screen size. (if greater than 0 overrides the Columns option)', 'responsive-lightbox' ),
						'fields' => array(
							'columns_lg' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'append' => __( 'large devices / desktops (&ge;1200px)', 'responsive-lightbox' )
							),
							'columns_md' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'append' => __( 'medium devices / desktops (&ge;992px)', 'responsive-lightbox' )
							),
							'columns_sm' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'append' => __( 'small devices / tablets (&ge;768px)', 'responsive-lightbox' )
							),
							'columns_xs' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'append' => __( 'extra small devices / phones (<768px)', 'responsive-lightbox' )
							)
						),
					),
					'gutter' => array(
						'title' => __( 'Gutter', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicgrid_gallery',
						'type' => 'number',
						'min' => 0,
						'description' => __( 'Set the pixel width between the columns and rows.', 'responsive-lightbox' ),
						'append' => 'px'
					),
					'force_height' => array(
						'title' => __( 'Force height', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicgrid_gallery',
						'type' => 'boolean',
						'label' => __( 'Enable to force the thumbnail row height.', 'responsive-lightbox' )
					),
					'row_height' => array(
						'title' => __( 'Row height', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicgrid_gallery',
						'type' => 'number',
						'min' => 50,
						'description' => __( 'Enter the thumbnail row height in pixels (used if Force height is enabled). Defaults to 150px.', 'responsive-lightbox' ),
						'append' => 'px'
					)
				)
			),
			'basicslider_gallery' => array(
				'option_group' => 'responsive_lightbox_basicslider_gallery',
				'option_name' => 'responsive_lightbox_basicslider_gallery',
				'sections' => array(
					'responsive_lightbox_basicslider_gallery' => array(
						'title' => __( 'Basic Slider Gallery settings', 'responsive-lightbox' )
					)
				),
				'prefix' => 'rl',
				'fields' => array(
					'adaptive_height' => array(
						'title' => __( 'Adaptive Height', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'The slider height should change on the fly according to the current slide.', 'responsive-lightbox' )
					),
					'loop' => array(
						'title' => __( 'Loop', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should loop (i.e. the first slide goes to the last, the last slide goes to the first).', 'responsive-lightbox' )
					),
					'captions' => array(
						'title' => __( 'Captions Position', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'select',
						'description' => __( 'Specifies the position of captions or no captions at all.', 'responsive-lightbox' ),
						'options' => array(
							'none' => __( 'None', 'responsive-lightbox' ),
							'overlay' => __( 'Overlay', 'responsive-lightbox' ),
							'below' => __( 'Below', 'responsive-lightbox' )
						)
					),
					'init_single' => array(
						'title' => __( 'Single Image Slider', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should initialize even if there is only one slide element.', 'responsive-lightbox' )
					),
					'responsive' => array(
						'title' => __( 'Responsive', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should be responsive.', 'responsive-lightbox' )
					),
					'preload' => array(
						'title' => __( 'Preload', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'select',
						'description' => __( 'Elements that are preloaded before slider shows.', 'responsive-lightbox' ),
						'options' => array(
							'all' => __( 'All', 'responsive-lightbox' ),
							'visible' => __( 'Only visible', 'responsive-lightbox' )
						)
					),
					'pager' => array(
						'title' => __( 'Pager', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should have a pager.', 'responsive-lightbox' )
					),
					'controls' => array(
						'title' => __( 'Controls', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should have controls (next, previous arrows).', 'responsive-lightbox' )
					),
					'hide_on_end' => array(
						'title' => __( 'Hide Controls on End', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Hide the previous or next control when it reaches the first or last slide respectively.', 'responsive-lightbox' )
					),
					'slide_margin' => array(
						'title' => __( 'Slide Margin', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'number',
						'min' => 0,
						'description' => __( 'The spacing between slides.', 'responsive-lightbox' ),
						'append' => '%'
					),
					'transition' => array(
						'title' => __( 'Transition', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'select',
						'description' => __( 'Transition type to use, or no transitions.', 'responsive-lightbox' ),
						'options' => array(
							'none' => __( 'None', 'responsive-lightbox' ),
							'fade' => __( 'Fade', 'responsive-lightbox' ),
							'horizontal' => __( 'Horizontal', 'responsive-lightbox' ),
							'vertical' => __( 'Vertical', 'responsive-lightbox' ),
							'kenburns' => __( 'Ken Burns', 'responsive-lightbox' )
						)
					),
					'kenburns_zoom' => array(
						'title' => __( 'Ken Burns Zoom', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'number',
						'min' => 0,
						'description' => __( 'Max zoom level use for the Ken Burns transition.', 'responsive-lightbox' ),
						'append' => '%'
					),
					'speed' => array(
						'title' => __( 'Transition Speed', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'number',
						'min' => 0,
						'description' => __( 'The time the transition takes to complete.', 'responsive-lightbox' ),
						'append' => 'ms'
					),
					'easing' => array(
						'title' => __( 'Easing Effect', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'select',
						'description' => __( 'The easing effect to use for the selected transition.', 'responsive-lightbox' ),
						'options' => array(
							'linear' => 'linear',
							'swing' => 'swing',
							'easeInQuad' => 'easeInQuad',
							'easeOutQuad' => 'easeOutQuad',
							'easeInOutQuad' => 'easeInOutQuad',
							'easeInCubic' => 'easeInCubic',
							'easeOutCubic' => 'easeOutCubic',
							'easeInOutCubic' => 'easeInOutCubic',
							'easeInQuart' => 'easeInQuart',
							'easeOutQuart' => 'easeOutQuart',
							'easeInOutQuart' => 'easeInOutQuart',
							'easeInQuint' => 'easeInQuint',
							'easeOutQuint' => 'easeOutQuint',
							'easeInOutQuint' => 'easeInOutQuint',
							'easeInExpo' => 'easeInExpo',
							'easeOutExpo' => 'easeOutExpo',
							'easeInOutExpo' => 'easeInOutExpo',
							'easeInSine' => 'easeInSine',
							'easeOutSine' => 'easeOutSine',
							'easeInOutSine' => 'easeInOutSine',
							'easeInCirc' => 'easeInCirc',
							'easeOutCirc' => 'easeOutCirc',
							'easeInOutCirc' => 'easeInOutCirc',
							'easeInElastic' => 'easeInElastic',
							'easeOutElastic' => 'easeOutElastic',
							'easeInOutElastic' => 'easeInOutElastic',
							'easeInBack' => 'easeInBack',
							'easeOutBack' => 'easeOutBack',
							'easeInOutBack' => 'easeInOutBack',
							'easeInBounce' => 'easeInBounce',
							'easeOutBounce' => 'easeOutBounce',
							'easeInOutBounce' => 'easeInOutBounce'
						)
					),
					'continuous' => array(
						'title' => __( 'Continuous', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should run continuously (seamless transition between the first and last slides).', 'responsive-lightbox' )
					),
					'use_css' => array(
						'title' => __( 'Use CSS', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should use CSS transitions. If the user\'s browser doesn\'t support CSS transitions the slider will fallback to jQuery.', 'responsive-lightbox' )
					),
					'slideshow' => array(
						'title' => __( 'Slideshow', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slider should run automatically on load.', 'responsive-lightbox' )
					),
					'slideshow_direction' => array(
						'title' => __( 'Slideshow Direction', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'select',
						'description' => __( 'Which direction the slider should move in if in slideshow mode.', 'responsive-lightbox' ),
						'options' => array(
							'next' => __( 'Next', 'responsive-lightbox' ),
							'prev' => __( 'Previous', 'responsive-lightbox' )
						)
					),
					'slideshow_hover' => array(
						'title' => __( 'Slideshow Hover', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'boolean',
						'label' => __( 'Whether the slideshow should pause automatically on hover.', 'responsive-lightbox' )
					),
					'slideshow_hover_delay' => array(
						'title' => __( 'Slideshow Hover Delay', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'number',
						'min' => 0,
						'description' => __( 'The delay (if any) before the slider resumes automatically after hover.', 'responsive-lightbox' ),
						'append' => 'ms'
					),
					'slideshow_delay' => array(
						'title' => __( 'Slideshow Delay', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'number',
						'min' => 0,
						'description' => __( 'The delay (if any) before the slider runs automatically on load.', 'responsive-lightbox' ),
						'append' => 'ms'
					),
					'slideshow_pause' => array(
						'title' => __( 'Slideshow Pause', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicslider_gallery',
						'type' => 'number',
						'min' => 0,
						'description' => __( 'The time a slide lasts.', 'responsive-lightbox' ),
						'append' => 'ms'
					)
				)
			),
			'basicmasonry_gallery' => array(
				'option_group' => 'responsive_lightbox_basicmasonry_gallery',
				'option_name' => 'responsive_lightbox_basicmasonry_gallery',
				'sections' => array(
					'responsive_lightbox_basicmasonry_gallery' => array(
						'title' => __( 'Basic Masonry Gallery settings', 'responsive-lightbox' )
					)
				),
				'prefix' => 'rl',
				'fields' => array(
					'screen_size_columns' => array(
						'title' => __( 'Screen sizes', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicmasonry_gallery',
						'type' => 'multiple',
						'description' => __( 'Number of columns in a gallery depending on the device screen size. (if greater than 0 overrides the Columns option)', 'responsive-lightbox' ),
						'fields' => array(
							'columns_lg' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'default' => 4,
								'append' => __( 'large devices / desktops (&ge;1200px)', 'responsive-lightbox' )
							),
							'columns_md' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'default' => 3,
								'append' => __( 'medium devices / desktops (&ge;992px)', 'responsive-lightbox' )
							),
							'columns_sm' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'default' => 2,
								'append' => __( 'small devices / tablets (&ge;768px)', 'responsive-lightbox' )
							),
							'columns_xs' => array(
								'type' => 'number',
								'min' => 0,
								'max' => 6,
								'default' => 2,
								'append' => __( 'extra small devices / phones (<768px)', 'responsive-lightbox' )
							)
						),
					),
					'gutter' => array(
						'title' => __( 'Gutter', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicmasonry_gallery',
						'type' => 'number',
						'description' => __( 'Horizontal space between gallery items.', 'responsive-lightbox' ),
						'append' => 'px'
					),
					'margin' => array(
						'title' => __( 'Margin', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicmasonry_gallery',
						'type' => 'number',
						'description' => __( 'Vertical space between gallery items.', 'responsive-lightbox' ),
						'append' => 'px'
					),
					'origin_left' => array(
						'title' => __( 'Origin Left', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicmasonry_gallery',
						'type' => 'boolean',
						'label' => __( 'Enable left-to-right layouts.', 'responsive-lightbox' ),
						'description' => __( 'Controls the horizontal flow of the layout. By default, item elements start positioning at the left. Uncheck it for right-to-left layouts.', 'responsive-lightbox' )
					),
					'origin_top' => array(
						'title' => __( 'Origin Top', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_basicmasonry_gallery',
						'type' => 'boolean',
						'label' => __( 'Enable top-to-bottom layouts.', 'responsive-lightbox' ),
						'description' => __( 'Controls the vetical flow of the layout. By default, item elements start positioning at the top. Uncheck it for bottom-up layouts.', 'responsive-lightbox' )
					)
				)
			)
		);

		$this->tabs = apply_filters( 'rl_settings_tabs', array(
			'settings' => array(
				'name'	 => __( 'General', 'responsive-lightbox' ),
				'key'	 => 'responsive_lightbox_settings',
				'submit' => 'save_rl_settings',
				'reset'	 => 'reset_rl_settings',
			),
			'configuration'	=> array(
				'name'	 => __( 'Lightboxes', 'responsive-lightbox' ),
				'key'	 => 'responsive_lightbox_configuration',
				'submit' => 'save_' . $this->settings['configuration']['prefix'] . '_configuration',
				'reset'	 => 'reset_' . $this->settings['configuration']['prefix'] . '_configuration',
				'sections' => $scripts,
				'default_section' => Responsive_Lightbox()->options['settings']['script']
			),
			'basicgrid_gallery' => array(
				'name'	 => __( 'Basic Grid', 'responsive-lightbox' ),
				'key'	 => 'responsive_lightbox_basicgrid_gallery',
				'submit' => 'save_rl_basicgrid_gallery',
				'reset'	 => 'reset_rl_basicgrid_gallery',
			),
			'basicslider_gallery' => array(
				'name'	 => __( 'Basic Slider', 'responsive-lightbox' ),
				'key'	 => 'responsive_lightbox_basiclider_gallery',
				'submit' => 'save_rl_basiclider_gallery',
				'reset'	 => 'reset_rl_basiclider_gallery',
			),
			'basicmasonry_gallery' => array(
				'name'	 => __( 'Basic Masonry', 'responsive-lightbox' ),
				'key'	 => 'responsive_lightbox_basicmasonry_gallery',
				'submit' => 'save_rl_basicmasonry_gallery',
				'reset'	 => 'reset_rl_basicmasonry_gallery',
			)
		) );

		$tabs_copy = $this->tabs;
		$tab_key = '';
		$section_key = '';

		// set current tab and section
		if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			global $pagenow;

			// check settings page
			if ( $pagenow === 'options.php' || ( $pagenow == 'admin.php' && isset( $_GET['page'] ) && preg_match( '/^responsive-lightbox-(' . implode( '|', array_keys( $this->tabs + array( 'gallery' => '', 'addons' => '' ) ) ) . ')$/', $_GET['page'], $tabs ) === 1 ) ) {
				$tab_key = isset( $tabs[1] ) ? $tabs[1] : 'settings';
				$section_key = isset( $_REQUEST['section'] ) ? esc_attr( $_REQUEST['section'] ) : ( ! empty( $this->tabs[$tab_key]['default_section'] ) ? $this->tabs[$tab_key]['default_section'] : '' );
			}
		}

		// get default gallery types
		$gallery_types = Responsive_Lightbox()->gallery_types;

		// remove default gallery
		unset( $gallery_types['default'] );

		// get available galleries
		$gallery_types = apply_filters( 'rl_gallery_types', $gallery_types );

		if ( $gallery_types ) {
			foreach ( $gallery_types as $key => $name ) {
				unset( $gallery_types[$key] );

				$gallery_types[$key . '_gallery'] = $name;
			}
		}

		// backward compatibility, remove from tabs
		$gallery_tabs = array_intersect( array_keys( $this->tabs ), array_keys( $gallery_types ) );
		$galleries = array();

		if ( ! empty( $gallery_tabs ) ) {
			// unset tabs if exist
			foreach ( $gallery_tabs as $gallery_tab ) {
				$galleries[$gallery_tab] = $this->tabs[$gallery_tab];

				unset( $this->tabs[$gallery_tab] );
			}

			foreach ( $galleries as $key => $gallery ) {
				$gallery_sections[$key] = $gallery['name'];
			}

			if ( $tab_key == 'gallery' )
				$section_key = isset( $_REQUEST['section'] ) ? esc_attr( $_REQUEST['section'] ) : ( in_array( Responsive_Lightbox()->options['settings']['default_gallery'] . '_gallery', array_keys( $gallery_sections ) ) ? Responsive_Lightbox()->options['settings']['default_gallery'] . '_gallery' : key( $gallery_sections ) );

			$this->tabs['gallery'] = array(
				'name'	 => __( 'Galleries', 'responsive-lightbox' ),
				'key'	 => 'responsive_lightbox_' . $section_key,
				'submit' => array_key_exists( $section_key, $tabs_copy ) ? $tabs_copy[$section_key]['submit'] : 'save_' . $section_key . '_configuration',
				'reset'	 => array_key_exists( $section_key, $tabs_copy ) ? $tabs_copy[$section_key]['reset'] : 'reset_rl_' . $section_key,
				'sections' => $gallery_sections,
				'default_section' => $section_key
			);
		}

		$this->tabs['builder'] = array(
			'name'	 => __( 'Builder', 'responsive-lightbox' ),
			'key'	 => 'responsive_lightbox_builder',
			'submit' => 'save_rl_builder',
			'reset'	 => 'reset_rl_builder',
		);

		// push licenses just beofre the addons
		if ( isset( $this->tabs['licenses'] ) ) {
			unset( $this->tabs['licenses'] );
		
			$this->tabs['licenses'] = array(
				'name'	 => __( 'Licenses', 'responsive-lightbox' ),
				'key'	 => 'responsive_lightbox_licenses',
				'submit' => 'save_rl_licenses',
				'reset'	 => 'reset_rl_licenses',
			);
		}

		$this->tabs['addons'] = array(
			'name'	 	=> __( 'Add-ons', 'responsive-lightbox' ),
			'key'	 	=> 'responsive_lightbox_configuration',
			'callback'	=>  array( $this, 'addons_tab_cb' )
		);

		if ( ! empty( $this->tabs[$tab_key]['sections'] ) && isset( $this->tabs[$tab_key]['sections'][$section_key] ) ) {
			$this->settings[$tab_key]['sections']['responsive_lightbox_' . $tab_key]['title'] = sprintf( __( '%s settings', 'responsive-lightbox' ), $this->tabs[$tab_key]['sections'][$section_key] );
		}

		switch ( ! empty( $section_key ) ? $section_key : Responsive_Lightbox()->options['settings']['script'] ) {
			case 'swipebox':
				$this->settings['configuration']['prefix'] = 'rl_sb';
				$this->settings['configuration']['fields'] = array(
					'animation' => array(
						'title' => __( 'Animation type', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'label' => '',
						'description' => __( 'Select a method of applying a lightbox effect.', 'responsive-lightbox' ),
						'options' => $this->scripts['swipebox']['animations'],
						'parent' => 'swipebox'
					),
					'force_png_icons' => array(
						'title' => __( 'Force PNG icons', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Enable this if you\'re having problems with navigation icons not visible on some devices.', 'responsive-lightbox' ),
						'parent' => 'swipebox'
					),
					'hide_close_mobile' => array(
						'title' => __( 'Hide close on mobile', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Hide the close button on mobile devices.', 'responsive-lightbox' ),
						'parent' => 'swipebox'
					),
					'remove_bars_mobile' => array(
						'title' => __( 'Remove bars on mobile', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Hide the top and bottom bars on mobile devices.', 'responsive-lightbox' ),
						'parent' => 'swipebox'
					),
					'hide_bars' => array(
						'title' => __( 'Top and bottom bars', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'multiple',
						'fields' => array(
							'hide_bars' => array(
								'type' => 'boolean',
								'label' => __( 'Hide top and bottom bars after a period of time.', 'responsive-lightbox' ),
								'parent' => 'swipebox'
							),
							'hide_bars_delay' => array(
								'type' => 'number',
								'description' => __( 'Enter the time after which the top and bottom bars will be hidden (when hiding is enabled).', 'responsive-lightbox' ),
								'append' => 'ms',
								'parent' => 'swipebox'
							)
						)
					),
					'video_max_width' => array(
						'title' => __( 'Video max width', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Enter the max video width in a lightbox.', 'responsive-lightbox' ),
						'append' => 'px',
						'parent' => 'swipebox'
					),
					'loop_at_end' => array(
						'title' => __( 'Loop at end', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'True will return to the first image after the last image is reached.', 'responsive-lightbox' ),
						'parent' => 'swipebox'
					),
				);
				break;

			case 'prettyphoto':
				$this->settings['configuration']['prefix'] = 'rl_pp';
				$this->settings['configuration']['fields'] = array(
					'animation_speed' => array(
						'title' => __( 'Animation speed', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'label' => '',
						'description' => __( 'Select animation speed for lightbox effect.', 'responsive-lightbox' ),
						'options' => $this->scripts['prettyphoto']['animation_speeds'],
						'parent' => 'prettyphoto'
					),
					'slideshow' => array(
						'title' => __( 'Slideshow', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'multiple',
						'fields' => array(
							'slideshow' => array(
								'type' => 'boolean',
								'label' => __( 'Display images as slideshow', 'responsive-lightbox' ),
								'parent' => 'prettyphoto'
							),
							'slideshow_delay' => array(
								'type' => 'number',
								'description' => __( 'Enter time (in miliseconds).', 'responsive-lightbox' ),
								'append' => 'ms',
								'parent' => 'prettyphoto'
							)
						)
					),
					'slideshow_autoplay' => array(
						'title' => __( 'Slideshow autoplay', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Automatically start slideshow.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'opacity' => array(
						'title' => __( 'Opacity', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'range',
						'description' => __( 'Value between 0 and 100, 100 for no opacity.', 'responsive-lightbox' ),
						'min' => 0,
						'max' => 100,
						'parent' => 'prettyphoto'
					),
					'show_title' => array(
						'title' => __( 'Show title', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Display image title.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'allow_resize' => array(
						'title' => __( 'Allow resize big images', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Resize the photos bigger than viewport.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'allow_expand' => array(
						'title' => __( 'Allow expand', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Allow expanding images.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'width' => array(
						'title' => __( 'Video width', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'append' => 'px',
						'parent' => 'prettyphoto'
					),
					'height' => array(
						'title' => __( 'Video height', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'append' => 'px',
						'parent' => 'prettyphoto'
					),
					'theme' => array(
						'title' => __( 'Theme', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'Select the theme for lightbox effect.', 'responsive-lightbox' ),
						'options' => $this->scripts['prettyphoto']['themes'],
						'parent' => 'prettyphoto'
					),
					'horizontal_padding' => array(
						'title' => __( 'Horizontal padding', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'append' => 'px',
						'parent' => 'prettyphoto'
					),
					'hide_flash' => array(
						'title' => __( 'Hide Flash', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Hide all the flash objects on a page. Enable this if flash appears over prettyPhoto.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'wmode' => array(
						'title' => __( 'Flash Window Mode (wmode)', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'Select flash window mode.', 'responsive-lightbox' ),
						'options' => $this->scripts['prettyphoto']['wmodes'],
						'parent' => 'prettyphoto'
					),
					'video_autoplay' => array(
						'title' => __( 'Video autoplay', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Automatically start videos.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'modal' => array(
						'title' => __( 'Modal', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If set to true, only the close button will close the window.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'deeplinking' => array(
						'title' => __( 'Deeplinking', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Allow prettyPhoto to update the url to enable deeplinking.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'overlay_gallery' => array(
						'title' => __( 'Overlay gallery', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If enabled, a gallery will overlay the fullscreen image on mouse over.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'keyboard_shortcuts' => array(
						'title' => __( 'Keyboard shortcuts', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Set to false if you open forms inside prettyPhoto.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
					'social' => array(
						'title' => __( 'Social (Twitter, Facebook)', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Display links to Facebook and Twitter.', 'responsive-lightbox' ),
						'parent' => 'prettyphoto'
					),
				);		
				break;

			case 'fancybox':
				$this->settings['configuration']['prefix'] = 'rl_fb';
				$this->settings['configuration']['fields'] = array(
					'modal' => array(
						'title' => __( 'Modal', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'When true, "overlayShow" is set to true and "hideOnOverlayClick", "hideOnContentClick", "enableEscapeButton", "showCloseButton" are set to false.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'show_overlay' => array(
						'title' => __( 'Show overlay', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle overlay.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'show_close_button' => array(
						'title' => __( 'Show close button', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle close button.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'enable_escape_button' => array(
						'title' => __( 'Enable escape button', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle if pressing Esc button closes lightbox.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'hide_on_overlay_click' => array(
						'title' => __( 'Hide on overlay click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle if clicking the overlay should close FancyBox.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'hide_on_content_click' => array(
						'title' => __( 'Hide on content click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle if clicking the content should close FancyBox.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'cyclic' => array(
						'title' => __( 'Cyclic', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'When true, galleries will be cyclic, allowing you to keep pressing next/back.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'show_nav_arrows' => array(
						'title' => __( 'Show nav arrows', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle navigation arrows.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'auto_scale' => array(
						'title' => __( 'Auto scale', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If true, FancyBox is scaled to fit in viewport.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'scrolling' => array(
						'title' => __( 'Scrolling (in/out)', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'Set the overflow CSS property to create or hide scrollbars.', 'responsive-lightbox' ),
						'options' => $this->scripts['fancybox']['scrollings'],
						'parent' => 'fancybox'
					),
					'center_on_scroll' => array(
						'title' => __( 'Center on scroll', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'When true, FancyBox is centered while scrolling page.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'opacity' => array(
						'title' => __( 'Opacity', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'When true, transparency of content is changed for elastic transitions.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'overlay_opacity' => array(
						'title' => __( 'Overlay opacity', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'range',
						'description' => __( 'Opacity of the overlay.', 'responsive-lightbox' ),
						'min' => 0,
						'max' => 100,
						'parent' => 'fancybox'
					),
					'overlay_color' => array(
						'title' => __( 'Overlay color', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'color_picker',
						'label' => __( 'Color of the overlay.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'title_show' => array(
						'title' => __( 'Title show', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle title.', 'responsive-lightbox' ),
						'parent' => 'fancybox'
					),
					'title_position' => array(
						'title' => __( 'Title position', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'The position of title.', 'responsive-lightbox' ),
						'options' => $this->scripts['fancybox']['positions'],
						'parent' => 'fancybox'
					),
					'transitions' => array(
						'title' => __( 'Transition (in/out)', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'The transition type.', 'responsive-lightbox' ),
						'options' => $this->scripts['fancybox']['transitions'],
						'parent' => 'fancybox'
					),
					'easings' => array(
						'title' => __( 'Easings (in/out)', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'Easing used for elastic animations.', 'responsive-lightbox' ),
						'options' => $this->scripts['fancybox']['easings'],
						'parent' => 'fancybox'
					),
					'speeds' => array(
						'title' => __( 'Speed (in/out)', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Speed of the fade and elastic transitions, in milliseconds.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'fancybox'
					),
					'change_speed' => array(
						'title' => __( 'Change speed', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Speed of resizing when changing gallery items, in milliseconds.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'fancybox'
					),
					'change_fade' => array(
						'title' => __( 'Change fade', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Speed of the content fading while changing gallery items.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'fancybox'
					),
					'padding' => array(
						'title' => __( 'Padding', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Space between FancyBox wrapper and content.', 'responsive-lightbox' ),
						'append' => 'px',
						'parent' => 'fancybox'
					),
					'margin' => array(
						'title' => __( 'Margin', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Space between viewport and FancyBox wrapper.', 'responsive-lightbox' ),
						'append' => 'px',
						'parent' => 'fancybox'
					),
					'video_width' => array(
						'title' => __( 'Video width', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Width of the video.', 'responsive-lightbox' ),
						'append' => 'px',
						'parent' => 'fancybox'
					),
					'video_height' => array(
						'title' => __( 'Video height', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Height of the video.', 'responsive-lightbox' ),
						'append' => 'px',
						'parent' => 'fancybox'
					),
				);
				break;

			case 'nivo':
				$this->settings['configuration']['prefix'] = 'rl_nv';
				$this->settings['configuration']['fields'] = array(
					'effect' => array(
						'title' => __( 'Effect', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'The effect to use when showing the lightbox.', 'responsive-lightbox' ),
						'options' => $this->scripts['nivo']['effects'],
						'parent' => 'nivo'
					),
					'keyboard_nav' => array(
						'title' => __( 'Keyboard navigation', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Enable keyboard navigation (left/right/escape).', 'responsive-lightbox' ),
						'parent' => 'nivo'
					),
					'click_overlay_to_close' => array(
						'title' => __( 'Click overlay to close', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Enable to close lightbox on overlay click.', 'responsive-lightbox' ),
						'parent' => 'nivo'
					),
					'error_message' => array(
						'title' => __( 'Error message', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'text',
						'class' => 'large-text',
						'label' => __( 'Error message if the content cannot be loaded.', 'responsive-lightbox' ),
						'parent' => 'nivo'
					),
				);
				break;

			case 'imagelightbox':
				$this->settings['configuration']['prefix'] = 'rl_il';
				$this->settings['configuration']['fields'] = array(
					'animation_speed' => array(
						'title' => __( 'Animation speed', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Animation speed.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'imagelightbox'
					),
					'preload_next' => array(
						'title' => __( 'Preload next image', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Silently preload the next image.', 'responsive-lightbox' ),
						'parent' => 'imagelightbox'
					),
					'enable_keyboard' => array(
						'title' => __( 'Enable keyboard keys', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Enable keyboard shortcuts (arrows Left/Right and Esc).', 'responsive-lightbox' ),
						'parent' => 'imagelightbox'
					),
					'quit_on_end' => array(
						'title' => __( 'Quit after last image', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Quit after viewing the last image.', 'responsive-lightbox' ),
						'parent' => 'imagelightbox'
					),
					'quit_on_image_click' => array(
						'title' => __( 'Quit on image click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Quit when the viewed image is clicked.', 'responsive-lightbox' ),
						'parent' => 'imagelightbox'
					),
					'quit_on_document_click' => array(
						'title' => __( 'Quit on anything click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Quit when anything but the viewed image is clicked.', 'responsive-lightbox' ),
						'parent' => 'imagelightbox'
					),
				);
				break;

			case 'tosrus':
				$this->settings['configuration']['prefix'] = 'rl_tr';
				$this->settings['configuration']['fields'] = array(
					'effect' => array(
						'title' => __( 'Transition effect', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'description' => __( 'What effect to use for the transition.', 'responsive-lightbox' ),
						'options' => array(
							'slide' => __( 'slide', 'responsive-lightbox' ),
							'fade' => __( 'fade', 'responsive-lightbox' )
						),
						'parent' => 'tosrus'
					),
					'infinite' => array(
						'title' => __( 'Infinite loop', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Whether or not to slide back to the first slide when the last has been reached.', 'responsive-lightbox' ),
						'parent' => 'tosrus'
					),
					'keys' => array(
						'title' => __( 'Keyboard navigation', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Enable keyboard navigation (left/right/escape).', 'responsive-lightbox' ),
						'parent' => 'tosrus'
					),
					'autoplay' => array(
						'title' => __( 'Autoplay', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'multiple',
						'fields' => array(
							'autoplay' => array(
								'type' => 'boolean',
								'label' => __( 'Automatically start slideshow.', 'responsive-lightbox' ),
								'parent' => 'tosrus'
							),
							'timeout' => array(
								'type' => 'number',
								'description' => __( 'The timeout between sliding to the next slide in milliseconds.', 'responsive-lightbox' ),
								'append' => 'ms',
								'parent' => 'tosrus'
							)
						)
					),
					'pause_on_hover' => array(
						'title' => __( 'Pause on hover', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Whether or not to pause on hover.', 'responsive-lightbox' ),
						'parent' => 'tosrus'
					),
					'pagination' => array(
						'title' => __( 'Pagination', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'multiple',
						'fields' => array(
							'pagination' => array(
								'type' => 'boolean',
								'label' => __( 'Whether or not to add a pagination.', 'responsive-lightbox' ),
								'parent' => 'tosrus'
							),
							'pagination_type' => array(
								'type' => 'radio',
								'description' => __( 'What type of pagination to use.', 'responsive-lightbox' ),
								'options' => array(
									'bullets' => __( 'Bullets', 'responsive-lightbox' ),
									'thumbnails' => __( 'Thumbnails', 'responsive-lightbox' )
								),
								'parent' => 'tosrus'
							)
						)
					),
					'close_on_click' => array(
						'title'			=> __( 'Overlay close', 'responsive-lightbox' ),
						'section'		=> 'responsive_lightbox_configuration',
						'type'			=> 'boolean',
						'label'			=> __( 'Enable to close lightbox on overlay click.', 'responsive-lightbox' ),
						'parent'		=> 'tosrus'
					)
				);
				break;

			case 'featherlight':
				$this->settings['configuration']['prefix'] = 'rl_fl';
				$this->settings['configuration']['fields'] = array(
					'open_speed' => array(
						'title' => __( 'Opening speed', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Duration of opening animation.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'featherlight'
					),
					'close_speed' => array(
						'title' => __( 'Closing speed', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Duration of closing animation.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'featherlight'
					),
					'close_on_click' => array(
						'title' => __( 'Close on click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'radio',
						'label' => __( 'Select how to close lightbox.', 'responsive-lightbox' ),
						'options' => array(
							'background' => __( 'background', 'responsive-lightbox' ),
							'anywhere' => __( 'anywhere', 'responsive-lightbox' ),
							'false' => __( 'false', 'responsive-lightbox' )
						),
						'parent' => 'featherlight'
					),
					'close_on_esc' => array(
						'title' => __( 'Close on Esc', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Toggle if pressing Esc button closes lightbox.', 'responsive-lightbox' ),
						'parent' => 'featherlight'
					),
					'gallery_fade_in' => array(
						'title' => __( 'Gallery fade in', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Animation speed when image is loaded.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'featherlight'
					),
					'gallery_fade_out' => array(
						'title' => __( 'Gallery fade out', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'Animation speed before image is loaded.', 'responsive-lightbox' ),
						'append' => 'ms',
						'parent' => 'featherlight'
					)
				);
				break;

			case 'magnific':
				$this->settings['configuration']['prefix'] = 'rl_mp';
				$this->settings['configuration']['fields'] = array(
					'disable_on' => array(
						'title' => __( 'Disable on', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'number',
						'description' => __( 'If window width is less than the number in this option lightbox will not be opened and the default behavior of the element will be triggered. Set to 0 to disable behavior.', 'responsive-lightbox' ),
						'append' => 'px',
						'parent' => 'magnific'
					),
					'mid_click' => array(
						'title' => __( 'Middle click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If option enabled, lightbox is opened if the user clicked on the middle mouse button, or click with Command/Ctrl key.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'preloader' => array(
						'title' => __( 'Preloader', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If option enabled, it\'s always present in DOM only text inside of it changes.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'close_on_content_click' => array(
						'title' => __( 'Close on content click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Close popup when user clicks on content of it. It\'s recommended to enable this option when you have only image in popup.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'close_on_background_click' => array(
						'title' => __( 'Close on background click', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Close the popup when user clicks on the dark overlay.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'close_button_inside' => array(
						'title' => __( 'Close button inside', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If enabled, Magnific Popup will put close button inside content of popup.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'show_close_button' => array(
						'title' => __( 'Show close button', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Controls whether the close button will be displayed or not.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'enable_escape_key' => array(
						'title' => __( 'Enable escape key', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'Controls whether pressing the escape key will dismiss the active popup or not.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'align_top' => array(
						'title' => __( 'Align top', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If set to true popup is aligned to top instead of to center.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					),
					'fixed_content_position' => array(
						'title' => __( 'Content position type', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'select',
						'description' => __( 'Popup content position. If set to "auto" popup will automatically disable this option when browser doesn\'t support fixed position properly.', 'responsive-lightbox' ),
						'options' => array(
							'auto' => __( 'Auto', 'responsive-lightbox' ),
							'true' => __( 'Fixed', 'responsive-lightbox' ),
							'false' => __( 'Absolute', 'responsive-lightbox' )
						),
						'parent' => 'magnific'
					),
					'fixed_background_position' => array(
						'title' => __( 'Fixed background position', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'select',
						'description' => __( 'Dark transluscent overlay content position.', 'responsive-lightbox' ),
						'options' => array(
							'auto' => __( 'Auto', 'responsive-lightbox' ),
							'true' => __( 'Fixed', 'responsive-lightbox' ),
							'false' => __( 'Absolute', 'responsive-lightbox' )
						),
						'parent' => 'magnific'
					),
					'auto_focus_last' => array(
						'title' => __( 'Auto focus last', 'responsive-lightbox' ),
						'section' => 'responsive_lightbox_configuration',
						'type' => 'boolean',
						'label' => __( 'If set to true last focused element before popup showup will be focused after popup close.', 'responsive-lightbox' ),
						'parent' => 'magnific'
					)
				);
				break;

			default:
				$this->settings['configuration'] = apply_filters( 'rl_settings_' . ( ! empty( $section_key ) ? $section_key : Responsive_Lightbox()->options['settings']['script'] ) . '_script_configuration', $this->settings['configuration'] );
		}

		if ( isset( $this->tabs[$tab_key]['submit'], $this->tabs[$tab_key]['reset'] ) && ! empty( $this->settings[$tab_key]['prefix'] ) ) {
			$this->tabs[$tab_key]['submit'] = 'save_' . $this->settings[$tab_key]['prefix'] . '_' . $tab_key;
			$this->tabs[$tab_key]['reset'] = 'reset_' . $this->settings[$tab_key]['prefix'] . '_' . $tab_key;
		}
	}

	/**
	 * Register options page
	 * 
	 * @return void
	 */
	public function admin_menu_options() {
		add_menu_page( __( 'General', 'responsive-lightbox' ), __( 'Lightbox', 'responsive-lightbox' ), apply_filters( 'rl_lightbox_settings_capability', 'manage_options' ), 'responsive-lightbox-settings', '', 'dashicons-format-image', '57.1' );

		$capability = apply_filters( 'rl_lightbox_settings_capability', 'manage_options' );

		foreach ( $this->tabs as $key => $options ) {
			add_submenu_page( 'responsive-lightbox-settings', $options['name'], $options['name'], $capability, 'responsive-lightbox-' . $key , array( $this, 'options_page' ) );
		}
	}

	/**
	 * Render options page
	 * 
	 * @return void
	 */
	public function options_page() {
		// check settings page
		if ( isset( $_GET['page'] ) && preg_match( '/^responsive-lightbox-(' . implode( '|', array_keys( $this->tabs ) ) . ')$/', $_GET['page'], $tabs ) !== 1 )
			return;

		$tab_key = isset( $tabs[1] ) ? $tabs[1] : 'settings';
		$section_key = isset( $_GET['section'] ) ? esc_attr( $_GET['section'] ) : ( ! empty( $this->tabs[$tab_key]['default_section'] ) ? $this->tabs[$tab_key]['default_section'] : '' );

		echo '
		<div class="wrap">
			<h2>' . __( 'Responsive Lightbox & Gallery', 'responsive-lightbox' ) . ' - ' . $this->tabs[$tab_key]['name'] . '</h2>';

		settings_errors();

		echo '
			<h2 class="nav-tab-wrapper">';

		foreach ( $this->tabs as $key => $options ) {
			echo '
			<a class="nav-tab ' . ( $tab_key == $key ? 'nav-tab-active' : '' ) . '" href="' . esc_url( admin_url( 'admin.php?page=responsive-lightbox-' . $key ) ) . '">' . $options['name'] . '</a>';
		}

		echo '
			</h2>
			<div class="responsive-lightbox-settings">
			
				<div class="df-credits">
					<h3 class="hndle">' . __( 'Responsive Lightbox & Gallery', 'responsive-lightbox' ) . ' ' . Responsive_Lightbox()->defaults['version'] . '</h3>
					<div class="inside">
						<h4 class="inner">' . __( 'Need support?', 'responsive-lightbox' ) . '</h4>
						<p class="inner">' . sprintf( __( 'If you are having problems with this plugin, please browse it\'s <a href="%s" target="_blank">Documentation</a> or talk about them in the <a href="%s" target="_blank">Support forum</a>', 'responsive-lightbox' ), 'https://www.dfactory.eu/docs/responsive-lightbox/?utm_source=responsive-lightbox-settings&utm_medium=link&utm_campaign=docs', 'https://www.dfactory.eu/support/?utm_source=responsive-lightbox-settings&utm_medium=link&utm_campaign=support' ) . '</p>
						<hr />
						<h4 class="inner">' . __( 'Do you like this plugin?', 'responsive-lightbox' ) . '</h4>
						<p class="inner">' . sprintf( __( '<a href="%s" target="_blank">Rate it 5</a> on WordPress.org', 'responsive-lightbox' ), 'https://wordpress.org/support/plugin/responsive-lightbox/reviews/?filter=5' ) . '<br />' .
						sprintf( __( 'Blog about it & link to the <a href="%s" target="_blank">plugin page</a>.', 'responsive-lightbox' ), 'https://dfactory.eu/plugins/responsive-lightbox/?utm_source=responsive-lightbox-settings&utm_medium=link&utm_campaign=blog-about' ) . '<br />' .
						sprintf( __( 'Check out our other <a href="%s" target="_blank">WordPress plugins</a>.', 'responsive-lightbox' ), 'https://dfactory.eu/plugins/?utm_source=responsive-lightbox-settings&utm_medium=link&utm_campaign=other-plugins' ) . '
						</p>
						<hr />
						<p class="df-link inner">Created by <a href="http://www.dfactory.eu/?utm_source=responsive-lightbox-settings&utm_medium=link&utm_campaign=created-by" target="_blank" title="dFactory - Quality plugins for WordPress"><img src="' . RESPONSIVE_LIGHTBOX_URL . '/images/logo-dfactory.png' . '" title="dFactory - Quality plugins for WordPress" alt="dFactory - Quality plugins for WordPress" /></a></p>
					</div>
				</div>
			
				<form action="options.php" method="post">';
		
		// views
		if ( ! empty( $this->tabs[$tab_key]['sections'] ) ) {
			$views = $this->tabs[$tab_key]['sections'];

			echo '<ul class="subsubsub">';

			foreach ( $views as $key => $name ) {
				$view = '<a href="' . esc_url( admin_url( 'admin.php?page=responsive-lightbox-' . $tab_key . '&section=' . $key ) ) . '" class="' . ( $key == $section_key ? 'current' : '' ) . '">' . $name . '</a>';
				$views[$key] = "\t<li class='$key'>$view";
			}

			echo implode( " |</li>\n", $views ) . "</li>\n";
			echo '</ul><input type="hidden" name="section" value="' . $section_key . '" /><br class="clear">';
		}

		// tab content callback
		if ( ! empty( $this->tabs[$tab_key]['callback'] ) )
			call_user_func( $this->tabs[$tab_key]['callback'] );
		else {
			wp_nonce_field( 'update-options' );
			
			settings_fields( $this->tabs[$tab_key]['key'] );
			do_settings_sections( $this->tabs[$tab_key]['key'] );

			if ( $tab_key === 'builder' )
				echo '<input type="hidden" name="_wp_http_referer" value="'. esc_attr( wp_unslash( add_query_arg( 'flush_rules', 1, $_SERVER['REQUEST_URI'] ) ) ) . '" />';
		}

		if ( ! empty( $this->tabs[$tab_key]['submit'] ) || ! empty( $this->tabs[$tab_key]['reset'] ) ) {
			echo '<p class="submit">';

			if ( ! empty( $this->tabs[$tab_key]['submit'] ) ) {
				submit_button( '', array( 'primary', 'save-' . $tab_key ), $this->tabs[$tab_key]['submit'], false );
				echo ' ';
			}

			if ( ! empty( $this->tabs[$tab_key]['reset'] ) )
				submit_button( __( 'Reset to defaults', 'responsive-lightbox' ), array( 'secondary', 'reset-' . $tab_key ), $this->tabs[$tab_key]['reset'], false );

			echo '</p>';
		}

		echo '
				</form>
			</div>
			<div class="clear"></div>
		</div>';
	}

	/**
	 * Render settings function
	 * 
	 * @return void
	 */
	public function register_settings() {
		foreach ( $this->settings as $setting_id => $setting ) {
			// set key
			$setting_key = $setting_id;
			$setting_id = 'responsive_lightbox_' . $setting_id;

			// register setting
			register_setting(
				esc_attr( $setting_id ),
				! empty( $setting['option_name'] ) ? esc_attr( $setting['option_name'] ) : $setting_id,
				! empty( $setting['callback'] ) ? $setting['callback'] : array( $this, 'validate_settings' )
			);

			// register sections
			if ( ! empty( $setting['sections'] ) && is_array( $setting['sections'] ) ) {
				foreach ( $setting['sections'] as $section_id => $section ) {
					add_settings_section( 
						esc_attr( $section_id ),
						! empty( $section['title'] ) ? esc_html( $section['title'] ) : '',
						! empty( $section['callback'] ) ? $section['callback'] : '',
						! empty( $section['page'] ) ? esc_attr( $section['page'] ) : $section_id
					);
				}
			}

			// register fields
			if ( ! empty( $setting['fields'] ) && is_array( $setting['fields'] ) ) {
				foreach ( $setting['fields'] as $field_id => $field ) {
					// prefix field id?
					$field_key = $field_id;
					$field_id = ( ! empty( $setting['prefix'] ) ? $setting['prefix'] . '_' : '' ) . $field_id;
					
					// field args
					$args = array(
						'id' => ! empty( $field['id'] ) ? $field['id'] : $field_id,
						'class' => ! empty( $field['class'] ) ? $field['class'] : '',
						'name' => $setting['option_name'] . ( ! empty( $field['parent'] ) ? '[' . $field['parent'] . ']' : '' ) . '[' . $field_key . ']',
						'type' => ! empty( $field['type'] ) ? $field['type'] : 'text',
						'label' => ! empty( $field['label'] ) ? $field['label'] : '',
						'description' => ! empty( $field['description'] ) ? $field['description'] : '',
						'disabled' => isset( $field['disabled'] ) ? (bool) $field['disabled'] : false,
						'append' => ! empty( $field['append'] ) ? esc_html( $field['append'] ) : '',
						'prepend' => ! empty( $field['prepend'] ) ? esc_html( $field['prepend'] ) : '',
						'min' => ! empty( $field['min'] ) ? (int) $field['min'] : '',
						'max' => ! empty( $field['max'] ) ? (int) $field['max'] : '',
						'options' => ! empty( $field['options'] ) ? $field['options'] : '',
						'fields' => ! empty( $field['fields'] ) ? $field['fields'] : '',
						'default' => $field['type'] === 'multiple' ? '' : ( $this->sanitize_field( ! empty( $field['parent'] ) ? Responsive_Lightbox()->defaults[$setting_key][$field['parent']][$field_key] : Responsive_Lightbox()->defaults[$setting_key][$field_key], $field['type'] ) ),
						'value' => $field['type'] === 'multiple' ? '' : ( $this->sanitize_field( ! empty( $field['parent'] ) ? Responsive_Lightbox()->options[$setting_key][$field['parent']][$field_key] : ( isset( Responsive_Lightbox()->options[$setting_key][$field_key] ) ? Responsive_Lightbox()->options[$setting_key][$field_key] : Responsive_Lightbox()->defaults[$setting_key][$field_key] ), $field['type'] ) ),
						'label_for' => $field_id,
						'return' => false
					);

					if ( $args['type'] === 'multiple' ) {
						foreach ( $args['fields'] as $subfield_id => $subfield ) {
							$args['fields'][$subfield_id] = wp_parse_args( $subfield, array(
								'id' => $field_id . '-' . $subfield_id,
								'class' => ! empty( $subfield['class'] ) ? $subfield['class'] : '',
								'name' => $setting['option_name'] . ( ! empty( $subfield['parent'] ) ? '[' . $subfield['parent'] . ']' : '' ) . '[' . $subfield_id . ']',
								'default' => $this->sanitize_field( ! empty( $subfield['parent'] ) ? Responsive_Lightbox()->defaults[$setting_key][$subfield['parent']][$subfield_id] : Responsive_Lightbox()->defaults[$setting_key][$subfield_id], $subfield['type'] ),
								'value' => $this->sanitize_field( ! empty( $subfield['parent'] ) ? Responsive_Lightbox()->options[$setting_key][$subfield['parent']][$subfield_id] : Responsive_Lightbox()->options[$setting_key][$subfield_id], $subfield['type'] ),
								'return' => true
							) );
						}
					}

					add_settings_field(
						esc_attr( $field_id ),
						! empty( $field['title'] ) ? esc_html( $field['title'] ) : '',
						array( $this, 'render_field' ),
						! empty( $field['page'] ) ? esc_attr( $field['page'] ) : $setting_id,
						! empty( $field['section'] ) ? esc_attr( $field['section'] ) : '',
						$args
					);
				}
			}
		}

		// licenses
		$extensions = apply_filters( 'rl_settings_licenses', array() );

		if ( $extensions ) {
			// register setting
			register_setting(
				'responsive_lightbox_licenses',
				'responsive_lightbox_licenses',
				array( $this, 'validate_licenses' )
			);

			add_settings_section( 
				'responsive_lightbox_licenses',
				__( 'Licenses', 'responsive-lightbox' ),
				array( $this, 'licenses_section_cb' ),
				'responsive_lightbox_licenses'
			);

			foreach ( $extensions as $id => $extension ) {
				add_settings_field(
					esc_attr( $id ),
					$extension['name'],
					array( $this, 'license_field_cb' ),
					'responsive_lightbox_licenses',
					'responsive_lightbox_licenses',
					$extension
				);
			}
		}
	}

	/**
	 * Render settings field function
	 * 
	 * @param array $args
	 * @return mixed
	 */
	public function render_field( $args ) {
		if ( empty( $args ) || ! is_array( $args ) )
			return;

		$html = '';

		switch ( $args['type'] ) {
			case 'boolean':
			
				$html .= '<label class="cb-checkbox"><input id="' . $args['id'] . '" type="checkbox" name="' . $args['name'] . '" value="1" ' . checked( (bool) $args['value'], true, false ) . ( isset( $args['disabled'] ) && $args['disabled'] == true ? ' disabled="disabled"' : '' ) . ' />' . $args['label'] . '</label>';
				break;
				
			case 'radio':
				foreach ( $args['options'] as $key => $name ) {
					$html .= '<label class="cb-radio"><input id="' . $args['id'] . '-' . $key . '" type="radio" name="' . $args['name'] . '" value="' . $key . '" ' . checked( $key, $args['value'], false ) . ( isset( $args['disabled'] ) && $args['disabled'] == true ? ' disabled="disabled"' : '' ) . ' />' . $name . '</label> ';
				}
				break;
				
			case 'checkbox':
				foreach ( $args['options'] as $key => $name ) {
					$html .= '<label class="cb-checkbox"><input id="' . $args['id'] . '-' . $key . '" type="checkbox" name="' . $args['name'] . '[' . $key . ']" value="1" ' . checked( in_array( $key, $args['value'] ), true, false ) . ( isset( $args['disabled'] ) && $args['disabled'] == true ? ' disabled="disabled"' : '' ) . ' />' . $name . '</label> ';
				}
				break;
				
			case 'select':
				$html .= '<select id="' . $args['id'] . '" name="' . $args['name'] . '" value="' . $args['value'] . '" />';

				foreach ( $args['options'] as $key => $name ) {
					$html .= '<option value="' . $key . '" ' . selected( $args['value'], $key, false ) . '>' . $name . '</option>';
				}
					
				$html .= '</select>';
				break;
				
			case 'multiple':
				$html .= '<fieldset>';

				if ( $args['fields'] ) {
					$count = 1;
					$count_fields = count( $args['fields'] );

					foreach ( $args['fields'] as $subfield_id => $subfield_args ) {
						$html .= $this->render_field( $subfield_args ) . ( $count < $count_fields ? '<br />' : '' );
						$count++;
					}
				}

				$html .= '</fieldset>';
				break;

			case 'range':
				$html .= '<input id="' . $args['id'] . '" type="range" name="' . $args['name'] . '" value="' . $args['value'] . '" min="' . $args['min'] . '" max="' . $args['max'] . '" oninput="this.form.' . $args['id'] . '_range.value=this.value" />';
				$html .= '<output name="' . $args['id'] . '_range">' . (int) $args['value'] . '</output>';
				break;

			case 'color_picker':
				$html .= '<input id="' . $args['id'] . '" class="color-picker" type="text" value="' . $args['value'] . '" name="' . $args['name'] . '" data-default-color="' . $args['default'] . '" />';
				break;

			case 'number':
				$html .= ( ! empty( $args['prepend'] ) ? '<span>' . $args['prepend'] . '</span> ' : '' );
				$html .= '<input id="' . $args['id'] . '" type="text" value="' . $args['value'] . '" name="' . $args['name'] . '" />';
				$html .= ( ! empty( $args['append'] ) ? ' <span>' . $args['append'] . '</span>' : '' );
				break;

			case 'button':
				$html .= ( ! empty( $args['prepend'] ) ? '<span>' . $args['prepend'] . '</span> ' : '' );
				$html .= '<a href="' . esc_url( admin_url( 'admin.php?page=responsive-lightbox-tour' ) ) . '" id="' . $args['id'] . '" class="button button-secondary">' . esc_html( $args['label'] ) . '</a>';
				// $html .= '<input id="' . $args['id'] . '" type="submit" value="' . esc_attr( $args['label'] ) . '" name="' . $args['name'] . '" class="button button-secondary" />';
				$html .= ( ! empty( $args['append'] ) ? ' <span>' . $args['append'] . '</spbuilderan>' : '' );
				break;

			case 'text':
			default :
				$html .= ( ! empty( $args['prepend'] ) ? '<span>' . $args['prepend'] . '</span> ' : '' );
				$html .= '<input id="' . $args['id'] . '" class="' . $args['class'] . '" type="text" value="' . $args['value'] . '" name="' . $args['name'] . '" />';
				$html .= ( ! empty( $args['append'] ) ? ' <span>' . $args['append'] . '</span>' : '' );
		}
		
		if ( ! empty ( $args['description'] ) ) {
			$html .= '<p class="description">' . $args['description'] . '</p>';
		}
		
		if ( ! empty( $args['return'] ) ) {
			return $html;
		} else {
			echo $html;
		}
	}

	/**
	 * Sanitize field function
	 * 
	 * @param mixed
	 * @param string
	 * @return mixed
	 */
	public function sanitize_field( $value = null, $type = '', $args = array() ) {
		if ( is_null( $value ) )
			return null;

		switch ( $type ) {
			case 'button':
			case 'boolean':
				$value = empty( $value ) ? false : true;
				break;

			case 'checkbox':
				$value = is_array( $value ) && ! empty( $value ) ? array_map( 'sanitize_text_field', $value ) : array();
				break;

			case 'radio':
				$value = is_array( $value ) ? false : sanitize_text_field( $value );
				break;
				
			case 'textarea':
			case 'wysiwyg':
				$value = wp_kses_post( $value );
				break;

			case 'color_picker':
				$value = ! $value || '#' == $value ? '' : esc_attr( $value );
				break;

			case 'number':
				$value = (int) $value;

				// is value lower than?
				if ( isset( $args['min'] ) && $value < $args['min'] )
					$value = $args['min'];

				// is value greater than?
				if ( isset( $args['max'] ) && $value > $args['max'] )
					$value = $args['max'];
				break;

			case 'text':
			case 'select':
			default:
				$value = is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : sanitize_text_field( $value );
				break;
		}

		return stripslashes_deep( $value );
	}

	/**
	 * Validate settings function
	 * 
	 * @param array $input
	 * @return array
	 */
	public function validate_settings( $input ) {
		// check cap
		if ( ! current_user_can( apply_filters( 'rl_lightbox_settings_capability', 'manage_options' ) ) )
			return $input;

		if ( isset( $_POST['responsive_lightbox_settings']['tour'] ) ) {
			
		}

		// check page
		if ( ! isset( $_POST['option_page'] ) || ! ( $option_page = esc_attr( $_POST['option_page'] ) ) )
			return $input;

		foreach ( $this->settings as $id => $setting ) {
			$key = array_search( $option_page, $setting );

			if ( $key ) {
				// set key
				$setting_id = $id;
				break;
			}
		}

		// check setting id
		if ( ! $setting_id )
			return $input;

		// save settings
		if ( isset( $_POST['save' . '_' . $this->settings[$setting_id]['prefix']  . '_' . $setting_id] ) ) {
			if ( $this->settings[$setting_id]['fields'] ) {
				foreach ( $this->settings[$setting_id]['fields'] as $field_id => $field ) {
					if ( $field['type'] === 'multiple' ) {
						if ( $field['fields'] ) {
							foreach ( $field['fields'] as $subfield_id => $subfield ) {
								// if subfield has parent
								if ( ! empty( $this->settings[$setting_id]['fields'][$field_id]['fields'][$subfield_id]['parent'] ) ) {
									$field_parent = $this->settings[$setting_id]['fields'][$field_id]['fields'][$subfield_id]['parent'];

									$input[$field_parent][$subfield_id] = isset( $input[$field_parent][$subfield_id] ) ? $this->sanitize_field( $input[$field_parent][$subfield_id], $subfield['type'] ) : ( $subfield['type'] === 'boolean' ? false : Responsive_Lightbox()->defaults[$setting_id][$field_parent][$subfield_id] );
								} else {
									$input[$subfield_id] = isset( $input[$subfield_id] ) ? $this->sanitize_field( $input[$subfield_id], $subfield['type'] ) : ( $subfield['type'] === 'boolean' ? false : Responsive_Lightbox()->defaults[$setting_id][$field_id][$subfield_id] );
								}
							}
						}
					} else {
						// if field has parent
						if ( ! empty( $this->settings[$setting_id]['fields'][$field_id]['parent'] ) ) {
							$field_parent = $this->settings[$setting_id]['fields'][$field_id]['parent'];

							$input[$field_parent][$field_id] = isset( $input[$field_parent][$field_id] ) ? ( $field['type'] === 'checkbox' ? array_keys( $this->sanitize_field( $input[$field_parent][$field_id], $field['type'] ) ) : $this->sanitize_field( $input[$field_parent][$field_id], $field['type'] ) ) : ( in_array( $field['type'], array( 'boolean', 'checkbox' ) ) ? false : Responsive_Lightbox()->defaults[$setting_id][$field_parent][$field_id] );
						} else {
							$input[$field_id] = isset( $input[$field_id] ) ? ( $field['type'] === 'checkbox' ? array_keys( $this->sanitize_field( $input[$field_id], $field['type'] ) ) : $this->sanitize_field( $input[$field_id], $field['type'] ) ) : ( in_array( $field['type'], array( 'boolean', 'checkbox' ) ) ? false : Responsive_Lightbox()->defaults[$setting_id][$field_id] );
						}
					}
				}
			}

			if ( $setting_id === 'settings' ) {
				// merge scripts settings
				$input = array_merge( Responsive_Lightbox()->options['settings'], $input );
			}

			if ( $setting_id === 'configuration' ) {
				// merge scripts settings
				$input = array_merge( Responsive_Lightbox()->options['configuration'], $input );
			}
		} elseif ( isset( $_POST['reset' . '_' . $this->settings[$setting_id]['prefix']  . '_' . $setting_id] ) ) {
			if ( $setting_id === 'configuration' ) {
				$script = key( $input );

				// merge scripts settings
				$input[$script] = Responsive_Lightbox()->defaults['configuration'][$script];
				$input = array_merge( Responsive_Lightbox()->options['configuration'], $input );
			} elseif ( $setting_id === 'settings' ) {
				$input = Responsive_Lightbox()->defaults[$setting_id];
				$input['update_version'] = Responsive_Lightbox()->options['settings']['update_version'];
				$input['update_notice'] = Responsive_Lightbox()->options['settings']['update_notice'];
			} else
				$input = Responsive_Lightbox()->defaults[$setting_id];

			add_settings_error( 'reset_' . $this->settings[$setting_id]['prefix']  . '_' . $setting_id, 'settings_restored', __( 'Settings restored to defaults.', 'responsive-lightbox' ), 'updated' );
		}

		return $input;
	}

	/**
	 * Add-ons tab callback
	 * 
	 * @return mixed
	 */
	private function addons_tab_cb() {
		?>
		<h3><?php _e( 'Add-ons / Extensions', 'responsive-lightbox' ); ?></h3>
		<p class="description"><?php _e( 'Enhance your website with these beautiful, easy to use extensions, designed with Responsive Lightbox & Gallery integration in mind.', 'responsive-lightbox' ); ?></p>
		<br />
		<?php
		if ( ( $cache = get_transient( 'responsive_lightbox_addons_feed' ) ) === false ) {
			$url = 'https://dfactory.eu/?feed=addons&product=responsive-lightbox';

			$feed = wp_remote_get( esc_url_raw( $url ), array( 'sslverify' => false ) );

			if ( ! is_wp_error( $feed ) ) {
				if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 )
					$cache = wp_remote_retrieve_body( $feed );
			} else
				$cache = '<div class="error"><p>' . __( 'There was an error retrieving the extensions list from the server. Please try again later.', 'responsive-lightbox' ) . '</div>';
		}

		echo $cache;
	}

	/**
	 * Licenses section callback.
	 * 
	 * @return mixed
	 */
	public function licenses_section_cb() {
		?><p class="description"><?php _e( 'A list of licenses for your Responsive Lightbox & Gallery extensions.', 'responsive-lightbox' ); ?></p><?php
	}

	/**
	 * License field callback.
	 * 
	 * @return mixed
	 */
	public function license_field_cb( $args ) {
		$licenses = get_option( 'responsive_lightbox_licenses' );
		$license = ! empty( $licenses ) && isset( $licenses[$args['id']]['license'] ) ? esc_attr( $licenses[$args['id']]['license'] ) : '';
		$status = ! empty( $licenses ) && ! empty( $licenses[$args['id']]['status'] ) ? true : false;
		?>
		<fieldset class="rl_license rl_license-<?php echo esc_attr( $args['id'] ); ?>">
			<input type="text" class="regular-text" name="responsive_lightbox_licenses[<?php echo esc_attr( $args['id'] ); ?>][license]" value="<?php echo $license; ?>"><span class="dashicons <?php echo ! empty( $status ) ? 'dashicons-yes' : 'dashicons-no'; ?>"></span>
			<p class="description"><?php printf( __( 'Enter your license key to activate %s extension and enable automatic upgrade notices.', 'responsive-lightbox' ), $args['name'] ); ?></p>
		</fieldset>
		<?php
	}

	/**
	 * Validate licenses function.
	 * 
	 * @param array $input
	 * @return array
	 */
	public function validate_licenses( $input ) {
		// check cap
		if ( ! current_user_can( apply_filters( 'rl_lightbox_settings_capability', 'manage_options' ) ) )
			return $input;

		// check page
		if ( ! isset( $_POST['option_page'] ) || ! ( $option_page = esc_attr( $_POST['option_page'] ) ) )
			return $input;

		// check data
		if ( ! isset( $_POST['responsive_lightbox_licenses'] ) || ! is_array( $_POST['responsive_lightbox_licenses']  ))
			return $input;

		$extensions = apply_filters( 'rl_settings_licenses', array() );

		if ( empty( $extensions ) )
			return $input;

		// save settings
		if ( isset( $_POST['save_rl_licenses'] ) ) {
			$licenses = get_option( 'responsive_lightbox_licenses' );
			$statuses = array( 'updated' => 0, 'error' => 0 );

			foreach ( $extensions as $extension ) {
				if ( ! isset( $_POST['responsive_lightbox_licenses'][$extension['id']] ) )
					continue;

				$license = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['responsive_lightbox_licenses'][$extension['id']]['license'] );
				$status = ! empty( $licenses ) && ! empty( $licenses[$extension['id']]['status'] ) ? true : false;

				// request data
				$request_args = array(
					'action'		=> 'activate_license',
					'license'		=> trim( $license ),
					'item_name'		=> $extension['item_name']
				);

				// request
				$response = $this->license_request( $request_args );

				// validate request
				if ( is_wp_error( $response ) ) {
					$input[$extension['id']['status']] = false;
					$statuses['error']++;
				} else {
					// decode the license data
					$license_data = json_decode( wp_remote_retrieve_body( $response ) );

					// assign the data
					if ( $license_data->license == 'valid' ) {
						$input[$extension['id']]['status'] = true;

						if ( $status === false )
							$statuses['updated']++;
					} else {
						$input[$extension['id']]['status'] = false;
						$statuses['error']++;
					}
				}
			}
			
			// success notice
			if ( $statuses['updated'] > 0 )
				add_settings_error( 'rl_licenses_settings', 'license_activated', sprintf( _n( '%s license successfully activated.', '%s licenses successfully activated.', (int) $statuses['updated'], 'responsive-lightbox' ), (int) $statuses['updated'] ), 'updated' );

			// failed notice
			if ( $statuses['error'] > 0 )
				add_settings_error( 'rl_licenses_settings', 'license_activation_failed', sprintf( _n( '%s license activation failed.', '%s licenses activation failed.', (int) $statuses['error'], 'responsive-lightbox' ), (int) $statuses['error'] ), 'error' );
		} elseif ( isset( $_POST['reset_rl_licenses'] ) ) {
			$licenses = get_option( 'responsive_lightbox_licenses' );
			$statuses = array( 'updated' => 0, 'error' => 0 );
			
			foreach ( $extensions as $extension ) {
				$license = ! empty( $licenses ) && isset( $licenses[$extension['id']]['license'] ) ? $licenses[$extension['id']]['license'] : '';
				$status = ! empty( $licenses ) && ! empty( $licenses[$extension['id']]['status'] ) ? true : false;

				if ( $status === true || ( $status === false && ! empty( $license ) ) ) {	
					// request data
					$request_args = array(
						'action'		=> 'deactivate_license',
						'license'		=> trim( $license ),
						'item_name'		=> $extension['item_name']
					);

					// request
					$response = $this->license_request( $request_args );

					// validate request
					if ( is_wp_error( $response ) )
						$statuses['error']++;
					else {
						// decode the license data
						$license_data = json_decode( wp_remote_retrieve_body( $response ) );

						// assign the data
						if ( $license_data->license == 'deactivated' ) {
							$input[$extension['id']]['license'] = '';
							$input[$extension['id']]['status'] = false;
							$statuses['updated']++;
						} else
							$statuses['error']++;
					}
				}
			}

			// success notice
			if ( $statuses['updated'] > 0 )
				add_settings_error( 'rl_licenses_settings', 'license_deactivated', sprintf( _n( '%s license successfully deactivated.', '%s licenses successfully deactivated.', (int) $statuses['updated'], 'responsive-lightbox' ), (int) $statuses['updated'] ), 'updated' );

			// failed notice
			if ( $statuses['error'] > 0 )
				add_settings_error( 'rl_licenses_settings', 'license_deactivation_failed', sprintf( _n( '%s license deactivation failed.', '%s licenses deactivation failed.', (int) $statuses['error'], 'responsive-lightbox' ), (int) $statuses['error'] ), 'error' );
		}

		return $input;
	}

	/**
	 * License request function.
	 *
	 * @param array $args
	 * @return mixed
	 */
	private function license_request( $args ) {
		// data to send in our API request
		$api_params = array(
			'edd_action'	=> $args['action'],
			'license'		=> $args['license'],
			'item_name'		=> urlencode( $args['item_name'] ),
			// 'item_id'		=> $args['item_id'],
			'url'			=> home_url(),
			'timeout'		=> 60,
			'sslverify'		=> false
		);

		// call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, $this->api_url ) );

		return $response;
	}
}