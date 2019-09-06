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

	class WCL_QuickStartPage extends Wbcr_FactoryClearfy206_PageBase {
		
		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "quick_start";

		/**
		 * @var string
		 */
		public $page_menu_dashicon = 'dashicons-clock';

		/**
		 * @var int
		 */
		public $page_menu_position = 100;

		/**
		 * @var bool
		 */
		public $internal = false;

		/**
		 * @var string
		 */
		public $menu_target = 'options-general.php';

		/**
		 * @var string
		 */
		public $type = 'page';

		/**
		 * @var bool
		 */
		public $add_link_to_plugin_actions = true;


		public $available_for_multisite = true;


		/**
		 * @param WCL_Plugin $plugin
		 */
		public function __construct(WCL_Plugin $plugin)
		{
			$this->menu_title = __('Clearfy menu', 'clearfy');
			$this->page_menu_short_description = __('One-click settings', 'clearfy');
			
			parent::__construct($plugin);

			$this->plugin = $plugin;
		}
		
		public function getPageTitle()
		{
			return __('Quick start', 'clearfy');
		}
		
		/**
		 * Requests assets (js and css) for the page.
		 *
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function assets($scripts, $styles)
		{
			parent::assets($scripts, $styles);
			
			$this->scripts->add(WCL_PLUGIN_URL . '/admin/assets/js/general.js');

			/**
			 * Подгружаем стили для вижета оптимизации изображений, если не установли плагин оптимизации изображений
			 */
			if( !defined('WIO_PLUGIN_ACTIVE') ) {
				$styles->add(WCL_PLUGIN_URL . '/admin/assets/css/base-statistic.css');
			}

			$params = array(
				//'ajaxurl' => admin_url('admin-ajax.php'),
				'flush_cache_url' => $this->getActionUrl('flush-cache-and-rules', array('_wpnonce' => wp_create_nonce('wbcr_factory_' . $this->getResultId() . '_flush_action'))),
				'ajax_nonce' => wp_create_nonce('wbcr_clearfy_ajax_quick_start_nonce'),
				'i18n' => array(
					'success_update_settings' => __('Settings successfully updated!', 'clearfy'),
					'unknown_error' => __('During the setup, an unknown error occurred, please try again or contact the plugin support.', 'clearfy')
				)
			);

			wp_localize_script('jquery', 'wbcr_clearfy_ajax', $params);
		}
		
		/**
		 * Shows the description above the options.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function _showHeader()
		{
			?>
			<div class="wbcr-clearfy-header">
				<?php _e('On this page you can quickly configure the plug-in without going into details.', 'clearfy') ?>
			</div>
		<?php
		}

		public function showPageContent()
		{
			$allow_mods = apply_filters('wbcr_clearfy_allow_quick_mods', array(
				'clear_code' => array('title' => __('One click code clearing', 'clearfy'), 'icon' => 'dashicons-yes'),
				'defence' => array('title' => __('One click security', 'clearfy'), 'icon' => 'dashicons-shield'),
				'seo_optimize' => array(
					'title' => __('One click seo optimization', 'clearfy'),
					'icon' => 'dashicons-star-empty'
				),
				'remove_default_widgets' => array(
					'title' => __('One click remove default Widgets', 'clearfy'),
					'icon' => 'dashicons-networking'
				),
			));

			if( !$this->plugin->isActivateComponent('widget_tools') ) {
				unset($allow_mods['remove_default_widgets']);
			}

			$allow_mods['reset'] = array(
				'title' => __('Reset all settings', 'clearfy'),
				'icon' => 'dashicons-backup',
				'args' => array('flush_redirect' => 1)
			);
			?>
			<div class="wbcr-clearfy-confirm-popup">
				<h3><?php _e('Are you sure you want to enable the this options?', 'clearfy') ?></h3>
				
				<div class="wbcr-clearfy-reset-warning-message">
					<?php _e('After confirmation, all the settings of the plug-in will return to the default state. Make backup settings by copying data from the export field.', 'clearfy') ?>
				</div>
				<ul class="wbcr-clearfy-list-options"></ul>
				<div class="wbcr-clearfy-popup-buttons">
					<button class="wbcr-clearfy-popup-button-ok"><?php _e('Confirm', 'clearfy') ?></button>
					<button class="wbcr-clearfy-popup-button-cancel"><?php _e('Cancel', 'clearfy') ?></button>
				</div>
			</div>

			<div class="wbcr-content-section">
				<div class="wbcr-factory-page-group-header" style="margin:0"><?php _e('<strong>Quick start</strong>.', 'clearfy') ?>
					<p><?php _e('These are quick optimization options for your website. You can activate the groups of necessary settings in one click. With the fast optimization mode, we are enable the only safe settings that do not break your website. That is why we recommend you to look at each setting of the plugin individually. The settings with grey and red question mark will not be active, until you do it yourself.', 'clearfy') ?></p>
				</div>

				<?php do_action('wbcr_clearfy_quick_boards'); ?>

				<div id="wbcr-clearfy-quick-mode-board">
					<h4 style="margin-top:10px;"><?php _e('Select what you need to do', 'clearfy') ?></h4>

					<p style="color:#9e9e9e"><?php _e('After selecting any optimization case, the plugin will automatically enable the necessary settings in safe mode and one click.', 'clearfy') ?></p>

					<div class="row">
						<?php foreach($allow_mods as $mode_name => $mode): ?>
							<?php
							$mode_title = $mode;
							$mode_icon = '';
							$mode_args = '';

							if( is_array($mode) ) {
								$mode_title = isset($mode['title']) ? $mode['title'] : '';
								$mode_icon = isset($mode['icon']) ? $mode['icon'] : '';
								$mode_args = isset($mode['args']) && is_array($mode['args']) ? WCL_Helper::getEscapeJson($mode['args']) : '';
							}
							?>

							<div class="col-sm-12">
								<?php
									$group = WCL_Group::getInstance($mode_name);

									$filter_mode_options = array();
									foreach($group->getOptions() as $option) {
										$filter_mode_options[$option->getName()] = $option->getTitle();
									}

									$print_group_options = WCL_Helper::getEscapeJson($filter_mode_options);
								?>
								<?php if( $mode_name == 'reset' ): ?>
									<h4><?php _e('Reset settings', 'clearfy') ?></h4>
									<p style="color:#9e9e9e"><?php _e('After confirmation, all the settings of the plug-in will return to the default state. Make backup settings by copying data from the export field.', 'clearfy') ?></p>

								<?php endif; ?>
								<div class="wbcr-clearfy-switch wbcr-clearfy-switch-mode-<?= $mode_name ?>" data-mode="<?= $mode_name ?>" data-mode-args="<?= $mode_args ?>" data-mode-options="<?= $print_group_options ?>">
									<?php if( !empty($mode_icon) ): ?>
										<i class="dashicons <?= $mode_icon; ?>"></i>
									<?php endif; ?>
									<span><?= $mode_title ?></span>

									<div class="wbcr-clearfy-switch-confirmation">
										<button class="wbcr-clearfy-button-activate-mode">
											<?php if( $mode_name == 'reset' ): ?>
												<?php _e('Reset', 'clearfy'); ?>
											<?php else: ?>
												<?php _e('Do It!', 'clearfy'); ?>
											<?php endif; ?>
										</button>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php
		}
	}
