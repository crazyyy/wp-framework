<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\PostStatus;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostsAutoDraft extends PostStatus {
	protected $_code = 'posts-auto-draft';
	protected $_post_status = 'auto-draft';

	protected $_flag_bulk_network = true;

	public static function instance() : PostsAutoDraft {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostsAutoDraft();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Auto Drafts", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove auto draft posts.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "Auto drafts are automatically made when creating new posts, before posts are saved for the first time.", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep auto draft posts from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}
}
