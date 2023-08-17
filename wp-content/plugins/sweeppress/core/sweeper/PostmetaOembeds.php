<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostmetaOembeds extends Sweeper {
	protected $_code = 'postmeta-oembeds';
	protected $_category = 'posts';
	protected $_affected_tables = array(
		'postmeta',
	);

	protected $_flag_quick_cleanup = false;
	protected $_flag_auto_cleanup = false;
	protected $_flag_monitor_task = false;

	protected $_flag_bulk_network = true;

	public static function instance() : PostmetaOembeds {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostmetaOembeds();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Postmeta Oembeds", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all '_oembed_' and '_oembed_time_ records from the `postmeta` database table.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "These records are created as a cache for every embeddable link inside the post.", "sweeppress" ),
			__( "If these records are missing, they will be generated next time post needs them.", "sweeppress" ),
			__( "It is a bad idea to remove these records often. Do it only if you have issues with displaying embed content.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used from the Dashboard for Quick and Auto Sweep.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Posts::instance()->postmeta_oembed_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->postmeta_oembeds();

		return $this->base_sweep( $removal );
	}
}
