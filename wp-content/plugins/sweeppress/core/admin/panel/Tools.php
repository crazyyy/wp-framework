<?php

namespace Dev4Press\Plugin\SweepPress\Admin\Panel;

use Dev4Press\v42\Core\UI\Admin\PanelTools;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tools extends PanelTools {
	protected function init_default_subpanels() {
		parent::init_default_subpanels();

		$this->subpanels = array_slice( $this->subpanels, 0, 2 ) +
		                   array(
			                   'purge' => array(
				                   'title'        => __( "Cache Purge", "coreactivity" ),
				                   'icon'         => 'ui-trash',
				                   'method'       => 'get',
				                   'button_label' => __( "Purge", "coreactivity" ),
				                   'button_url'   => $this->a()->action_url( 'purge-cache', 'sweeppress-purge-cache' ),
				                   'info'         => __( "Using this tool, you can purge all cached data.", "coreactivity" ),
			                   ),
		                   ) +
		                   array_slice( $this->subpanels, 2 );
	}
}
