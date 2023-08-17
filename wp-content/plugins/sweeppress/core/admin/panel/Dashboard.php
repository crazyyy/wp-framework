<?php

namespace Dev4Press\Plugin\SweepPress\Admin\Panel;

use Dev4Press\v42\Core\UI\Admin\PanelDashboard;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Dashboard extends PanelDashboard {
	public function __construct( $admin ) {
		parent::__construct( $admin );

		if ( current_user_can( 'activate_plugins' ) ) {
			$this->sidebar_links['plugin'] = array(
				'sweep' => array(
					'icon'  => $this->a()->menu_items['sweep']['icon'],
					'class' => 'button-primary',
					'url'   => $this->a()->panel_url( 'sweep' ),
					'label' => __( "Sweep", "sweeppress" ),
				),
			);
		} else {
			$this->sidebar_links['basic'] = array();
			$this->sidebar_links['about'] = array();
		}
	}

	public function show() {
		sweeppress_core()->run_dashboard();

		parent::show();
	}
}
