<?php #comp-page builds: premium

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds new columns
 */
class WINPUpdate020302 extends Wbcr_Factory457_Update {

	public function install() {
		if ( is_multisite() && $this->plugin->isNetworkActive() ) {
			global $wpdb;

			$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

			if ( ! empty( $blogs ) ) {
				foreach ( $blogs as $id ) {

					switch_to_blog( $id );

					$this->new_migration();

					restore_current_blog();
				}
			}

			WINP_Helper::flush_page_cache();

			return;
		}

		$this->new_migration();
		WINP_Helper::flush_page_cache();
	}

	/**
	 * @author Artem Prihodko <webtemyk@yandex.ru>
	 * @since 2.3.2
	 */
	public function new_migration() {
		wp_raise_memory_limit();

		global $wpdb;

		$snippets = $wpdb->get_results( "
			SELECT p.ID
			  FROM {$wpdb->posts} p
				INNER JOIN {$wpdb->postmeta} m ON ( p.ID = m.post_id )
			  WHERE m.meta_key LIKE '" . WINP_Plugin::app()->getPrefix() . "snippet_type'
			        AND p.post_type = '" . WINP_SNIPPETS_POST_TYPE . "'" );

		if ( ! empty( $snippets ) ) {
			$i = 10;
			foreach ( (array) $snippets as $snippet ) {
				$is_snippet_priority = WINP_Helper::getMetaOption( $snippet->ID, 'snippet_priority' );

				if ( ! $is_snippet_priority ) {
					$snippet_priority = WINP_Helper::updateMetaOption( $snippet->ID, 'snippet_priority', $i );

					if ( $snippet_priority === false ) {
						$wpdb->insert( $wpdb->postmeta, [
							'post_id'    => $snippet->ID,
							'meta_key'   => WINP_Plugin::app()->getPrefix() . 'snippet_priority',
							'meta_value' => $i,
						], [ '%d', '%s', '%s' ] );
					}

					unset( $snippet_priority );
					$i = $i + 10;
				}
			}
		}

		unset( $snippets );
	}
}