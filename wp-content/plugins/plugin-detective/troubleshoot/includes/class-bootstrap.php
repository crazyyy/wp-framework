<?php
/**
 * Troubleshoot Bootstrap.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Bootstrap.
 *
 * @since 0.0.0
 */
class PDT_Bootstrap {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   Troubleshoot
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  Troubleshoot $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		new PDT_Functions( $plugin );
		new PDT_Settings( $plugin );

		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {

	}
}
