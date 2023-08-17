<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\v42\Core\Helpers\ObjectsSort;
use Dev4Press\v42\Core\Scope;
use Dev4Press\Plugin\SweepPress\Base\DB as CoreDB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Prepare extends CoreDB {
	protected $plugin_instance = 'prepare';

	private $_columns_modifiers = array(
		'comments'    => 32,
		'commentmeta' => 8,
		'posts'       => 52,
		'postmeta'    => 8,
		'signups'     => 16,
		'terms'       => 8,
		'termmeta'    => 8,
		'termrels'    => 12,
		'usermeta'    => 8,
		'as_logs'     => 16,
		'as_actions'  => 32,
	);

	private $_columns_for_length = array(
		'comments'    => array(
			'comment_author',
			'comment_author_email',
			'comment_author_url',
			'comment_author_IP',
			'comment_content',
			'comment_approved',
			'comment_agent',
			'comment_type',
		),
		'commentmeta' => array(
			'meta_key',
			'meta_value',
		),
		'posts'       => array(
			'post_content',
			'post_title',
			'post_excerpt',
			'post_status',
			'comment_status',
			'ping_status',
			'post_password',
			'post_name',
			'to_ping',
			'pinged',
			'post_content_filtered',
			'guid',
			'post_type',
			'post_mime_type',
		),
		'postmeta'    => array(
			'meta_key',
			'meta_value',
		),
		'signups'     => array(
			'domain',
			'path',
			'title',
			'user_login',
			'user_email',
			'activation_key',
			'meta',
		),
		'terms'       => array(
			'name',
			'slug',
		),
		'termmeta'    => array(
			'meta_key',
			'meta_value',
		),
		'termrels'    => array(),
		'usermeta'    => array(
			'meta_key',
			'meta_value',
		),
		'as_logs'     => array(
			'message',
		),
		'as_actions'  => array(
			'hook',
			'status',
			'args',
			'schedule',
			'extended_args',
		),
	);

	private function _get_columns_length_sum( string $table, string $prefix, bool $is_distinct = true ) : string {
		if ( sweeppress_settings()->get( 'estimated_mode_full', 'sweepers' ) ) {
			$columns  = array();
			$distinct = $is_distinct ? 'DISTINCT ' : '';

			if ( empty( $this->_columns_for_length[ $table ] ) ) {
				return ", SUM(" . $distinct . $this->_columns_modifiers[ $table ] . ")";
			} else {
				foreach ( $this->_columns_for_length[ $table ] as $name ) {
					$columns[] = "LENGTH(COALESCE(" . $prefix . ".`" . $name . "`, ''))";
				}

				return ", SUM(" . $distinct . join( " + ", $columns ) . " + " . $this->_columns_modifiers[ $table ] . ")";
			}
		} else {
			return ", 0";
		}
	}

	public function get_comment_types() : array {
		$sql = "SELECT DISTINCT `comment_type` FROM " . $this->comments;
		$raw = $this->get_results( $sql );

		$types = array();

		foreach ( $raw as $row ) {
			$types[ $row->comment_type ] = $row->comment_type;
		}

		return $types;
	}

	public function get_all_network_transients() : array {
		$keys = array(
			"_site_transient_%",
			"_site_transient_timeout_%",
		);

		$check = array();

		foreach ( $keys as $key ) {
			$check[] = "`meta_key` LIKE '$key'";
		}

		$sql = "SELECT `meta_key` FROM $this->sitemeta WHERE (" . join( " OR ", $check ) . ")";
		$raw = $this->get_results( $sql );

		$list = array();

		foreach ( $raw as $item ) {
			$value = $item->meta_key;

			if ( strpos( $value, '_site_transient_timeout_' ) === 0 ) {
				$list[] = substr( $value, 24 );
			} else if ( strpos( $value, '_site_transient_' ) === 0 ) {
				$list[] = substr( $value, 16 );
			}
		}

		return array_unique( $list );
	}

	public function get_expired_network_transients() : array {
		$sql = sprintf( "SELECT `meta_key` FROM $this->sitemeta WHERE `meta_key` LIKE '%s' AND meta_value < UNIX_TIMESTAMP()", "_site_transient_timeout_%" );
		$raw = $this->get_results( $sql );

		$list = array();

		foreach ( $raw as $item ) {
			$value = $item->meta_key;

			if ( strpos( $value, '_site_transient_timeout_' ) === 0 ) {
				$list[] = substr( $value, 24 );
			}
		}

		return $list;
	}

	public function get_network_transients_information( array $site ) : array {
		$keys = array();

		foreach ( $site as $transient ) {
			$keys[] = '_site_transient_' . $transient;
			$keys[] = '_site_transient_timeout_' . $transient;
		}

		$sql = "SELECT COUNT(*) as records, SUM(LENGTH(`meta_key`) + LENGTH(`meta_value`) + 8) as size FROM $this->sitemeta WHERE `meta_key` IN ('" . join( "', '", $keys ) . "')";
		$raw = $this->get_row( $sql );

		return array(
			'records' => isset( $raw->records ) ? absint( $raw->records ) : 0,
			'size'    => isset( $raw->size ) ? absint( $raw->size ) : 0,
		);
	}

	public function get_all_transients( $feeds = false ) : array {
		$keys = ! $feeds
			? array(
				"_transient_%",
				"_site_transient_%",
				"_transient_timeout_%",
				"_site_transient_timeout_%",
			)
			: array(
				"_transient_feed_%",
				"_site_transient_feed_%",
				"_transient_timeout_feed_%",
				"_site_transient_timeout_feed_%",
				"_transient_feed_mod_%",
				"_site_transient_feed_mod_%",
				"_transient_timeout_feed_mod_%",
				"_site_transient_timeout_feed_mod_%",
				"_transient_dash_v2_%",
				"_site_transient_dash_v2_%",
				"_transient_timeout_dash_v2_%",
				"_site_transient_timeout_dash_v2_%",
			);

		$check = array();

		foreach ( $keys as $key ) {
			$check[] = "`option_name` LIKE '$key'";
		}

		$sql = "SELECT `option_name` FROM $this->options WHERE (" . join( " OR ", $check ) . ")";
		$raw = $this->get_results( $sql );

		$list = array(
			'site'  => array(),
			'local' => array(),
		);

		foreach ( $raw as $item ) {
			$value = $item->option_name;

			if ( strpos( $value, '_transient_timeout_' ) === 0 ) {
				$list['local'][] = substr( $value, 19 );
			} else if ( strpos( $value, '_transient_' ) === 0 ) {
				$list['local'][] = substr( $value, 11 );
			} else if ( strpos( $value, '_site_transient_timeout_' ) === 0 ) {
				$list['site'][] = substr( $value, 24 );
			} else if ( strpos( $value, '_site_transient_' ) === 0 ) {
				$list['site'][] = substr( $value, 16 );
			}
		}

		$list['site']  = array_unique( $list['site'] );
		$list['local'] = array_unique( $list['local'] );

		return $list;
	}

	public function get_expired_transients() : array {
		$sql = sprintf( "SELECT `option_name` FROM $this->options WHERE (`option_name` LIKE '%s' OR `option_name` LIKE '%s') AND option_value < UNIX_TIMESTAMP()", "_transient_timeout_%", "_site_transient_timeout_%" );
		$raw = $this->get_results( $sql );

		$list = array(
			'site'  => array(),
			'local' => array(),
		);

		foreach ( $raw as $item ) {
			$value = $item->option_name;

			if ( strpos( $value, '_transient_timeout_' ) === 0 ) {
				$list['local'][] = substr( $value, 19 );
			} else if ( strpos( $value, '_site_transient_timeout_' ) === 0 ) {
				$list['site'][] = substr( $value, 24 );
			}
		}

		return $list;
	}

	public function get_transients_information( array $local, array $site ) : array {
		$keys = array();

		foreach ( $local as $transient ) {
			$keys[] = '_transient_' . $transient;
			$keys[] = '_transient_timeout_' . $transient;
		}

		foreach ( $site as $transient ) {
			$keys[] = '_site_transient_' . $transient;
			$keys[] = '_site_transient_timeout_' . $transient;
		}

		$sql = "SELECT COUNT(*) as records, SUM(LENGTH(`option_name`) + LENGTH(`option_value`) + 8) as size FROM $this->options WHERE `option_name` IN ('" . join( "', '", $keys ) . "')";
		$raw = $this->get_row( $sql );

		return array(
			'records' => isset( $raw->records ) ? absint( $raw->records ) : 0,
			'size'    => isset( $raw->size ) ? absint( $raw->size ) : 0,
		);
	}

	public function get_database_views() : array {
		$sql = $this->prepare( "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA LIKE %s AND TABLE_TYPE LIKE 'VIEW'", DB_NAME );
		$raw = $this->get_results( $sql );

		return ! empty( $raw ) && is_array( $raw ) ? wp_list_pluck( $raw, 'TABLE_NAME' ) : array();
	}

	public function get_tables_status( bool $only_corrupted = false ) : array {
		$blog_id = Scope::instance()->get_blog_id();
		$views   = $this->get_database_views();

		$sql = "SHOW TABLE STATUS FROM `" . DB_NAME . "` WHERE `Name` LIKE '" . $this->prefix() . "%'";

		if ( Scope::instance()->is_multisite() && $blog_id == 1 ) {
			$sql .= " AND `Name` NOT REGEXP '^" . $this->base_prefix() . "[[:digit:]]*_.*'";
		}

		if ( ! empty( $views ) ) {
			$sql .= " AND `Name` NOT IN (" . $this->prepare_in_list( $views ) . ")";
		}

		$data    = $this->get_results( $sql, ARRAY_A );
		$results = array();

		foreach ( $data as $row ) {
			$_table_name = strtolower( $row['Name'] );
			$_total      = absint( $row['Data_length'] ) + absint( $row['Index_length'] ) + absint( $row['Data_free'] );
			$_corrupted  = is_null( $row['Rows'] ) || is_null( $row['Data_length'] );
			$_fragment   = $_total > 0 ? round( 100 * absint( $row['Data_free'] ) / $_total ) : 0;

			if ( $only_corrupted === false || $_corrupted ) {
				$results[ $_table_name ] = array(
					'table'            => $_table_name,
					'engine'           => $row['Engine'],
					'total'            => $_total,
					'size'             => absint( $row['Data_length'] ),
					'free'             => absint( $row['Data_free'] ),
					'index'            => absint( $row['Index_length'] ),
					'rows'             => absint( $row['Rows'] ),
					'average_row_size' => absint( $row['Avg_row_length'] ),
					'auto_increment'   => $row['Auto_increment'],
					'created'          => $row['Create_time'],
					'updated'          => $row['Update_time'],
					'collation'        => $row['Collation'],
					'comment'          => $row['Comment'],
					'fragment'         => $_fragment,
					'is_corrupted'     => $_corrupted,
					'is_wp'            => false,
					'is_wp_blog'       => false,
					'is_wp_global'     => false,
					'is_wp_network'    => false,
					'is_core'          => false,
					'wp_table'         => '',
					'detected_plugin'  => '',
					'for_optimization' => false,
				);
			}
		}

		return $results;
	}

	public function get_tables_to_optimize() : array {
		$threshold = sweeppress_settings()->get( 'db_table_optimize_threshold', 'sweepers' );
		$min_size  = sweeppress_settings()->get( 'db_table_optimize_min_size', 'sweepers' ) * 1024 * 1024;
		$blog_id   = Scope::instance()->get_blog_id();

		$sql = "SHOW TABLE STATUS FROM `" . DB_NAME . "` WHERE `Name` LIKE '" . $this->prefix() . "%'";
		$sql .= " AND ROUND(100 * `Data_free`/(`Data_length` + `Index_length` + `Data_free`)) > " . $threshold;
		$sql .= " AND `Data_free` + `Data_length` + `Index_length` > " . $min_size;

		if ( Scope::instance()->is_multisite() && $blog_id == 1 ) {
			$sql .= " AND `Name` NOT REGEXP '^" . $this->base_prefix() . "[[:digit:]]*_.*'";
		}

		$data    = $this->get_results( $sql, ARRAY_A );
		$results = array();

		foreach ( $data as $row ) {
			$results[] = (object) array(
				'table'    => $row['Name'],
				'size'     => $row['Data_length'] + $row['Index_length'],
				'free'     => $row['Data_free'],
				'fragment' => round( 100 * $row['Data_free'] / ( $row['Data_free'] + $row['Data_length'] + $row['Index_length'] ) ),
			);
		}

		$results = ObjectsSort::run( $results, array(
			array(
				'property' => 'fragment',
				'order'    => 'desc',
			),
		) );

		$output = array();
		foreach ( $results as $object ) {
			$output[] = (array) $object;
		}

		return $output;
	}

	public function get_postmeta_records_by_meta_key( string $meta_key ) : array {
		$sql = "SELECT COUNT(*) AS key_records " . $this->_get_columns_length_sum( 'postmeta', 'm', false ) . " as key_size ";
		$sql .= "FROM $this->postmeta m WHERE m.`meta_key` = %s";
		$sql = $this->prepare( $sql, $meta_key );

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_postmeta_oembed_records() : array {
		$sql = "SELECT COUNT(*) AS key_records " . $this->_get_columns_length_sum( 'postmeta', 'm', false ) . " as key_size ";
		$sql .= "FROM $this->postmeta m WHERE m.`meta_key` LIKE '_oembed_%'";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_posts_by_type_for_revisions( int $keep_days, array $post_status = array( 'publish' ) ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT p.`post_type`, COUNT(DISTINCT r.`ID`) AS posts_records, COUNT(DISTINCT m.`meta_id`) AS metas_records ";
		$sql .= $this->_get_columns_length_sum( 'posts', 'r' ) . " as posts_size ";
		$sql .= $this->_get_columns_length_sum( 'postmeta', 'm', false ) . " as metas_size ";
		$sql .= "FROM $this->posts r INNER JOIN $this->posts p ON p.`ID` = r.`post_parent` ";
		$sql .= "LEFT JOIN $this->postmeta m ON m.`post_id` = r.`ID` ";
		$sql .= "WHERE r.post_type = 'revision' AND p.`post_status` IN ('" . join( "', '", $post_status ) . "')";

		if ( $keep_days > 0 ) {
			$sql .= " AND DATEDIFF(NOW(), r.`post_date`) > " . $keep_days;
		}

		$sql .= " GROUP BY p.`post_type`";

		return $this->get_results( $sql, ARRAY_A );
	}

	public function get_posts_by_type_for_status( array $post_status, int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT p.`post_type`, COUNT(DISTINCT p.`ID`) AS posts_records, COUNT(DISTINCT m.`meta_id`) AS metas_records, ";
		$sql .= "COUNT(DISTINCT c.`comment_ID`) AS comments_records, COUNT(DISTINCT t.`meta_id`) AS comments_metas_records ";
		$sql .= $this->_get_columns_length_sum( 'posts', 'p' ) . " as posts_size ";
		$sql .= $this->_get_columns_length_sum( 'postmeta', 'm', false ) . " as metas_size ";
		$sql .= $this->_get_columns_length_sum( 'comments', 'c' ) . " as comments_size ";
		$sql .= $this->_get_columns_length_sum( 'commentmeta', 't', false ) . " as comments_metas_size ";
		$sql .= "FROM $this->posts p LEFT JOIN $this->postmeta m ON m.`post_id` = p.`ID` ";
		$sql .= "LEFT JOIN $this->comments c ON c.`comment_post_ID` = p.`ID` ";
		$sql .= "LEFT JOIN $this->commentmeta t ON t.`comment_id` = c.`comment_ID` ";
		$sql .= "WHERE p.`post_status` IN ('" . join( "', '", $post_status ) . "')";

		if ( $keep_days > 0 ) {
			$sql .= " AND DATEDIFF(NOW(), p.`post_date`) > " . $keep_days;
		}

		$sql .= " GROUP BY p.`post_type`";

		return $this->get_results( $sql, ARRAY_A );
	}

	public function get_comments_by_type_for_status( array $comment_status, int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$actual_status = array();

		foreach ( $comment_status as $status ) {
			$actual_status[] = $status == 'unapproved' ? '0' : ( $status == 'approved' ? '1' : $status );
		}

		$sql = "SELECT p.`comment_type`, COUNT(DISTINCT p.`comment_ID`) AS comments_records, COUNT(DISTINCT m.`meta_id`) AS metas_records ";
		$sql .= $this->_get_columns_length_sum( 'comments', 'p' ) . " as comments_size ";
		$sql .= $this->_get_columns_length_sum( 'commentmeta', 'm', false ) . " as metas_size ";
		$sql .= "FROM $this->comments p LEFT JOIN $this->commentmeta m ON m.`comment_id` = p.`comment_ID` ";
		$sql .= "WHERE p.`comment_approved` IN ('" . join( "', '", $actual_status ) . "')";

		if ( $keep_days > 0 ) {
			$sql .= " AND DATEDIFF(NOW(), p.`comment_date`) > " . $keep_days;
		}

		$sql .= " GROUP BY p.`comment_type`";

		return $this->get_results( $sql, ARRAY_A );
	}

	public function get_comments_by_type( string $comment_type, int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT COUNT(DISTINCT p.`comment_ID`) AS comments_records, COUNT(DISTINCT m.`meta_id`) AS metas_records ";
		$sql .= $this->_get_columns_length_sum( 'comments', 'p', false ) . " as comments_size ";
		$sql .= $this->_get_columns_length_sum( 'commentmeta', 'm', false ) . " as metas_size ";
		$sql .= "FROM $this->comments p LEFT JOIN $this->commentmeta m ON m.`comment_id` = p.`comment_ID`";
		$sql .= "WHERE p.`comment_type` IN ('" . $comment_type . "') ";

		if ( $keep_days > 0 ) {
			$sql .= " AND DATEDIFF(NOW(), p.`comment_date`) > " . $keep_days;
		}

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_postmeta_orphaned_records() : array {
		$sql = "SELECT COUNT(*) AS key_records " . $this->_get_columns_length_sum( 'postmeta', 'm', false ) . " as key_size ";
		$sql .= "FROM $this->postmeta m LEFT JOIN $this->posts p ON p.ID = m.post_id WHERE p.ID IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_comments_orphans() : array {
		$sql = "SELECT COUNT(c.`comment_ID`) as comment_records, COUNT(DISTINCT m.`meta_id`) as metas_records ";
		$sql .= $this->_get_columns_length_sum( 'comments', 'c', false ) . " as comment_size ";
		$sql .= $this->_get_columns_length_sum( 'commentmeta', 'm', false ) . " as metas_size ";
		$sql .= "FROM $this->comments c LEFT JOIN $this->commentmeta m ON m.`comment_id` = c.`comment_ID` ";
		$sql .= "LEFT JOIN $this->posts p ON p.`ID` = c.`comment_post_ID` WHERE p.`ID` IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_commentmeta_orphaned_records() : array {
		$sql = "SELECT COUNT(*) AS key_records " . $this->_get_columns_length_sum( 'commentmeta', 'm' ) . " as key_size ";
		$sql .= "FROM $this->commentmeta m LEFT JOIN $this->comments p ON p.`comment_ID` = m.`comment_id` WHERE p.`comment_ID` IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_comments_akismet_records( int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT COUNT(c.`comment_ID`) AS comments, COUNT(m.`meta_id`) AS records ";
		$sql .= $this->_get_columns_length_sum( 'commentmeta', 'm' ) . " as size ";
		$sql .= "FROM $this->comments c INNER JOIN $this->commentmeta m ON m.`comment_id` = c.`comment_ID` ";
		$sql .= "WHERE m.`meta_key` IN ('" . join( "', '", sweeppress_akismet_meta_keys() ) . "')";
		$sql .= " AND c.`comment_approved` = '1'";

		if ( $keep_days > 0 ) {
			$sql .= " AND DATEDIFF(NOW(), c.`comment_date`) > " . $keep_days;
		}

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_comments_ua_info( int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT COUNT(*) as ua_records, SUM(LENGTH(`comment_agent`)) as ua_size ";
		$sql .= "FROM $this->comments WHERE `comment_agent` != '' ";
		$sql .= "AND DATEDIFF(NOW(), `comment_date`) > %d";
		$sql = $this->prepare( $sql, $keep_days );

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_user_signups_inactive( int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT COUNT(*) AS records " . $this->_get_columns_length_sum( 'signups', 's', false ) . " as size ";
		$sql .= "FROM " . $this->wpdb()->signups . " s WHERE s.`active` = 0";

		if ( $keep_days > 0 ) {
			$sql .= " AND DATEDIFF(NOW(), s.`registered`) > " . $keep_days;
		}

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_usermeta_orphaned_records() : array {
		$sql = "SELECT COUNT(*) AS key_records " . $this->_get_columns_length_sum( 'usermeta', 'm', false ) . " as key_size ";
		$sql .= "FROM $this->usermeta m LEFT JOIN $this->users p ON p.ID = m.user_id WHERE p.ID IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_termmeta_orphaned_records() : array {
		$sql = "SELECT COUNT(*) AS key_records " . $this->_get_columns_length_sum( 'termmeta', 'm', false ) . " as key_size ";
		$sql .= "FROM $this->termmeta m LEFT JOIN $this->terms p ON p.term_id = m.term_id WHERE p.term_id IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_terms_orphans() : array {
		$sql = "SELECT COUNT(t.term_id) AS terms_records, COUNT(m.term_id) AS meta_records ";
		$sql .= $this->_get_columns_length_sum( 'terms', 't' ) . " as terms_size ";
		$sql .= $this->_get_columns_length_sum( 'termmeta', 'm' ) . " as meta_size ";
		$sql .= "FROM $this->terms t LEFT JOIN $this->termmeta m ON m.`term_id` = t.`term_id` ";
		$sql .= "LEFT JOIN $this->term_taxonomy x ON x.`term_id` = t.`term_id` ";
		$sql .= "WHERE x.`term_id` IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_posts_orphaned_revisions() : array {
		$sql = "SELECT COUNT(*) AS posts_records " . $this->_get_columns_length_sum( 'posts', 'r' ) . " as posts_size ";
		$sql .= "FROM $this->posts r LEFT JOIN $this->posts p ON p.ID = r.post_parent WHERE r.post_type = 'revision' AND p.ID IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}

	public function get_actionscheduler_actions_records_for_status( array $action_status, int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT a.`group_id`, g.`slug`, COUNT(DISTINCT a.`action_id`) AS action_records, COUNT(DISTINCT l.`log_id`) AS log_records ";
		$sql .= $this->_get_columns_length_sum( 'as_actions', 'a' ) . " as action_size ";
		$sql .= $this->_get_columns_length_sum( 'as_logs', 'l' ) . " as log_size ";
		$sql .= "FROM $this->actionscheduler_actions a LEFT JOIN $this->actionscheduler_logs l ON a.`action_id` = l.`action_id` ";
		$sql .= "LEFT JOIN $this->actionscheduler_groups g ON g.`group_id` = a.`group_id` ";
		$sql .= "WHERE a.`status` IN ('" . join( "', '", $action_status ) . "') ";

		if ( $keep_days > 0 ) {
			$sql .= " AND DATEDIFF(NOW(), a.`scheduled_date_gmt`) > " . $keep_days;
		}

		$sql .= " GROUP BY a.`group_id`";

		return $this->get_results( $sql, ARRAY_A );
	}

	public function get_actionscheduler_log_records( int $keep_days ) : array {
		$keep_days = $keep_days == 0 ? 0 : $keep_days - 1;

		$sql = "SELECT a.`group_id`, g.`slug`, COUNT(DISTINCT l.`log_id`) AS log_records ";
		$sql .= $this->_get_columns_length_sum( 'as_logs', 'l' ) . " as log_size ";
		$sql .= "FROM $this->actionscheduler_logs l INNER JOIN $this->actionscheduler_actions a ON a.`action_id` = l.`action_id` ";
		$sql .= "LEFT JOIN $this->actionscheduler_groups g ON g.`group_id` = a.`group_id`";

		if ( $keep_days > 0 ) {
			$sql .= " WHERE DATEDIFF(NOW(), l.`log_date_gmt`) > " . $keep_days;
		}

		$sql .= " GROUP BY a.`group_id`";

		return $this->get_results( $sql, ARRAY_A );
	}

	public function get_actionscheduler_log_orphaned_records() : array {
		$sql = "SELECT COUNT(*) AS key_records " . $this->_get_columns_length_sum( 'as_logs', 'l' ) . " as key_size ";
		$sql .= "FROM $this->actionscheduler_logs l LEFT JOIN $this->actionscheduler_actions a ON a.`action_id` = l.`action_id` WHERE a.`action_id` IS NULL";

		return $this->get_row( $sql, ARRAY_A );
	}
}
