<?php

namespace Dev4Press\Plugin\SweepPress\Base\Sweep;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Data;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class PostStatus extends Sweeper {
	protected $_post_status = '';
	protected $_category = 'posts';
	protected $_days_to_keep = 0;
	protected $_affected_tables = array(
		'commentmeta',
		'comments',
		'postmeta',
		'posts',
	);

	protected $_flag_single_task = false;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_posts-' . $this->_post_status, 'sweepers', 0 );
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s post", "%s posts", $value, "sweeppress" );
	}

	protected function post_types() : array {
		return Data::get_post_types();
	}

	public function list_tasks() : array {
		return $this->post_types();
	}

	public function prepare() {
		foreach ( $this->post_types() as $cpt => $label ) {
			$this->_tasks[ $cpt ] = array(
				'title'      => $label,
				'real_title' => $cpt,
				'items'      => 0,
				'records'    => 0,
				'size'       => 0,
			);
		}

		$this->_tasks = array_merge( $this->_tasks, Posts::instance()->post_status( (array) $this->_post_status, $this->_days_to_keep ) );
	}

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
		);

		$start = $this->get_tasks();

		foreach ( $tasks as $name ) {
			$task = $start[ $name ] ?? array( 'records' => 0 );

			if ( $task['records'] > 0 ) {
				$removal = Removal::instance()->posts_by_status( $this->_post_status, $name, $this->_days_to_keep );

				if ( is_wp_error( $removal ) ) {
					$results['tasks'][ $name ] = $removal;
				} else {
					$results['tasks'][ $name ] = $task['title'];
					$results['records']        += $task['records'];
					$results['size']           += $task['size'];
				}
			}
		}

		return $results;
	}
}
