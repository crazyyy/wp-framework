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

	require_once WCL_PLUGIN_DIR . '/admin/includes/classes/class.install-plugins-button.php';

	class WCL_DeletePluginsButton extends WCL_InstallPluginsButton {

		/**
		 * @throws Exception
		 */
		protected function buildWordpress()
		{
			parent::buildWordpress();

			$this->action = 'delete';
			$this->addData('plugin-action', $this->action);
			$this->removeClass('button-primary');
		}

		protected function buildInternal()
		{
			// nothing
		}

		/**
		 * @throws Exception
		 */
		protected function buildFreemius()
		{
			parent::buildFreemius();
			$this->action = 'delete';
			$this->addData('plugin-action', $this->action);
			$this->removeClass('button-primary');
		}

		/**
		 * @param bool $echo
		 * @return string|void
		 */
		public function getButton()
		{
			$button = '<a href="#" class="' . implode(' ', $this->getClasses()) . '" ' . implode(' ', $this->getData()) . '><span class="dashicons dashicons-trash"></span></a>';

			if( $this->type == 'freemius' || $this->type == 'internal' || !$this->isPluginInstall() || $this->isPluginActivate() ) {
				$button = '';
			}

			return $button;
		}
	}

