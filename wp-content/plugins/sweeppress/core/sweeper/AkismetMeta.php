<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Comments;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AkismetMeta extends Sweeper {
	protected $_code = 'akismet-meta';
	protected $_category = 'comments';
	protected $_version = '1.1';

	protected $_days_to_keep = 0;
	protected $_affected_tables = array(
		'commentmeta',
	);

	protected $_flag_quick_cleanup = false;
	protected $_flag_scheduled_cleanup = false;
	protected $_flag_auto_cleanup = false;
	protected $_flag_bulk_network = true;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_comments-akismet', 'sweepers', 14 );
	}

	public static function instance() : AkismetMeta {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new AkismetMeta();
		}

		return $instance;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s comment", "%s comments", $value, "sweeppress" );
	}

	public function title() : string {
		return __( "Akismet Meta", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove meta records stored with comments by Akismet Anti Spam plugin.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "Akismet saves multiple meta records for each comment it checks.", "sweeppress" ),
			__( "Over time, these records can take a lot of space.", "sweeppress" ),
			__( "This sweeper removes Akismet records only for approved comments.", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep Akismet meta records for comments from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used for scheduled jobs and it is not available from the Dashboard for Quick and Auto Sweep.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Comments::instance()->akismet_meta_status( $this->_days_to_keep ),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->akismet_meta_records( $this->_days_to_keep );

		return $this->base_sweep( $removal );
	}
}
