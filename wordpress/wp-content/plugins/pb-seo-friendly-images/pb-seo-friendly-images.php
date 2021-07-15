<?php
/*
Plugin Name: PB SEO Friendly Images
Plugin URI: https://wordpress.org/extend/plugins/pb-seo-friendly-images/
Description: This plugin is a full-featured solution for SEO friendly images. Optimize "alt" and "title" attributes for all images and post thumbnails. This plugin helps you to improve your traffic from search engines.
Version: 4.0.4
Author: Pascal Bajorat
Author URI: https://www.bajorat-media.com
Text Domain: pb-seo-friendly-images
Domain Path: /lang
License: GNU General Public License v.3 and Commercial for Pro-Parts

Copyright (c) 2020 by Bajorat-Media.com.
*/

/* Security-Check */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('pbSEOFriendlyImages') ):

	class pbSEOFriendlyImages
	{
		/** @var string Plugin version */
		var $version = '4.0.4';

		/** @var string DB version */
		var $db_version = '4.0.0';

		/** @var array Plugin Settings */
		var $settings = array();

		/** @var array Plugin Data */
		var $plugin = array();

		/** @var string URL to Pro-Version Landingpage */
		var $proURL = 'https://goo.gl/0SV2EU';

		/** @var string URL to Pro-Version Cart */
		var $proURL2 = 'https://goo.gl/D5YWDj';

		/** @var string option name */
		var $option_name = 'pb-seo-friendly-images';

		/** @var string option name for db version */
		var $option_name_dbv = 'pb-seo-friendly-images-dbv';

		/** @var bool Pro-Version */
		protected $proVersion = false;

		/** @var string path to pro file  */
		protected $proPath;

		/**
		 * Check if Version is Pro (Getter)
		 *
		 * @return bool
		 */
		public function isProVersion() {
			return $this->proVersion;
		}

		/**
		 * Initialize PB SEO Friendly Images
		 * @return void
		 */
		public function initialize()
		{
			// Plugin Default Data
			$this->plugin = array(
				// basic
				'name'				=> __('PB SEO Friendly Images', 'pb-seo-friendly-images'),
				'version'			=> $this->version,

				// urls
				'file'				=> __FILE__,
				'basename'			=> plugin_basename( __FILE__ ),
				'path'				=> plugin_dir_path( __FILE__ ),
				'url'				=> plugin_dir_url( __FILE__ ),
			);

			// Default settings
			$this->settings = array(

			);

			// load plugin textdomain
			$this->load_plugin_textdomain();

			// load settings
			$this->load_settings();

			// pro path
			$this->proPath = $this->plugin['path'] . 'inc/pbsfi_pro.php';

			// check if this is pro version and initialize pro class
			if( true === file_exists($this->proPath) ) {

				// set to true
				$this->proVersion               = true;
                $this->settings['proVersion']   = true;

				// load pro class + extend and manipulate basic version
				new pbsfi_pro( $this );

			} else {
                $this->settings['proVersion']   = false;
            }

			// admin bar and post_update is for front- and backend
            if( isset($this->settings['enable_caching']) && $this->settings['enable_caching'] == true ) {
                add_action('admin_bar_menu', [ $this, 'admin_bar_menu' ], 999);
                add_action('post_updated', [ $this, 'clear_cache_for_post' ], 10, 3);
            }

            try {
                new pbcockpitnotice([
                    'logo'              => plugins_url(dirname($this->plugin['basename'])).'/assets/img/bajorat-media-white.svg',
                    'link_de'           => 'https://cockpit.bajorat-media.com/infos/?utm_source=pb-seo-friendly-images&utm_medium=banner&utm_campaign=pb-seo-friendly-images',
                    'link_en'           => 'https://cockpit.bajorat-media.com/en/infos/?utm_source=pb-seo-friendly-images&utm_medium=banner&utm_campaign=pb-seo-friendly-images',
                    'allowed_screens'   => array('settings_page_pb-seo-friendly-images'),
                    'only_on_screens'   => true, // $this->settings['proVersion']
                    'close_on_screens'  => $this->settings['proVersion']
                ]);
            } catch (Exception $e) {}

			if( is_admin() ) {

				// initialize admin
				$this->initialize_admin();

			} else {

				// initialize frontend
				$this->initialize_frontend();

			}
		}

		/**
		 * Load Plugin Textdomain
		 * @return void
		 */
		public function load_plugin_textdomain()
		{
			load_plugin_textdomain(
				'pb-seo-friendly-images',
				false,
				dirname( $this->plugin['basename'] ).'/lang/'
			);
		}

		/**
		 * Load Plugin Settings from Options and maybe convert from older Versions
		 * @return void
		 */
		public function load_settings()
		{
			$settings_from_option = get_option($this->option_name);

			if( false === $settings_from_option ) {
				// convert old settings from version previous 4.0.0
				$pbsfi_upgrade = new pbsfi_upgrade( $this );

				if( true === $pbsfi_upgrade->maybe_do_upgrade() ) {
					$settings_from_option = get_option($this->option_name);
				}
			}

			if( is_array($settings_from_option) ) {

				$this->settings = array_merge(
					$this->settings,
					$settings_from_option
				);

			}

		}

		/**
		 * initialize admin functions
		 * @return void
		 */
		public function initialize_admin()
		{
			$admin = new pbsfi_admin_interface( $this );
			$admin->initialize();
		}

		/**
		 * initialize frontend functions
		 * @return void
		 */
		public function initialize_frontend()
		{
			$frontend = new pbsfi_frontend( $this );

			add_action('template_redirect', array($frontend, 'initialize'));
		}

        /**
         * AdminBar Menu for Cache
         */
        public function admin_bar_menu()
        {
            global $wp_admin_bar;

            $menu_id = 'pbsfi';

            $wp_admin_bar->add_menu(array(
                'id' => $menu_id,
                'title' => __('Clear Cache', 'pb-seo-friendly-images'),
                'href' => admin_url('options-general.php?page=pb-seo-friendly-images&clear_cache=true')
            ));
        }

        public function clear_cache_for_post($post_ID, $post_after, $post_before)
        {
            $cache = new pbsfi_cache();
            $cache->clear_post_cache( $post_ID );
        }

		/**
		 * Uninstall PB SEO Friendly Images
		 * @return void
		 */
		public static function uninstall()
		{
			/* Global */
			/** @var wpdb $wpdb */
			global $wpdb;

			/** @var pbSEOFriendlyImages $pbSEOFriendlyImages */
            $pbSEOFriendlyImages = new self();

			/* Remove settings */
			delete_option($pbSEOFriendlyImages->option_name);

			/* Clean DB */
			$wpdb->query("OPTIMIZE TABLE `" .$wpdb->options. "`");
		}
	} /* end of pbSEOFriendlyImages */

	/**
	 * Initialize pbSEOFriendlyImages Class
	 */
	$pbSEOFriendlyImages = new pbSEOFriendlyImages();

	/**
	 * Trigger plugins_loaded hook with method pbSEOFriendlyImages->initialize()
	 */
	add_action(
		'plugins_loaded',
		array(
			$pbSEOFriendlyImages,
			'initialize'
		)
	);

	/**
	 * Register uninstall hook
	 */
	register_uninstall_hook(
		__FILE__,
		array(
			'pbSEOFriendlyImages',
			'uninstall'
		)
	);

