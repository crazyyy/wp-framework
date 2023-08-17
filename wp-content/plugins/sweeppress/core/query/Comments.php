<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;
use Dev4Press\Plugin\SweepPress\Basic\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Comments extends Query {
	protected $_group = 'query-comments';

	public static function instance() : Comments {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Comments();
		}

		return $instance;
	}

	public function comments_orphaned_status() : array {
		$list = $this->retrieve( 'comments-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_comments_orphans();

			$list = array(
				'title'   => __( "Orphaned Comments", "sweeppress" ),
				'items'   => absint( $raw['comment_records'] ),
				'records' => absint( $raw['comment_records'] ) + absint( $raw['metas_records'] ),
				'size'    => absint( $raw['comment_size'] + $raw['metas_size'] ),
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'comments-orphans', $list );
		}

		return $list;
	}

	public function commentmeta_orphaned_status() : array {
		$list = $this->retrieve( 'meta-record-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_commentmeta_orphaned_records();

			$list = array(
				'title'   => __( "Orphaned Records", "sweeppress" ),
				'records' => absint( $raw['key_records'] ),
				'size'    => absint( $raw['key_size'] ) > 0 && absint( $raw['key_size'] ) < 1025 ? 1024 : absint( $raw['key_size'] ),
			);

			$this->store( 'meta-record-orphans', $list );
		}

		return $list;
	}

	public function akismet_meta_status( int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'akismet-meta' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_comments_akismet_records( $keep_days );

			$list = array(
				'title'   => __( "Akismet Records", "sweeppress" ),
				'items'   => absint( $raw['comments'] ),
				'records' => absint( $raw['records'] ),
				'size'    => absint( $raw['size'] ) > 0 && absint( $raw['size'] ) < 1025 ? 1024 : absint( $raw['size'] ),
			);

			$this->store( 'akismet-meta', $list );
		}

		return $list;
	}

	public function comments_ua_status( int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'comments-ua' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_comments_ua_info( $keep_days );

			$list = array(
				'title'   => __( "Records with User Agent", "sweeppress" ),
				'records' => absint( $raw['ua_records'] ),
				'size'    => absint( $raw['ua_size'] ) > 0 && absint( $raw['ua_size'] ) < 1025 ? 1024 : absint( $raw['ua_size'] ),
			);

			$this->store( 'comments-ua', $list );
		}

		return $list;
	}

	public function comment_status( array $comment_status, int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'status-' . join( '-', $comment_status ) );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_comments_by_type_for_status( $comment_status, $keep_days );

			$list = array();

			foreach ( $raw as $row ) {
				$_size = absint( $row['comments_size'] ) + absint( $row['metas_size'] );

				$list[ $row['comment_type'] ] = array(
					'title'      => Data::get_comment_type_title( $row['comment_type'] ),
					'real_title' => $row['comment_type'],
					'items'      => absint( $row['comments_records'] ),
					'records'    => absint( $row['comments_records'] ) + absint( $row['metas_records'] ),
					'size'       => $_size > 0 && $_size < 1025 ? 1024 : $_size,
				);
			}

			$this->store( 'status-' . join( '-', $comment_status ), $list );
		}

		return $list;
	}

	public function comment_type( string $comment_type, int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'comments-' . $comment_type );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_comments_by_type( $comment_type, $keep_days );

			$_size = absint( $raw['comments_size'] ) + absint( $raw['metas_size'] );

			$list = array(
				'title'      => Data::get_comment_type_title( $comment_type ),
				'real_title' => $comment_type,
				'items'      => absint( $raw['comments_records'] ),
				'records'    => absint( $raw['comments_records'] ) + absint( $raw['metas_records'] ),
				'size'       => $_size > 0 && $_size < 1025 ? 1024 : $_size,
			);

			$this->store( 'comments-' . $comment_type, $list );
		}

		return $list;
	}
}
