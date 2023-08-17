<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Comments;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CommentsUserAgent extends Sweeper {
	protected $_code = 'comments-user-agent';
	protected $_category = 'comments';
	protected $_days_to_keep = 0;
	protected $_affected_tables = array(
		'comments',
	);

	protected $_flag_quick_cleanup = false;
	protected $_flag_scheduled_cleanup = false;
	protected $_flag_auto_cleanup = false;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_comments-ua', 'sweepers', 14 );
	}

	public static function instance() : CommentsUserAgent {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new CommentsUserAgent();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Comments User Agents", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove user agent information stored with every comment.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "User Agent is stored with every comment (if available).", "sweeppress" ),
			__( "User Agent is rarely used after initial comment creation and it can take a lot of space, based on number of comments.", "sweeppress" ),
			__( "This sweeper removes value from column 'comment_agent' in 'comments' database table.", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep user agent in comments from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used for scheduled jobs and it is not available from the Dashboard for Quick or Auto Sweep.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Comments::instance()->comments_ua_status( $this->_days_to_keep ),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->comments_user_agent( $this->_days_to_keep );

		return $this->base_sweep( $removal );
	}
}
