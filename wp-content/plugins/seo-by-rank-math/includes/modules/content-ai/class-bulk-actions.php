<?php
/**
 * Add Content AI Bulk Action options.
 *
 * @since      1.0.212
 * @package    RankMath
 * @subpackage RankMath\Content_AI_Page
 * @author     Rank Math <support@rankmath.com>
 */

namespace RankMath\ContentAI;

use RankMath\Traits\Hooker;
use RankMath\Helper;
use RankMath\Helpers\Str;
use RankMath\Paper\Paper;
use RankMath\Admin\Admin_Helper;
use RankMath\Post;

defined( 'ABSPATH' ) || exit;

/**
 * Bulk_Actions class.
 */
class Bulk_Actions {
	use Hooker;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->action( 'admin_init', 'init_admin', 15 );
	}

	/**
	 * Init.
	 */
	public function init_admin() {
		$post_types = Helper::get_settings( 'general.content_ai_post_types', [] );
		foreach ( $post_types as $post_type ) {
			$this->filter( "bulk_actions-edit-{$post_type}", 'bulk_actions', 9 );
			$this->filter( "handle_bulk_actions-edit-{$post_type}", 'handle_bulk_actions', 10, 3 );
		}

		$taxonomies = Helper::get_accessible_taxonomies();
		unset( $taxonomies['post_format'] );
		$taxonomies = wp_list_pluck( $taxonomies, 'label', 'name' );
		foreach ( $taxonomies as $taxonomy => $label ) {
			$this->filter( "bulk_actions-edit-{$taxonomy}", 'bulk_actions' );
			$this->filter( "handle_bulk_actions-edit-{$taxonomy}", 'handle_bulk_actions', 10, 3 );
		}

		$this->filter( 'wp_bulk_edit_seo_meta_post_args', 'update_background_process_args' );
	}

	/**
	 * Add bulk actions for applicable posts, pages, CPTs.
	 *
	 * @param  array $actions Actions.
	 * @return array          New actions.
	 */
	public function bulk_actions( $actions ) {
		if ( ! Helper::has_cap( 'content_ai' ) ) {
			return $actions;
		}

		$actions['rank_math_ai_options']                             = __( '&#8595; Rank Math Content AI', 'rank-math' );
		$actions['rank_math_content_ai_fetch_seo_title']             = esc_html__( 'Write SEO Title with AI', 'rank-math' );
		$actions['rank_math_content_ai_fetch_seo_description']       = esc_html__( 'Write SEO Description with AI', 'rank-math' );
		$actions['rank_math_content_ai_fetch_seo_title_description'] = esc_html__( 'Write SEO Title & Description with AI', 'rank-math' );

		return $actions;
	}

	/**
	 * Handle bulk actions for applicable posts, pages, CPTs.
	 *
	 * @param  string $redirect   Redirect URL.
	 * @param  string $doaction   Performed action.
	 * @param  array  $object_ids Post IDs.
	 *
	 * @return string New redirect URL.
	 */
	public function handle_bulk_actions( $redirect, $doaction, $object_ids ) {
		if ( empty( $object_ids ) || ! in_array( $doaction, [ 'rank_math_content_ai_fetch_seo_title', 'rank_math_content_ai_fetch_seo_description', 'rank_math_content_ai_fetch_seo_title_description' ], true ) ) {
			return $redirect;
		}

		if ( ! empty( get_option( 'rank_math_content_ai_posts' ) ) ) {
			Helper::add_notification(
				esc_html__( 'Another bulk editing process is already running. Please try again later after the existing process is complete.', 'rank-math' ),
				[
					'type'    => 'warning',
					'id'      => 'rank_math_content_ai_posts_error',
					'classes' => 'rank-math-notice',
				]
			);

			return $redirect;
		}

		$action = 'both';
		if ( 'rank_math_content_ai_fetch_seo_title' === $doaction ) {
			$action = 'title';
		}

		if ( 'rank_math_content_ai_fetch_seo_description' === $doaction ) {
			$action = 'description';
		}

		$is_post_list = Admin_Helper::is_post_list();
		$data         = [
			'action'      => $action,
			'language'    => Helper::get_settings( 'general.content_ai_language', Helper::content_ai_default_language() ),
			'posts'       => [],
			'is_taxonomy' => ! $is_post_list,
		];

		$method = $is_post_list ? 'get_post_data' : 'get_term_data';
		foreach ( $object_ids as $object_id ) {
			$data['posts'][] = $this->$method( $object_id );
		}

		Bulk_Edit_SEO_Meta::get()->start( $data );

		return $redirect;
	}

	/**
	 * Change the timeout value in Background_Process to resolve the issue with notifications not appearing after completion in v1.2.
	 *
	 * @param array $args Process args.
	 *
	 * @return array
	 */
	public function update_background_process_args( $args ) {
		$args['timeout'] = 0.01;

		return $args;
	}

	/**
	 * Get Post data.
	 *
	 * @param integer $object_id Post ID.
	 *
	 * @return array Post data.
	 */
	private function get_post_data( $object_id ) {
		$object = get_post( $object_id );
		return [
			'post_id'       => $object_id,
			'post_type'     => 'download' === $object->post_type ? 'Product' : ucfirst( $object->post_type ),
			'title'         => get_the_title( $object_id ),
			'focus_keyword' => Post::get_meta( 'focus_keyword', $object_id ),
			'summary'       => Helper::replace_vars( $this->get_post_description( $object ), $object ),
		];
	}

	/**
	 * Get Term data.
	 *
	 * @param integer $object_id Term ID.
	 *
	 * @return array Term data.
	 */
	private function get_term_data( $object_id ) {
		$object = get_term( $object_id );
		return [
			'post_id'       => $object_id,
			'post_type'     => $object->taxonomy,
			'title'         => $object->name,
			'focus_keyword' => get_term_meta( $object_id, 'rank_math_focus_keyword', true ),
			'summary'       => Helper::replace_vars( $this->get_term_description( $object ), $object ),
		];
	}

	/**
	 * Get post description.
	 *
	 * @param WP_Post $object Post Instance.
	 *
	 * @return string Post description.
	 */
	private function get_post_description( $object ) {
		$description = Post::get_meta( 'description', $object->ID );
		if ( '' !== $description ) {
			return $description;
		}

		return ! empty( $object->post_excerpt ) ? $object->post_excerpt : Str::truncate( Paper::get_from_options( "pt_{$object->post_type}_description", $object ), 160 );
	}

	/**
	 * Get post description.
	 *
	 * @param WP_Post $object Post Instance.
	 *
	 * @return string Post description.
	 */
	private function get_term_description( $object ) {
		$description = get_term_meta( $object->term_id, 'rank_math_description', true );
		if ( '' !== $description ) {
			return $description;
		}

		return ! empty( $object->description ) ? $object->description : Str::truncate( Paper::get_from_options( "tax_{$object->taxonomy}_description", $object ), 160 );
	}
}
