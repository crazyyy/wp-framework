<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Database;
use Dev4Press\Plugin\SweepPress\Query\Sitemeta;
use Dev4Press\Plugin\SweepPress\Query\Users;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class InactiveSignups extends Sweeper {
	protected $_code = 'inactive-signups';
	protected $_scope = 'network';
	protected $_category = 'network';
	protected $_days_to_keep = 0;

	protected $_affected_tables = array(
		'signups',
	);

	protected $_flag_quick_cleanup = true;
	protected $_flag_scheduled_cleanup = true;
	protected $_flag_auto_cleanup = false;
	protected $_flag_monitor_task = true;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_signups-inactive', 'sweepers', 0 );
	}

	public static function instance() : InactiveSignups {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new InactiveSignups();
		}

		return $instance;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s signup", "%s signups", $value, "sweeppress" );
	}

	public function title() : string {
		return __( "Inactive User Signups", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all inactive records from the multisite user Signups database table.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Signups table is used in Multisite network, and all uer signups are stored there, before they activate their accounts.", "sweeppress" ),
			__( "If a user signs up, but never activates the account, the record remains in the Signups table forever.", "sweeppress" ),
			__( "If a user activates account, his information goes to users tables, but it remains in Signups as well, just marked as Activated.", "sweeppress" ),
			__( "If a username is logged in this table, and if the user doesn't activate the account, that username is basically no longer available for any one to use in the future.", "sweeppress" ),
			__( "Email doesn't have to be unique, so you can have multiple signup attempts with same email, but different username.", "sweeppress" ),
			__( "Depending on your website, this table can grow quite large over time.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used for auto sweeping.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Users::instance()->signups_inactive( $this->_days_to_keep ),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->signups_inactive();

		return $this->base_sweep( $removal );
	}
}
