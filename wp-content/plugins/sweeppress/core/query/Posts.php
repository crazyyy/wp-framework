<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;
use Dev4Press\Plugin\SweepPress\Basic\Data;
use Dev4Press\v42\Core\Quick\Arr;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Posts extends Query {
	protected $_group = 'query-posts';

	public static function instance() : Posts {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Posts();
		}

		return $instance;
	}

	public function postmeta_orphaned_status() : array {
		$list = $this->retrieve( 'meta-record-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_postmeta_orphaned_records();

			$list = array(
				'title'   => __( "Orphaned Records", "sweeppress" ),
				'records' => absint( $raw['key_records'] ),
				'size'    => absint( $raw['key_size'] ),
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'meta-record-orphans', $list );
		}

		return $list;
	}

	public function postmeta_oembed_status() : array {
		$list = $this->retrieve( 'meta-record-oembeds' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_postmeta_oembed_records();

			$list = array(
				'title'   => __( "OEmbed Records", "sweeppress" ),
				'records' => absint( $raw['key_records'] ),
				'size'    => absint( $raw['key_size'] ),
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'meta-record-oembeds', $list );
		}

		return $list;
	}

	public function postmeta_record_status( string $meta_key ) : array {
		$list = $this->retrieve( 'meta-record-' . $meta_key );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_postmeta_records_by_meta_key( $meta_key );

			$list = array(
				'title'   => sprintf( __( "Meta key: %s", "sweeppress" ), "'" . $meta_key . "'" ),
				'records' => absint( $raw['key_records'] ),
				'size'    => absint( $raw['key_size'] ),
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'meta-record-' . $meta_key, $list );
		}

		return $list;
	}

	public function posts_revisions_orphaned_status() : array {
		$list = $this->retrieve( 'revisions-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_posts_orphaned_revisions();

			$list = array(
				'title'   => __( "Orphaned Revisions", "sweeppress" ),
				'records' => absint( $raw['posts_records'] ),
				'size'    => absint( $raw['posts_size'] ),
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'revisions-orphans', $list );
		}

		return $list;
	}

	public function post_revisions( int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'revisions' );

		if ( ! $list ) {
			$post_statuses = apply_filters( 'sweeppress_db_query_revisions_post_statuses', array( 'publish' ) );
			$post_statuses = Arr::remove_by_value( $post_statuses, 'draft', false );

			$raw = sweeppress_prepare()->get_posts_by_type_for_revisions( $keep_days, $post_statuses );

			$list = array();

			foreach ( $raw as $row ) {
				$_size = absint( $row['posts_size'] ) + absint( $row['metas_size'] );

				$list[ $row['post_type'] ] = array(
					'type'       => 'post_type',
					'registered' => post_type_exists( $row['post_type'] ),
					'real_title' => $row['post_type'],
					'title'      => Data::get_post_type_title( $row['post_type'] ),
					'items'      => absint( $row['posts_records'] ),
					'records'    => absint( $row['posts_records'] ) + absint( $row['metas_records'] ),
					'size'       => $_size > 0 && $_size < 1025 ? 1024 : $_size,
				);
			}

			$this->store( 'revisions', $list );
		}

		return $list;
	}

	public function post_draft_revisions( int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'draft-revisions' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_posts_by_type_for_revisions( $keep_days, array( 'draft', 'auto-draft' ) );

			$list = array();

			foreach ( $raw as $row ) {
				$_size = absint( $row['posts_size'] ) + absint( $row['metas_size'] );

				$list[ $row['post_type'] ] = array(
					'type'       => 'post_type',
					'registered' => post_type_exists( $row['post_type'] ),
					'real_title' => $row['post_type'],
					'title'      => Data::get_post_type_title( $row['post_type'] ),
					'items'      => absint( $row['posts_records'] ),
					'records'    => absint( $row['posts_records'] ) + absint( $row['metas_records'] ),
					'size'       => $_size > 0 && $_size < 1025 ? 1024 : $_size,
				);
			}

			$this->store( 'draft-revisions', $list );
		}

		return $list;
	}

	public function post_status( array $post_status, int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'status-' . join( '-', $post_status ) );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_posts_by_type_for_status( $post_status, $keep_days );

			$list = array();

			foreach ( $raw as $row ) {
				$_size = absint( $row['posts_size'] ) + absint( $row['metas_size'] ) + absint( $row['comments_size'] ) + absint( $row['comments_metas_size'] );

				$list[ $row['post_type'] ] = array(
					'type'       => 'post_type',
					'registered' => post_type_exists( $row['post_type'] ),
					'real_title' => $row['post_type'],
					'title'      => Data::get_post_type_title( $row['post_type'] ),
					'items'      => absint( $row['posts_records'] ),
					'records'    => absint( $row['posts_records'] ) + absint( $row['metas_records'] ) + absint( $row['comments_records'] ) + absint( $row['comments_metas_records'] ),
					'size'       => $_size > 0 && $_size < 1025 ? 1024 : $_size,
				);
			}

			$this->store( 'status-' . join( '-', $post_status ), $list );
		}

		return $list;
	}
}
