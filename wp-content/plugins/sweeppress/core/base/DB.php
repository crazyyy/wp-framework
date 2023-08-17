<?php

namespace Dev4Press\Plugin\SweepPress\Base;

use Dev4Press\v42\Core\Plugins\DB as LibDB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @property string actionscheduler_actions
 * @property string actionscheduler_claims
 * @property string actionscheduler_groups
 * @property string actionscheduler_logs
 */
abstract class DB extends LibDB {
	protected $plugin_name = 'sweeppress';
	public $internal_tables = array(
		'actionscheduler_actions',
		'actionscheduler_claims',
		'actionscheduler_groups',
		'actionscheduler_logs',
	);

	public function __get( $name ) {
		if ( in_array( $name, $this->internal_tables ) ) {
			return $this->prefix . $name;
		}

		return parent::__get( $name );
	}
}
