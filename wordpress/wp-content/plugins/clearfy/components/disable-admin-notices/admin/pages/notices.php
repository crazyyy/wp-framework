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

	class WDN_NoticesPage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "notices";
		public $page_menu_dashicon = 'dashicons-testimonial';
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
			$this->menu_title = __('Hide admin notices', 'disable-admin-notices');

			if( !defined('LOADING_DISABLE_ADMIN_NOTICES_AS_ADDON') ) {
				$this->internal = false;
				$this->menu_target = 'options-general.php';
				$this->add_link_to_plugin_actions = true;
			}

			parent::__construct($plugin);

			$this->plugin = $plugin;
		}

		public function getMenuTitle()
		{
			return defined('LOADING_DISABLE_ADMIN_NOTICES_AS_ADDON')
				? __('Notices', 'disable-admin-notices')
				: __('General', 'disable-admin-notices');
		}

		/**
		 * We register notifications for some actions
		 * @param array $notices
		 * @param Wbcr_Factory409_Plugin $plugin
		 * @return array
		 */
		public function actionsNotice($notices)
		{
			$notices[] = array(
				'conditions' => array(
					'wbcr_dan_reseted_notices' => 1
				),
				'type' => 'success',
				'message' => __('Hidden notices are successfully reset, now you can see them again!', 'disable-admin-notices')
			);

			/*$notices[] = array(
				'conditions' => array(
					'wbcr_dan_clear_comments_error' => 1,
					'wbcr_dan_code' => 'interal_error'
				),
				'type' => 'danger',
				'message' => __('An error occurred while trying to delete comments. Internal error occured. Please try again later.', 'factory_pages_410')
			);*/

			return $notices;
		}

		/**
		 * Permalinks options.
		 *
		 * @since 1.0.0
		 * @return mixed[]
		 */
		public function getPopulateOptions()
		{
			$options = wbcr_dan_get_plugin_options();

			$formOptions = array();

			$formOptions[] = array(
				'type' => 'form-group',
				'items' => $options,
				//'cssClass' => 'postbox'
			);

			return apply_filters('wbcr_dan_notices_form_options', $formOptions, $this);
		}
	}