<?php

namespace Dev4Press\Plugin\SweepPress\Admin\Panel;

use Dev4Press\v42\Core\UI\Admin\PanelSettings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings extends PanelSettings {
	public $settings_class = '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Settings';

	public function __construct( $admin ) {
		parent::__construct( $admin );

		$this->subpanels = $this->subpanels + array(
				'expand'   => array(
					'title' => __( "Expand", "sweeppress" ),
					'icon'  => 'ui-puzzle',
					'info'  => __( "Expand the plugin with additional and optional features.", "sweeppress" ),
				),
				'sweepers' => array(
					'title' => __( "Sweepers", "sweeppress" ),
					'icon'  => 'ui-trash',
					'info'  => __( "Options to control some of the plugin sweepers.", "sweeppress" ),
				),
				'performance' => array(
					'title' => __( "Performance", "sweeppress" ),
					'icon'  => 'ui-sun',
					'info'  => __( "Options to various performance related options.", "sweeppress" ),
				),
				'advanced' => array(
					'title' => __( "Advanced", "sweeppress" ),
					'icon'  => 'ui-toolbox',
					'info'  => __( "Additional options for more control over the plugin.", "sweeppress" ),
				),
			);

		$this->subpanels = apply_filters( 'sweeppress_admin_settings_panels', $this->subpanels );
	}
}
