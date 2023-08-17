<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Sweeper\ActionSchedulerActionsCanceled;
use Dev4Press\Plugin\SweepPress\Sweeper\ActionSchedulerActionsComplete;
use Dev4Press\Plugin\SweepPress\Sweeper\ActionSchedulerActionsFailed;
use Dev4Press\Plugin\SweepPress\Sweeper\ActionSchedulerLog;
use Dev4Press\Plugin\SweepPress\Sweeper\ActionSchedulerLogOrphans;
use Dev4Press\Plugin\SweepPress\Sweeper\AkismetMeta;
use Dev4Press\Plugin\SweepPress\Sweeper\AllNetworkTransients;
use Dev4Press\Plugin\SweepPress\Sweeper\AllTransients;
use Dev4Press\Plugin\SweepPress\Sweeper\CommentmetaOrphans;
use Dev4Press\Plugin\SweepPress\Sweeper\CommentsOrphans;
use Dev4Press\Plugin\SweepPress\Sweeper\CommentsSpam;
use Dev4Press\Plugin\SweepPress\Sweeper\CommentsTrash;
use Dev4Press\Plugin\SweepPress\Sweeper\CommentsUnapproved;
use Dev4Press\Plugin\SweepPress\Sweeper\CommentsUserAgent;
use Dev4Press\Plugin\SweepPress\Sweeper\CronJobs;
use Dev4Press\Plugin\SweepPress\Sweeper\ExpiredTransients;
use Dev4Press\Plugin\SweepPress\Sweeper\InactiveSignups;
use Dev4Press\Plugin\SweepPress\Sweeper\NetworkExpiredTransients;
use Dev4Press\Plugin\SweepPress\Sweeper\OptimizeTables;
use Dev4Press\Plugin\SweepPress\Sweeper\PingbacksCleanup;
use Dev4Press\Plugin\SweepPress\Sweeper\PostmetaEdits;
use Dev4Press\Plugin\SweepPress\Sweeper\PostmetaLocks;
use Dev4Press\Plugin\SweepPress\Sweeper\PostmetaOembeds;
use Dev4Press\Plugin\SweepPress\Sweeper\PostmetaOld;
use Dev4Press\Plugin\SweepPress\Sweeper\PostmetaOrphans;
use Dev4Press\Plugin\SweepPress\Sweeper\PostsAutoDraft;
use Dev4Press\Plugin\SweepPress\Sweeper\PostsDraftRevisions;
use Dev4Press\Plugin\SweepPress\Sweeper\PostsOrphanedRevisions;
use Dev4Press\Plugin\SweepPress\Sweeper\PostsRevisions;
use Dev4Press\Plugin\SweepPress\Sweeper\PostsSpam;
use Dev4Press\Plugin\SweepPress\Sweeper\PostsTrash;
use Dev4Press\Plugin\SweepPress\Sweeper\RepairTables;
use Dev4Press\Plugin\SweepPress\Sweeper\RSSFeeds;
use Dev4Press\Plugin\SweepPress\Sweeper\TermmetaOrphans;
use Dev4Press\Plugin\SweepPress\Sweeper\TermsOrphans;
use Dev4Press\Plugin\SweepPress\Sweeper\TrackbacksCleanup;
use Dev4Press\Plugin\SweepPress\Sweeper\UsermetaOrphans;
use Dev4Press\v42\Core\Scope;

class Sweep {
	/** @var array */
	protected $_scopes;
	/** @var array */
	protected $_categories;
	/** @var \Dev4Press\Plugin\SweepPress\Base\Sweeper[] */
	protected $_sweepers;
	protected $_counts = array(
		'total'     => 0,
		'disabled'  => 0,
		'auto'      => 0,
		'quick'     => 0,
		'scheduled' => 0,
		'monitor'   => 0,
		'bulk'      => 0,
	);

