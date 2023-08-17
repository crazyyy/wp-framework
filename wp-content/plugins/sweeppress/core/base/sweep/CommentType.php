<?php

namespace Dev4Press\Plugin\SweepPress\Base\Sweep;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Comments;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class CommentType extends Sweeper {
	protected $_comment_type = '';
	protected $_category = 'comments';
	protected $_days_to_keep = 0;
	protected $_affected_tables = array(
		'commentmeta',
		'comments',
	);

	protected $_flag_quick_cleanup = false;
	protected $_flag_auto_cleanup = false;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_comments-' . $this->_comment_type, 'sweepers', 14 );
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used from the Dashboard for Auto Sweep.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Comments::instance()->comment_type( $this->_comment_type, $this->_days_to_keep ),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->comments_by_type( $this->_comment_type, $this->_days_to_keep );

		return $this->base_sweep( $removal );
	}
}
