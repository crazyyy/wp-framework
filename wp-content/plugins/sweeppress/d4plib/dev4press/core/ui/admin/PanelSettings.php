<?php

namespace Dev4Press\v42\Core\UI\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class PanelSettings extends Panel {
	protected $form = true;
	protected $form_multiform = true;

	public $settings_class = '';

	public function __construct( $admin ) {
		parent::__construct( $admin );

		$this->init_default_subpanels();
	}

	protected function init_default_subpanels() {
		$this->subpanels = array(
			'index' => array(
				'title' => __( "Settings Index", "d4plib" ),
				'icon'  => 'ui-cog',
				'info'  => __( "All plugin settings are split into several panels, and you access each starting from the right.", "d4plib" )
			),
			'full'  => array(
				'title' => __( "All Settings", "d4plib" ),
				'icon'  => 'ui-cogs',
				'info'  => __( "All plugin settings are displayed on this page, and you can use live search to find the settings you need.", "d4plib" )
			)
		);
	}

	public function settings_fields() {
		$group  = $this->a()->plugin . '-settings';
		$action = $this->a()->v();

		echo "<input type='hidden' name='option_page' value='" . esc_attr( $group ) . "' />";
		echo "<input type='hidden' name='action' value='update' />";
		echo "<input type='hidden' name='" . esc_attr( $action ) . "' value='postback' />";

		wp_nonce_field( $group . '-options' );
	}

	public function enqueue_scripts_early() {
		$this->a()->enqueue->js( 'mark' )->js( 'confirmsubmit' );
	}
}
