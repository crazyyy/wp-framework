<?php
/**
 * Bulk Edit SEO Meta data from Content AI API.
 *
 * @since      1.0.108
 * @package    RankMath
 * @subpackage RankMath\Status
 * @author     Rank Math <support@rankmath.com>
 */

namespace RankMath\ContentAI;

use RankMath\Helper;
use RankMath\Admin\Admin_Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Bulk_Edit_SEO_Meta class.
 */
class Bulk_Edit_SEO_Meta extends \WP_Background_Process {

	/**
	 * Action.
	 *
	 * @var string
	 */
	protected $action = 'bulk_edit_seo_meta';

	/**
	 * Main instance.
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @return Bulk_Edit_SEO_Meta
	 */
	public static function get() {
		static $instance;

		if ( is_null( $instance ) && ! ( $instance instanceof Bulk_Edit_SEO_Meta ) ) {
			$instance = new Bulk_Edit_SEO_Meta();
		}

		return $instance;
	}

	/**
	 * Start creating batches.
	 *
	 * @param array $data Posts data.
	 */
	public function start( $data ) {
		Helper::add_notification(
			esc_html__( 'Bulk editing SEO meta started. It might take few minutes to complete the process.', 'rank-math' ),
			[
				'type'    => 'success',
				'id'      => 'rank_math_content_ai_posts_started',
				'classes' => 'rank-math-notice',
			]
		);

		$action = $data['action'];
		$posts  = $data['posts'];
		update_option( 'rank_math_content_ai_posts', $posts );
		$chunks = array_chunk( $posts, 10, true );
		foreach ( $chunks as $chunk ) {
			$this->push_to_queue(
				[
					'posts'  => $chunk,
					'action' => $action,
				]
			);
		}

		$this->save()->dispatch();
	}

	/**
	 * Complete.
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		$posts = get_option( 'rank_math_content_ai_posts' );
		delete_option( 'rank_math_content_ai_posts' );
		delete_option( 'rank_math_content_ai_posts_processed' );
		Helper::add_notification(
			// Translators: placeholder is the number of modified posts.
			sprintf( _n( 'SEO meta successfully updated in %d post.', 'SEO meta successfully updated in %d posts.', count( $posts ), 'rank-math' ), count( $posts ) ),
			[
				'type'    => 'success',
				'id'      => 'rank_math_content_ai_posts',
				'classes' => 'rank-math-notice',
			]
		);

		parent::complete();
	}

	/**
	 * Task to perform.
	 *
	 * @param string $data Posts to process.
	 */
	public function wizard( $data ) {
		$this->task( $data );
	}

	/**
	 * Task to perform.
	 *
	 * @param array $data Posts to process.
	 *
	 * @return bool
	 */
	protected function task( $data ) {
		try {
			$posts = json_decode( wp_remote_retrieve_body( $this->get_posts( $data ) ), true );

			if ( empty( $posts['meta'] ) ) {
				return false;
			}

			foreach ( $posts['meta'] as $post_id => $data ) {
				if ( ! empty( $data['title'] ) ) {
					update_post_meta( $post_id, 'rank_math_title', sanitize_text_field( $data['title'] ) );
				}

				if ( ! empty( $data['description'] ) ) {
					update_post_meta( $post_id, 'rank_math_description', sanitize_textarea_field( $data['description'] ) );
				}
			}

			$this->update_content_ai_posts_count( count( $posts['meta'] ) );

			$credits = ! empty( $posts['credits'] ) ? json_decode( $posts['credits'], true ) : [];
			if ( ! empty( $credits['available'] ) ) {
				$credits = $credits['available'] - $credits['taken'];
				Helper::update_credits( $credits );

				if ( $credits <= 0 ) {
					$posts_processed = get_option( 'rank_math_content_ai_posts_processed' );
					delete_option( 'rank_math_content_ai_posts' );
					delete_option( 'rank_math_content_ai_posts_processed' );
					Helper::add_notification(
						// Translators: placeholder is the number of modified posts.
						sprintf( esc_html__( 'SEO meta successfully updated in %d posts. The process was stopped as you have used all the credits on your site.', 'rank-math' ), $posts_processed ),
						[
							'type'    => 'success',
							'id'      => 'rank_math_content_ai_posts',
							'classes' => 'rank-math-notice',
						]
					);

					wp_clear_scheduled_hook( 'wp_bulk_edit_seo_meta_cron' );
				}
			}

			return false;
		} catch ( Exception $error ) {
			return true;
		}
	}

	/**
	 * Get Posts to bulk update the data.
	 *
	 * @param array $data Data to process.
	 *
	 * @return array
	 */
	private function get_posts( $data ) {
		$connect_data = Admin_Helper::get_registration_data();
		$posts        = $data['posts'];
		$action       = $data['action'];
		$data         = [
			'posts'          => $posts,
			'output'         => $action,
			'choices'        => 1,
			'username'       => $connect_data['username'],
			'api_key'        => $connect_data['api_key'],
			'site_url'       => $connect_data['site_url'],
			'plugin_version' => rank_math()->version,
		];

		return wp_remote_post(
			'https://rankmath.com/wp-json/contentai/v1/Bulk_SEO_Meta',
			[
				'headers' => [
					'content-type' => 'application/json',
				],
				'timeout' => 60000,
				'body'    => wp_json_encode( $data ),
			]
		);
	}

	/**
	 * Keep count of the Content AI posts that were processed.
	 *
	 * @param int $count Number of posts processed.
	 *
	 * @return void
	 */
	private function update_content_ai_posts_count( $count ) {
		$content_ai_posts_count = get_option( 'rank_math_content_ai_posts_processed', 0 ) + $count;
		update_option( 'rank_math_content_ai_posts_processed', $content_ai_posts_count, false );
	}
}
