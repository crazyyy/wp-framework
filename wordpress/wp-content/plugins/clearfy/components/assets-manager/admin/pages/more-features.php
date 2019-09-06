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

	class WbcrGnz_MoreFeaturesPage extends Wbcr_FactoryClearfy206_MoreFeaturesPage {

		/**
		 * @var bool
		 */
		public $available_for_multisite = true;
	}