<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\BlogTransients;
use Dev4Press\Plugin\SweepPress\Query\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RSSFeeds extends BlogTransients {
	protected $_code = 'rss-feeds';
	protected $_affected_tables = array(
		'options',
	);

	protected $_flag_monitor_task = false;

	protected $_flag_bulk_network = true;

	public static function instance() : RSSFeeds {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new RSSFeeds();
		}

		return $instance;
	}

	public function title() : string {
		return __( "RSS Feeds", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all cached RSS feeds records.", "sweeppress" );
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used for Monitor Task.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function help() : array {
		return array(
			__( "These records will be recreated once the RSS Feeds functions are run next time.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Options::instance()->rss_feeds(),
		);
	}
}
