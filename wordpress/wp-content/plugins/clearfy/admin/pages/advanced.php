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
	
	class WCL_AdvancedPage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "advanced";

		public $page_menu_dashicon = 'dashicons-list-view';

		public $page_menu_position = 1;
		
		public $available_for_multisite = true;

		/**
		 * @param WCL_Plugin $plugin
		 */
		public function __construct(WCL_Plugin $plugin)
		{
			$this->menu_title = __('Advanced', 'clearfy');
			$this->page_menu_short_description = __('Useful tweaks', 'clearfy');

			parent::__construct($plugin);

			$this->plugin = $plugin;
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

			//============================================================
			//                 ADMINBAR MANAGER COMPONENT
			//============================================================

			if( $this->plugin->isActivateComponent('adminbar_manager') ) {
				$options[] = array(
					'type' => 'html',
					'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __('Admin bar', 'clearfy') . '</strong>' . '<p>' . __('In this group of settings, you can manage the adminbar.', 'clearfy') . '</p>' . '</div>'
				);

				$options[] = array(
					'type' => 'dropdown',
					'name' => 'disable_admin_bar',
					'way' => 'buttons',
					'title' => __('Disable admin top bar', 'clearfy'),
					'data' => array(
						array('enable', __('Default enable', 'clearfy')),
						array('for_all_users', __('For all users', 'clearfy')),
						array(
							'for_all_users_except_administrator',
							__('For all users except administrator', 'clearfy')
						)
					),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
					'hint' => __('In some cases, you need to disable the floating top admin panel. You can disable this panel.', 'clearfy') . '<br><b>Clearfy</b>: ' . __('Disable admin top bar.', 'clearfy'),
					'default' => 'enable',
				);
			}

			$formOptions = array();

			$formOptions[] = array(
				'type' => 'form-group',
				'items' => $options,
				//'cssClass' => 'postbox'
			);

			return apply_filters('wbcr_clr_additionally_form_options', $formOptions, $this);
		}
	}
