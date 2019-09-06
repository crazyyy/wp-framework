<?php
	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WCL_PerformanceGooglePage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "performance_google";

		/**
		 * @var string
		 */
		public $page_parent_page = 'performance';

		/**
		 * @var string
		 */
		public $page_menu_dashicon = 'dashicons-performance';

		/**
		 * @var int
		 */
		public $page_menu_position = 20;
		
		public $available_for_multisite = true;

		/**
		 * @param WCL_Plugin $plugin
		 */
		public function __construct(WCL_Plugin $plugin)
		{
			$this->menu_title = __('Google services', 'clearfy');

			parent::__construct($plugin);

			$this->plugin = $plugin;
		}

		public function afterFormSave()
		{
			$ga_cache = $this->getPopulateOption('ga_cache');
			$ga_caos_remove_wp_cron = $this->getPopulateOption('ga_caos_remove_wp_cron');

			if( $ga_cache ) {
				if( !$ga_caos_remove_wp_cron ) {
					if( !wp_next_scheduled('wbcr_clearfy_update_local_ga') ) {
						wp_schedule_event(time(), 'daily', 'wbcr_clearfy_update_local_ga');
					}

					return;
				}
			}

			if( (!$ga_cache || $ga_caos_remove_wp_cron) && wp_next_scheduled('wbcr_clearfy_update_local_ga') ) {
				wp_clear_scheduled_hook('wbcr_clearfy_update_local_ga');
			}
		}

		/**
		 * Permalinks options.
		 *
		 * @since 1.0.0
		 * @return mixed[]
		 */
		public function getPageOptions()
		{
			$options = array();

			$options[] = array(
				'type' => 'html',
				'html' => '<div class="wbcr-factory-page-group-header">' . __('<strong>Fonts and Maps</strong>.', 'clearfy') . '<p>' . __('Google Fonts and Maps strongly affect your website loading speed. Use settings below to disable or optimize Google fonts and Maps.', 'clearfy') . '</p></div>'
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'lazy_load_google_fonts',
				'title' => __('Google Fonts asynchronous', 'clearfy'),
				'layout' => array('hint-type' => 'icon'),
				'hint' => __('By default, WordPress loads Google fonts synchronously, that is, your page will not be fully loaded until Google Fonts are loaded. This algorithm slows down the loading of your page and leads to errors when checking the site in Google Page Speed. Using this option, your Google Fonts will be loaded after your page is fully loaded. This method has a negative — you and visitors of your site will see how the font changes while loading a page, from the system to the downloadable one.', 'clearfy'),
				'default' => false
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'disable_google_fonts',
				'title' => __('Disable Google Fonts', 'clearfy'),
				'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
				'hint' => __('This function stops loading of Open Sans and other fonts used by WordPress and bundled themes (Twenty Twelve, Twenty Thirteen, Twenty Fourteen, Twenty Fifteen, Twenty Sixteen, Twenty Seventeen) from Google Fonts.
Reasons for not using Google Fonts might be privacy and security, local development or production, blocking of Google’s servers, characters not supported by font, performance.', 'clearfy'),
				'default' => false
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'disable_google_maps',
				'title' => __('Disable Google maps', 'clearfy'),
				'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
				'hint' => __('This function stops loading of Google Maps used by some themes or plugins.
Reasons for not using Google Maps might be privacy and security, local development or production, blocking of Google’s servers, performance, not necessary, etc.', 'clearfy'),
				'default' => false,
				'eventsOn' => array(
					'show' => '.factory-control-exclude_from_disable_google_maps,.factory-control-remove_iframe_google_maps'
				),
				'eventsOff' => array(
					'hide' => '.factory-control-exclude_from_disable_google_maps,.factory-control-remove_iframe_google_maps'
				)
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'remove_iframe_google_maps',
				'title' => __('Remove iframe Google maps', 'clearfy'),
				'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
				'hint' => __('By default, the "Disable Google Maps" option removes maps inserted with the SCRIPT tag from the page source code. However, you can also cut out all maps inserted via the iframe by enabling this option.', 'clearfy'),
				'default' => false
			);

			$options[] = array(
				'type' => 'textbox',
				'way' => 'buttons',
				'name' => 'exclude_from_disable_google_maps',
				'title' => __('Exclude pages from Disable Google Maps filter', 'clearfy'),
				'hint' => __('Posts or Pages IDs separated by a ,', 'clearfy')
			);

			$form_options = array();

			$form_options[] = array(
				'type' => 'form-group',
				'items' => $options,
				//'cssClass' => 'postbox'
			);

			return apply_filters('wbcr_clr_google_performance_form_options', $form_options, $this);
		}
	}
