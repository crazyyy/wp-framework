<?php
	/**
	 * Admin page class
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package factory-core
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('Wbcr_FactoryPages410_Page') ) {

		class Wbcr_FactoryPages410_Page {

			/**
			 * Page id used to call.
			 * @var string
			 */
			public $id;

			/**
			 * Current Factory Plugin.
			 * @var Wbcr_Factory409_Plugin
			 */
			public $plugin;

			/**
			 * @var string
			 */
			public $result;

			//private $default_actions = array();

			/**
			 * @param Wbcr_Factory409_Plugin $plugin
			 * @throws Exception
			 */
			public function __construct(Wbcr_Factory409_Plugin $plugin)
			{
				$this->plugin = $plugin;

				if( $plugin ) {
					$this->scripts = $this->plugin->newScriptList();
					$this->styles = $this->plugin->newStyleList();
					$this->request = $plugin->request;
				}
			}

			/*public function __call($name, $arguments) {


				if(!empty($custom_action)) {

				}

			}*/

			public function assets($scripts, $styles)
			{
			}

			/**
			 * Shows page.
			 */
			public function show()
			{

				if( $this->result ) {
					echo $this->result;
				} else {
					$action = isset($_GET['action']) ? $_GET['action'] : 'index';
					$this->executeByName($action);
				}
			}

			/**
			 * @param string $action
			 * @throws Exception
			 */
			public function executeByName($action)
			{
				$raw_action_name = $action;

				if( preg_match('/[-_]+/', $action) ) {
					$action = $this->dashesToCamelCase($action, false);
				}
				$actionFunction = $action . 'Action';

				$cancel = $this->OnActionExecuting($action);

				if( $cancel === false ) {
					return;
				}

				if( !method_exists($this, $actionFunction) ) {
					// todo: продумать и доработать выполнение произвольных и глобальных дейтсвия для всех страниц
					/*$custom_actions = apply_filters('wbcr/factory_pages_410/custom_actions', array(), $raw_action_name);

					if(isset($custom_actions[$raw_action_name])) {
						$custom_actions[$raw_action_name]();
						$this->OnActionExected($action);
						return;
					} else {*/
					$actionFunction = 'indexAction';
					//}
				}

				call_user_func_array(array($this, $actionFunction), array());
				$this->OnActionExected($action);
			}

			/**
			 * @param string $string
			 * @param bool $capitalizeFirstCharacter
			 * @return mixed
			 * @throws Exception
			 */
			protected function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
			{
				$str = str_replace(' ', '', ucwords(preg_replace('/[-_]/', ' ', $string)));

				if( !$capitalizeFirstCharacter ) {
					$str[0] = strtolower($str[0]);
				}

				if( empty($str) ) {
					throw new Exception('Dashed to camelcase parse error.');
				}

				return $str;
			}

			/**
			 * @param $action
			 * @return bool
			 */
			protected function OnActionExecuting($action)
			{
			}

			protected function OnActionExected($action)
			{
			}

			/**
			 * @param $path
			 */
			protected function script($path)
			{
				wp_enqueue_script($path, $path, array('jquery'), false, true);
			}
		}
	}