	public function __construct() {
		$this->_scopes = array(
			'blog'    => __( "Blog", "sweeppress" ),
			'network' => __( "Network", "sweeppress" ),
		);

		$this->_categories = array(
			'posts'    => __( "Posts", "sweeppress" ),
			'comments' => __( "Comments", "sweeppress" ),
			'terms'    => __( "Terms", "sweeppress" ),
			'users'    => __( "Users", "sweeppress" ),
			'options'  => __( "Options", "sweeppress" ),
			'database' => __( "Database", "sweeppress" ),
		);

		$this->_sweepers = array(
			'posts-auto-draft'         => PostsAutoDraft::instance(),
			'posts-spam'               => PostsSpam::instance(),
			'posts-trash'              => PostsTrash::instance(),
			'posts-revisions'          => PostsRevisions::instance(),
			'posts-draft-revisions'    => PostsDraftRevisions::instance(),
			'posts-orphaned-revisions' => PostsOrphanedRevisions::instance(),
			'postmeta-locks'           => PostmetaLocks::instance(),
			'postmeta-edits'           => PostmetaEdits::instance(),
			'postmeta-old'             => PostmetaOld::instance(),
			'postmeta-oembeds'         => PostmetaOembeds::instance(),
			'postmeta-orphans'         => PostmetaOrphans::instance(),
			'comments-spam'            => CommentsSpam::instance(),
			'comments-trash'           => CommentsTrash::instance(),
			'comments-unapproved'      => CommentsUnapproved::instance(),
			'comments-orphans'         => CommentsOrphans::instance(),
			'comments-user-agent'      => CommentsUserAgent::instance(),
			'commentmeta-orphans'      => CommentmetaOrphans::instance(),
			'pingbacks-cleanup'        => PingbacksCleanup::instance(),
			'trackbacks-cleanup'       => TrackbacksCleanup::instance(),
			'akismet-meta'             => AkismetMeta::instance(),
			'terms-orphans'            => TermsOrphans::instance(),
			'termmeta-orphans'         => TermmetaOrphans::instance(),
			'usermeta-orphans'         => UsermetaOrphans::instance(),
			'expired-transients'       => ExpiredTransients::instance(),
			'rss-feeds'                => RSSFeeds::instance(),
			'all-transients'           => AllTransients::instance(),
			'cron-jobs'                => CronJobs::instance(),
		);

		if ( apply_filters( 'sweeppress_sweepers_allow_db', SWEEPPRESS_SWEEPERS_ALLOW_DB ) ) {
			$this->_sweepers['optimize-tables'] = OptimizeTables::instance();
			$this->_sweepers['repair-tables']   = RepairTables::instance();
		}

		if ( sweeppress_is_actionscheduler_active() ) {
			$this->_categories['actionscheduler'] = __( "ActionScheduler", "sweeppress" );

			$this->_sweepers['actionscheduler-log-orphans']      = ActionSchedulerLogOrphans::instance();
			$this->_sweepers['actionscheduler-log']              = ActionSchedulerLog::instance();
			$this->_sweepers['actionscheduler-actions-canceled'] = ActionSchedulerActionsCanceled::instance();
			$this->_sweepers['actionscheduler-actions-complete'] = ActionSchedulerActionsComplete::instance();
			$this->_sweepers['actionscheduler-actions-failed']   = ActionSchedulerActionsFailed::instance();
		} else {
			$this->_counts['disabled'] += 5;
		}

		if ( Scope::instance()->is_multisite() && Scope::instance()->is_main_blog() ) {
			$this->_categories['network'] = __( "Network", "sweeppress" );

			$this->_sweepers['inactive-signups']           = InactiveSignups::instance();
			$this->_sweepers['all-network-transients']     = AllNetworkTransients::instance();
			$this->_sweepers['network-expired-transients'] = NetworkExpiredTransients::instance();
		} else {
			$this->_counts['disabled'] += 3;
		}

		foreach ( $this->_sweepers as $sweeper ) {
			$this->_counts['total'] ++;

			if ( $sweeper->for_auto_cleanup() ) {
				$this->_counts['auto'] ++;
			}

			if ( $sweeper->for_quick_cleanup() ) {
				$this->_counts['quick'] ++;
			}

			if ( $sweeper->for_scheduled_cleanup() ) {
				$this->_counts['scheduled'] ++;
			}

			if ( $sweeper->for_monitor_task() ) {
				$this->_counts['monitor'] ++;
			}

			if ( $sweeper->for_bulk_network() ) {
				$this->_counts['bulk'] ++;
			}
		}
	}

	public static function instance() : Sweep {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Sweep();
		}

