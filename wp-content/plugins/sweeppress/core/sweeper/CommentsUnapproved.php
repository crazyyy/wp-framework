<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\CommentStatus;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CommentsUnapproved extends CommentStatus {
	protected $_code = 'comments-unapproved';
	protected $_comment_status = 'unapproved';

	protected $_flag_bulk_network = true;

	public static function instance() : CommentsUnapproved {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new CommentsUnapproved();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Unapproved Comments", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove unapproved comments.", "sweeppress" );
	}
}
