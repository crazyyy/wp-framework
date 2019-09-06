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
	
	class WUPM_AdvancedPage extends Wbcr_FactoryClearfy206_PageBase {
		
		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "updates_advanced";
		
		public $type = "page";
		
		public $page_parent_page = 'updates';
		
		public $page_menu_dashicon = 'dashicons-cloud';

		/**
		 * Доступена для мультисайтов
		 * @var bool
		 */
		public $available_for_multisite = true;
		
		/**
		 * @param Wbcr_Factory409_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory409_Plugin $plugin)
		{
			$this->menu_title = __('Advanced', 'webcraftic-updates-manager');
			
			parent::__construct($plugin);
		}

		/**
		 * Requests assets (js and css) for the page.
		 *
		 * @see Wbcr_FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function assets($scripts, $styles)
		{
			parent::assets($scripts, $styles);

			// Add Clearfy styles for HMWP pages
			if( defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
				$this->styles->add(WCL_PLUGIN_URL . '/admin/assets/css/general.css');
			}
		}
		
		public function warningNotice()
		{
			parent::warningNotice();
			
			if( isset($_GET['wbcr_force_update']) ) {
				$concat = __('Please, wait 90 sec. to see the forced automatic update result.', 'webcraftic-updates-manager') . '<br>';
				
				$this->printWarningNotice($concat);
			}
		}
		
		public function showPageContent()
		{
			?>
			<div style="padding: 20px;">
				<h4><?php _e('Force Automatic Updates', 'webcraftic-updates-manager'); ?></h4>
				
				<p><?php _e('This will attempt to force automatic updates. This is useful for debugging.', 'webcraftic-updates-manager'); ?></p>
				<a href="<?php $this->actionUrl('force-plugins-update') ?>" class="button button-default"><?php _e('Force update', 'webcraftic-updates-manager'); ?></a>
			</div>
		
		<?php
		}
		
		public function forcePluginsUpdateAction()
		{
			if( !current_user_can('install_plugins') ) {
				return;
			}

			$shedule_auto_update = function() {
				wp_schedule_single_event(time() + 10, 'wp_update_plugins');
				wp_schedule_single_event(time() + 10, 'wp_version_check');
				wp_schedule_single_event(time() + 10, 'wp_update_themes');
				wp_schedule_single_event(time() + 45, 'wp_maybe_auto_update');

				if( get_option('auto_updater.lock', false) ) {
					update_option('auto_updater.lock', time() - HOUR_IN_SECONDS * 2);
				}
            };

			if ( WUPM_Plugin::app()->isNetworkAdmin() ) {
				foreach ( WUPM_Plugin::app()->getActiveSites() as $site ) {
					switch_to_blog( $site->blog_id );

					$shedule_auto_update();

					restore_current_blog();
			    }
            }
			else {
				$shedule_auto_update();
            }
			
			$this->redirectToAction('index', array('wbcr_force_update' => 1));
		}
	}

