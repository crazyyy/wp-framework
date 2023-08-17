<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\PostStatus;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostsTrash extends PostStatus {
	protected $_code = 'posts-trash';
	protected $_post_status = 'trash';

	protected $_flag_bulk_network = true;

	public static function instance() : PostsTrash {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostsTrash();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Trashed Content", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove trashed posts.", "sweeppress" );
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
