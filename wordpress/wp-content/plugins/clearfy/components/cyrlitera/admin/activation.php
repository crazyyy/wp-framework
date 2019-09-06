<?php

	/**
	 * Activator for the cyrlitera
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 09.03.2018, Webcraftic
	 * @see Wbcr_Factory409_Activator
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WCTR_Activation extends Wbcr_Factory409_Activator {

		/**
		 * Runs activation actions.
		 *
		 * @since 1.0.0
		 */
		public function activate()
		{
			WCTR_Plugin::app()->updatePopulateOption('use_transliteration', 1);
			WCTR_Plugin::app()->updatePopulateOption('use_transliteration_filename', 1);
			WCTR_Plugin::app()->updatePopulateOption('filename_to_lowercase', 1);
		}
	}
