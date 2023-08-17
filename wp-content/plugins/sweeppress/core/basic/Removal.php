<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\Plugin\SweepPress\Base\DB as CoreDB;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Removal extends CoreDB {
	protected $plugin_instance = 'removal';

	private $run = true;

	public function __construct() {
		parent::__construct();

		if ( SWEEPPRESS_SIMULATION ) {
			$this->run = false;
		}
	}

	private function _remove( $sql ) {
		if ( $this->run ) {
			$result = $this->query( $sql );

			if ( $result === false ) {
				return new WP_Error( 'wpdb', $this->wpdb()->last_error );
			} else {
				return absint( $result );
			}
		} else {
			return 1;
		}
	}

	public function cron_jobs() {
		if ( $this->run ) {
			_set_cron_array( array() );
		}
	}

	public function commentmeta_orphans() {
		$sql = "DELETE m FROM $this->commentmeta m ";
		$sql .= "LEFT JOIN $this->comments p ON p.`comment_ID` = m.`comment_id` ";
		$sql .= "WHERE p.`comment_ID` IS NULL";

		return $this->_remove( $sql );
	}

	public function comments_orphans() {
		$sql = "DELETE c, m FROM $this->comments c ";
		$sql .= "LEFT JOIN $this->commentmeta m ON m.`comment_id` = c.`comment_ID` ";
		$sql .= "LEFT JOIN $this->posts p ON p.`ID` = c.`comment_post_ID` ";
		$sql .= "WHERE p.`ID` IS NULL";

		return $this->_remove( $sql );
	}

	public function comments_user_agent( int $keep_days = 0 ) {
		$keep_days --;

		$sql = "UPDATE $this->comments SET `comment_agent` = '' ";
		$sql .= "WHERE `comment_agent` != '' AND DATEDIFF(NOW(), `comment_date`) > %d";
		$sql = $this->prepare( $sql, $keep_days );

		return $this->_remove( $sql );
	}

	public function comments_by_status( string $comment_status, string $comment_type, int $keep_days = 0 ) {
		$keep_days --;
		$actual_status = $comment_status == 'unapproved' ? '0' : ( $comment_status == 'approved' ? '1' : $comment_status );

		$sql = "DELETE p, m FROM $this->comments p ";
		$sql .= "LEFT JOIN $this->commentmeta m ON m.`comment_id` = p.`comment_ID` ";
		$sql .= "WHERE p.`comment_approved` = %s AND DATEDIFF(NOW(), p.`comment_date`) > %d ";
		$sql .= "AND p.`comment_type` = %s";
		$sql = $this->prepare( $sql, $actual_status, $keep_days, $comment_type );

		return $this->_remove( $sql );
	}

	public function comments_by_type( string $comment_type, int $keep_days = 0 ) {
		$keep_days --;

		$sql = "DELETE p, m FROM $this->comments p ";
		$sql .= "LEFT JOIN $this->commentmeta m ON m.`comment_id` = p.`comment_ID` ";
		$sql .= "WHERE p.`comment_type` = %s AND DATEDIFF(NOW(), p.`comment_date`) > %d";
		$sql = $this->prepare( $sql, $comment_type, $keep_days );

		return $this->_remove( $sql );
	}

	public function akismet_meta_records( int $keep_days = 0 ) {
		$keep_days --;

		$sql = "DELETE m FROM $this->comments c INNER JOIN $this->commentmeta m ON m.`comment_id` = c.`comment_ID` ";
		$sql .= "WHERE m.`meta_key` IN ('" . join( "', '", sweeppress_akismet_meta_keys() ) . "') ";
		$sql .= "AND c.`comment_approved` = '1' AND DATEDIFF(NOW(), c.`comment_date`) > %d";
		$sql = $this->prepare( $sql, $keep_days );

		return $this->_remove( $sql );
	}

	public function usermeta_orphans() {
		$sql = "DELETE m FROM $this->usermeta m ";
		$sql .= "LEFT JOIN $this->users p ON p.ID = m.user_id ";
		$sql .= "WHERE p.ID IS NULL";

		return $this->_remove( $sql );
	}

	public function termmeta_orphans() {
		$sql = "DELETE m FROM $this->termmeta m ";
		$sql .= "LEFT JOIN $this->terms p ON p.term_id = m.term_id ";
		$sql .= "WHERE p.term_id IS NULL";

		return $this->_remove( $sql );
	}

	public function terms_orphans() {
		$sql = "DELETE t, m FROM $this->terms t ";
		$sql .= "LEFT JOIN $this->termmeta m ON m.`term_id` = t.`term_id` ";
		$sql .= "LEFT JOIN $this->term_taxonomy x ON x.`term_id` = t.`term_id` ";
		$sql .= "WHERE x.`term_id` IS NULL";

		return $this->_remove( $sql );
	}

	public function posts_by_status( string $post_status, string $post_type, int $keep_days = 0 ) {
		$keep_days --;

		$taxonomies = get_object_taxonomies( $post_type );

		if ( ! empty( $taxonomies ) ) {
			$sql = "DELETE r FROM $this->posts p ";
			$sql .= "INNER JOIN $this->term_relationships r ON p.ID = r.object_id ";
			$sql .= "INNER JOIN $this->term_taxonomy t ON t.term_taxonomy_id = r.term_taxonomy_id ";
			$sql .= "WHERE p.`post_status` = %s AND p.`post_type` = %s AND DATEDIFF(NOW(), p.`post_date`) > %d ";
			$sql .= "AND t.taxonomy IN ('" . join( "', '", $taxonomies ) . "')";
			$sql = $this->prepare( $sql, $post_status, $post_type, $keep_days );

			$inter = $this->_remove( $sql );

			if ( is_wp_error( $inter ) ) {
				return $inter;
			}
		}

		$sql = "DELETE p, m, c, t FROM $this->posts p ";
		$sql .= "LEFT JOIN $this->postmeta m ON m.`post_id` = p.`ID` ";
		$sql .= "LEFT JOIN $this->comments c ON c.`comment_post_ID` = p.`ID` ";
		$sql .= "LEFT JOIN $this->commentmeta t ON t.`comment_id` = c.`comment_ID` ";
		$sql .= "WHERE p.`post_status` = %s AND p.`post_type` = %s AND DATEDIFF(NOW(), p.`post_date`) > %d";
		$sql = $this->prepare( $sql, $post_status, $post_type, $keep_days );

		return $this->_remove( $sql );
	}

	public function posts_revisions( string $post_type, int $keep_days = 0, array $post_status = array( 'publish' ) ) {
		$keep_days --;

		$sql = "DELETE r, m FROM $this->posts r ";
		$sql .= "INNER JOIN $this->posts p ON p.`ID` = r.`post_parent` ";
		$sql .= "LEFT JOIN $this->postmeta m ON m.`post_id` = r.`ID` ";
		$sql .= "WHERE r.post_type = 'revision' AND p.post_type = %s AND p.`post_status` IN ('" . join( "', '", $post_status ) . "')";
		$sql .= "AND DATEDIFF(NOW(), r.`post_date`) > %d";
		$sql = $this->prepare( $sql, $post_type, $keep_days );

		return $this->_remove( $sql );
	}

	public function posts_orphaned_revisions() {
		$sql = "DELETE r FROM $this->posts r ";
		$sql .= "LEFT JOIN $this->posts p ON p.ID = r.post_parent ";
		$sql .= "WHERE r.post_type = 'revision' AND p.ID IS NULL";

		return $this->_remove( $sql );
	}

	public function postmeta_orphans() {
		$sql = "DELETE m FROM $this->postmeta m ";
		$sql .= "LEFT JOIN $this->posts p ON p.ID = m.post_id ";
		$sql .= "WHERE p.ID IS NULL";

		return $this->_remove( $sql );
	}

	public function postmeta_by_key( string $meta_key ) {
		$sql = "DELETE m FROM $this->postmeta m WHERE m.`meta_key` = %s";
		$sql = $this->prepare( $sql, $meta_key );

		return $this->_remove( $sql );
	}

	public function postmeta_oembeds() {
		$sql = "DELETE m FROM $this->postmeta m WHERE m.`meta_key` LIKE '_oembed_%'";

		return $this->_remove( $sql );
	}

	public function signups_inactive( int $keep_days = 0 ) {
		$keep_days --;

		$sql = "DELETE s FROM " . $this->wpdb()->signups . " s WHERE s.`active` = 0 AND DATEDIFF(NOW(), s.`registered`) > %d";
		$sql = $this->prepare( $sql, $keep_days );

		return $this->_remove( $sql );
	}

	public function actionscheduler_log_orphaned_records() {
		$sql = "DELETE m FROM $this->actionscheduler_logs m ";
		$sql .= "LEFT JOIN $this->actionscheduler_actions p ON p.`action_id` = m.`action_id` ";
		$sql .= "WHERE p.`action_id` IS NULL";

		return $this->_remove( $sql );
	}

	public function actionscheduler_log_records( int $group_id, int $keep_days ) {
		$keep_days --;

		$sql = "DELETE l FROM $this->actionscheduler_logs l ";
		$sql .= "INNER JOIN $this->actionscheduler_actions a ON a.`action_id` = l.`action_id` ";
		$sql .= "WHERE a.`group_id` = %d AND DATEDIFF(NOW(), l.`log_date_gmt`) > %d";
		$sql = $this->prepare( $sql, $group_id, $keep_days );

		return $this->_remove( $sql );
	}

	public function actionscheduler_actions_records_for_status( array $action_status, int $group_id, int $keep_days ) {
		$keep_days --;

		$sql = "DELETE a, l FROM $this->actionscheduler_actions a ";
		$sql .= "LEFT JOIN $this->actionscheduler_logs l ON a.`action_id` = l.`action_id` ";
		$sql .= "WHERE a.`status` IN ('" . join( "', '", $action_status ) . "') ";
		$sql .= " AND a.`group_id` = %d AND DATEDIFF(NOW(), a.`scheduled_date_gmt`) > %d";
		$sql = $this->prepare( $sql, $group_id, $keep_days );

		return $this->_remove( $sql );
	}
}
