<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\PostStatus;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostsSpam extends PostStatus {
	protected $_code = 'posts-spam';
	protected $_post_status = 'spam';

	protected $_flag_bulk_network = true;

	public static function instance() : PostsSpam {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostsSpam();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Spam Content", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove spammed posts.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "This sweeper removes comments associated to removed posts.", "sweeppress" ),
			__( "This sweeper also removes terms relationship records for all removed posts.", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep related posts from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}
}
