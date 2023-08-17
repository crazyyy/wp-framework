<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Data;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;
use Dev4Press\v42\Core\Quick\Arr;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostsRevisions extends Sweeper {
	protected $_code = 'posts-revisions';
	protected $_category = 'posts';
	protected $_days_to_keep = 0;
	protected $_affected_tables = array(
		'postmeta',
		'posts',
	);

	protected $_flag_single_task = false;

	protected $_flag_bulk_network = true;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_posts-revisions', 'sweepers', 0 );
	}

	public static function instance() : PostsRevisions {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostsRevisions();
		}

		return $instance;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s post", "%s posts", $value, "sweeppress" );
	}

	public function title() : string {
		return __( "Posts Revisions", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove posts revisions.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "This sweeper will take into account revisions for published posts only only for every post type.", "sweeppress" ),
			__( "If bbPress plugin is active, the list of statuses will include 'hidden', 'private', 'closed', 'spam' and 'trash' topics.", "sweeppress" ),
			__( "Plugin has a filter to modify the list of statuses that will be taken into account.", "sweeppress" ),
			__( "If you remove revisions, you will not be able to go back o previous versions of the post!", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep revisions from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
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

		$this->_tasks = array_merge( $this->_tasks, Posts::instance()->post_revisions( $this->_days_to_keep ) );
	}

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
		);

		$start = $this->get_tasks();

		$post_statuses = apply_filters( 'sweeppress_db_query_revisions_post_statuses', array( 'publish' ) );
		$post_statuses = Arr::remove_by_value( $post_statuses, 'draft', false );

		foreach ( $tasks as $name ) {
			$task = $start[ $name ] ?? array( 'records' => 0 );

			if ( $task['records'] > 0 ) {
				$removal = Removal::instance()->posts_revisions( $name, $this->_days_to_keep, $post_statuses );

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
