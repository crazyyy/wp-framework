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

	class WCL_Group {

		private $group_name;

		/**
		 * @param string $group_name
		 * @throws Exception
		 */
		public function __construct($group_name)
		{
			if( empty($group_name) || !is_string($group_name) ) {
				throw new Exception('Empty group_name attribute.');
			}
			$this->group_name = $group_name;
		}

		/**
		 * @param string $group_name
		 * @return WCL_Group
		 */
		public static function getInstance($group_name)
		{
			return new WCL_Group($group_name);
		}

		/**
		 * @return string
		 */
		public function getName()
		{
			return $this->group_name;
		}

		/**
		 * @return WCL_Option[]
		 */
		public function getOptions()
		{
			$options = WCL_Option::getAllOptions();
			$filter = array();

			foreach($options as $option) {
				if( $option->hasGroup($this->group_name) ) {
					$filter[] = $option;
				}
			}

			return $filter;
		}
	}

