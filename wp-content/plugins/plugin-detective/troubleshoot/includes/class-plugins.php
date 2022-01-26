<?php
/**
 * Troubleshoot Plugins.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Plugins.
 *
 * @since 0.0.0
 */
class PDT_Plugins {
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
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {
		
	}

	public function set_active( $plugins ) {
		update_option( 'pdt_tmp_active_plugins_backup', get_option( 'active_plugins' ) );
		update_option( 'active_plugins', $plugins );

		return true;
	}


	public function activate( $args=array() ) {
		$args['plugins'] = (array)$args['plugins'];
		if ( empty( $args['plugins'] ) ) {
			return false;
		}

		$plugins = (array)$args['plugins'];
		$active_plugins = get_option( 'active_plugins', array() );

		$this->plugin->plugins->set_active( array_values( array_unique( array_merge( $active_plugins, $plugins ) ) ) );

		return true;
	}


	public function deactivate( $args=array() ) {
		$args['plugins'] = (array)$args['plugins'];
		if ( empty( $args['plugins'] ) ) {
			return false;
		}

		$plugins = (array)$args['plugins'];
		$active_plugins = get_option( 'active_plugins', array() );

		$this->plugin->plugins->set_active( array_values( array_unique( array_diff( $active_plugins, $plugins ) ) ) );

		return true;
	}

}
