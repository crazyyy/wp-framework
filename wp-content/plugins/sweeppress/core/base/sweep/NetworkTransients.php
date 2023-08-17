<?php

namespace Dev4Press\Plugin\SweepPress\Base\Sweep;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class NetworkTransients extends Sweeper {
	protected $_scope = 'network';
	protected $_category = 'network';
	protected $_affected_tables = array(
		'sitemeta',
	);

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
		);

		$task = $this->get_task();

		$deleted = 0;
		if ( ! SWEEPPRESS_SIMULATION ) {
			foreach ( $task['transients'] as $transient ) {
				if ( delete_site_option( '_site_transient_' . $transient ) ) {
					$deleted ++;
				}

				if ( delete_site_option( '_site_transient_timeout_' . $transient ) ) {
					$deleted ++;
				}
			}
		} else {
			$deleted ++;
		}

		$results['tasks'][ $this->_code ] = $task['title'];

		if ( $deleted > 0 ) {
			$results['records'] = $task['records'];
			$results['size']    = $task['size'];
		}

		return $results;
	}
}
