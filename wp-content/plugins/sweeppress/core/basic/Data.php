<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\v42\Core\Quick\Str;
use Dev4Press\v42\Core\Scope;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Data {
	public static function get_post_types() : array {
		$list = Cache::instance()->get( 'data', 'post_types' );

		if ( ! $list ) {
			$raw  = get_post_types( array(), 'objects' );
			$list = wp_list_pluck( $raw, 'label', 'name' );

			Cache::instance()->add( 'data', 'post_types', $list );
		}

		return $list;
	}

	public static function get_taxonomies() : array {
		$list = Cache::instance()->get( 'data', 'taxonomies' );

		if ( ! $list ) {
			$raw  = get_taxonomies( array(), 'objects' );
			$list = wp_list_pluck( $raw, 'label', 'name' );

			Cache::instance()->add( 'data', 'taxonomies', $list );
		}

		return $list;
	}

	public static function get_comment_types() : array {
		$list = Cache::instance()->get( 'data', 'comment_types' );

		if ( ! $list ) {
			$list = array(
				'comment'           => __( "Comment", "sweeppress" ),
				'trackback'         => __( "Trackback", "sweeppress" ),
				'pingback'          => __( "Pingback", "sweeppress" ),
				'gdrts-user-review' => __( "Rating User Review", "sweeppress" ),
			);

			$list_from_db = sweeppress_prepare()->get_comment_types();

			foreach ( $list_from_db as $type => $label ) {
				if ( ! isset( $list[ $type ] ) ) {
					$list_from_db[ $type ] = $label;
				}
			}

			Cache::instance()->add( 'data', 'comment_types', $list );
		}

		return $list;
	}

	public static function get_database_stats() : array {
		$list = Cache::instance()->get( 'database', 'stats' );

		if ( ! $list ) {
			$tables = array(
				'comments',
				'commentmeta',
				'posts',
				'postmeta',
				'options',
				'terms',
				'termmeta',
				'term_taxonomy',
				'term_relationships',
				'users',
				'usermeta',
			);

			$list = array();

			foreach ( $tables as $table ) {
				$list[ $table ] = sweeppress_db()->get_table_rows_count( sweeppress_db()->prefix . $table );
			}

			if ( Scope::instance()->is_multisite() ) {
				$list['sitemeta'] = sweeppress_db()->get_table_rows_count( sweeppress_db()->base_prefix . 'sitemeta' );
			}

			Cache::instance()->add( 'database', 'stats', $list );
		}

		return $list;
	}

	public static function get_db_table_rows( $table ) {
		$list = Data::get_database_stats();

		return $list[ $table ] ?? 0;
	}

	public static function get_post_type_title( string $post_type ) : string {
		$post_types = Data::get_post_types();

		if ( isset( $post_types[ $post_type ] ) ) {
			return $post_types[ $post_type ];
		}

		return Str::slug_to_name( $post_type );
	}

	public static function get_taxonomy_title( string $taxonomy ) : string {
		$taxonomies = Data::get_taxonomies();

		if ( isset( $taxonomies[ $taxonomy ] ) ) {
			return $taxonomies[ $taxonomy ];
		}

		return Str::slug_to_name( $taxonomy );
	}

	public static function get_comment_type_title( string $comment_type ) : string {
		$types = Data::get_comment_types();

		if ( isset( $types[ $comment_type ] ) ) {
			return $types[ $comment_type ];
		}

		return Str::slug_to_name( $comment_type );
	}

	public static function get_actionscheduler_groups() : array {
		$list = Cache::instance()->get( 'data', 'actionscheduler_groups' );

		if ( ! $list ) {
			$db   = DB::instance()->get_actionscheduler_groups();
			$list = array(
				'0' => '-no-group-',
			);

			foreach ( $db as $id => $group ) {
				$list[ $id ] = $group;
			}

			Cache::instance()->add( 'data', 'actionscheduler_groups', $list );
		}

		return $list;
	}
}
