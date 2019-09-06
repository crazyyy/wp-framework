<?php

	/**
	 * This file groups the settings for quick setup
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 16.09.2017, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WCL_Option {

		private $name;
		private $title;
		private $values;
		private $tags;

		/**
		 * @param array $option_data
		 * @throws Exception
		 */
		public function __construct(array $option_data)
		{
			if( empty($option_data) ) {
				throw new Exception('Empty group_name attribute.');
			}

			foreach($option_data as $key => $value) {
				$this->$key = $value;
			}
		}

		/**
		 * @return mixed
		 */
		public function getName()
		{
			return $this->name;
		}

		/**
		 * @return mixed
		 */
		public function getTitle()
		{
			return $this->title;
		}

		/**
		 * @param null $group_name
		 * @return array
		 */
		public function getValue($group_name = null)
		{
			if(
				!empty($group_name)
				&& is_array($this->values)
				&& isset($this->values[$group_name])
			) {
				return $this->values[$group_name];
			}

			return !empty($this->values)
				? $this->values
				: array();
		}

		/**
		 * @return mixed
		 */
		public function getTags()
		{
			return $this->tags;
		}

		/**
		 * @param $group_name
		 * @return bool
		 */
		public function hasGroup($group_name)
		{
			if( !empty($this->tags) && in_array($group_name, $this->tags) ) {
				return true;
			}

			return false;
		}

		/**
		 * @return WCL_Option[]
		 */
		public static function getAllOptions()
		{
			$all_options = require(WCL_PLUGIN_DIR . '/admin/includes/options.php');
			$result = array();

			if( !empty($all_options) ) {
				foreach($all_options as $option_data) {
					$result[] = new WCL_Option($option_data);
				}
			}

			return $result;
		}
	}