		return $instance;
	}

	public function get_sweepers_count( string $what = 'total' ) : int {
		return $this->_counts[ $what ] ?? 0;
	}

	public function get_category_label( string $category ) : string {
		return $this->_categories[ $category ] ?? __( "Unknown", "sweeppress" );
	}

	public function get_sweeper_title( string $sweeper ) : string {
		if ( $this->is_sweeper_valid( $sweeper ) ) {
			return $this->_sweepers[ $sweeper ]->title();
		}

		return __( "Unknown Sweeper", "sweeppress" );
	}

	public function is_sweeper_task_valid( string $sweeper, string $task ) : bool {
		if ( $this->is_sweeper_valid( $sweeper ) ) {
			return $this->sweeper( $sweeper )->is_task_valid( $task );
		}

		return false;
	}

	public function is_sweeper_valid( string $sweeper ) : bool {
		return isset( $this->_sweepers[ $sweeper ] );
	}

	public function is_sweeper_single_task( string $sweeper ) : ?bool {
		if ( $this->is_sweeper_valid( $sweeper ) ) {
			return $this->_sweepers[ $sweeper ]->for_single_task();
		}

		return null;
	}

	/** @return \Dev4Press\Plugin\SweepPress\Base\Sweeper[][] */
	public function available() : array {
		$list = array();

		foreach ( $this->_sweepers as $sweeper ) {
			if ( $sweeper->is_available() ) {
				if ( ! isset( $list[ $sweeper->get_category() ] ) ) {
					$list[ $sweeper->get_category() ] = array();
				}

				$list[ $sweeper->get_category() ][] = $sweeper;
			}
		}

		return $list;
	}

	public function categories() : array {
		return $this->_categories;
	}

	public function all( $all = false ) : array {
		$list = array();

		foreach ( $this->_sweepers as $sweeper ) {
			if ( $all || $sweeper->is_available() ) {
				$list[] = array(
					'cat'      => $sweeper->get_category(),
					'category' => $this->get_category_label( $sweeper->get_category() ),
					'name'     => $sweeper->title(),
					'code'     => $sweeper->get_code(),
					'scope'    => $sweeper->get_scope(),
					'version'  => $sweeper->get_version(),
					'info'     => $sweeper->description(),
					'auto'     => $sweeper->for_auto_cleanup(),
					'quick'    => $sweeper->for_quick_cleanup(),
					'cron'     => $sweeper->for_scheduled_cleanup(),
					'monitor'  => $sweeper->for_monitor_task(),
				);
			}
		}

		return $list;
	}

	public function sweeper( $code ) : ?Sweeper {
		if ( isset( $this->_sweepers[ $code ] ) ) {
			return $this->_sweepers[ $code ];
		}

		return null;
	}

	public function auto_sweep( string $source ) : array {
		$list = $this->available();
		$args = array();

		foreach ( $list as $sweepers ) {
			foreach ( $sweepers as $sweeper ) {
				if ( $sweeper->for_auto_cleanup() && $sweeper->is_sweepable() ) {
					$args[ $sweeper->get_code() ] = true;
				}
			}
		}

		return $this->sweep( $args, $source );
	}

	public function sweep( array $items, string $source ) : array {
		$results = array(
			'timer'    => array(
				'started' => microtime( true ),
			),
			'stats'    => array(
				'source'   => $source,
				'records'  => 0,
				'size'     => 0,
				'jobs'     => 0,
				'tasks'    => 0,
				'sweepers' => array(),
			),
			'sweepers' => array(),
		);

		foreach ( $items as $sweeper => $list ) {
			$obj = $this->sweeper( $sweeper );

			if ( $obj && $obj->is_allowed() && $obj->is_sweepable() ) {
				$_started = microtime( true );
				$tasks    = $list === true ? $obj->list_sweepable_tasks_keys() : $list;

				$results['sweepers'][ $sweeper ] = $obj->sweep( $tasks );

				sweeppress_settings()->delete_sweeper_cache( $obj->get_code() );

				$_ended = microtime( true );

				$results['stats']['jobs']    += 1;
				$results['stats']['tasks']   += count( $tasks );
				$results['stats']['records'] += $results['sweepers'][ $sweeper ]['records'];
				$results['stats']['size']    += $results['sweepers'][ $sweeper ]['size'];

				$results['stats']['sweepers'][ $sweeper ] = array(
					'records' => $results['sweepers'][ $sweeper ]['records'],
					'size'    => $results['sweepers'][ $sweeper ]['size'],
					'time'    => $_ended - $_started,
				);

				$results['sweepers'][ $sweeper ]['time'] = $_ended - $_started;
			} else {
				$results['sweepers'][ $sweeper ] = false;
			}
		}

		$results['timer']['ended'] = microtime( true );
		$results['stats']['time']  = $results['timer']['ended'] - $results['timer']['started'];

		sweeppress_settings()->log_statistics( $results['stats'] );

		return $results;
	}

	public function run_dashboard() {
		$list = $this->available();

		foreach ( $list as $category => $sweepers ) {
			foreach ( $sweepers as $sweeper ) {
				if ( $sweeper->for_auto_cleanup() || $sweeper->for_quick_cleanup() ) {
					$sweeper->get_tasks();
				}
			}
		}
	}
}