endif;

/**
 * Autoloader function
 *
 * @param $class
 *
 * @return WP_Error
 */

if( ! function_exists('pbSEOFriendlyImagesAutoload') ) {

    function pbSEOFriendlyImagesAutoload($class)
    {
        $allowed_classes = array(
            'pbSettingsFramework_2',
            'pbsfi_admin_interface',
            'pbsfi_frontend',
            'pbsfi_optimizer',
            'pbsfi_pro',
            'pbsfi_upgrade',
            'pbsfi_cache',
            'pbcockpitnotice'
        );

        if( 'Puc_v4_Factory' == $class ) {

            $require_once = sprintf(
                '%s/plugin-update-checker/plugin-update-checker.php',

                dirname(__FILE__)
            );

            if( file_exists($require_once) ) {
                require_once( $require_once );
            }


        } elseif( in_array($class, $allowed_classes) ) {

            $require_once = sprintf(
                '%s/inc/%s.php',

                dirname(__FILE__),
                $class
            );

            if( file_exists( $require_once ) ) {
                require_once( $require_once );
            } else {
                return new WP_Error(
                    'broke',
                    sprintf(
                        esc_html__( 'Can not find: %s', 'pb-seo-friendly-images' ),
                        $require_once
                    )
                );
            }
        }
    }

    /* Autoload Init */
    spl_autoload_register('pbSEOFriendlyImagesAutoload');

}
