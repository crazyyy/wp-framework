<?php
/**
 * Admin Chat Box Rest Route
 *
 * This class is used to response and all rest route works
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use WPNTS\Inc\nts_fs;
use WPNTS\Inc\Activate;
use WPNTS\Inc\Deactivate;
use WPNTS\Inc\Database\DB;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Update used to rest route created
 *
 * @since 1.0.0
 */
class WooCommerce {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$wpnts_db_instance = new DB();
		$is_active = $wpnts_db_instance->is_pro_active();
		$schedules_int = get_option( 'wpnts_schedules_interval_woocommerce_settings');
		$schedules_interval = json_decode($schedules_int);

		$wpnts_stockoutofstocknotifications = $schedules_interval->stockoutofstocknotifications ?? 'false';
		$wpnts_commentmoderationnotifications = $schedules_interval->commentmoderationnotifications ?? 'false';
		$commentactionNotice = $schedules_interval->commentactionNotice ?? 'false';

		// Product quantity status stock, out of stock Notifications to Slack.
		if ( true === $wpnts_stockoutofstocknotifications ) {
			add_action( 'woocommerce_product_set_stock', [ $this, 'wpnts_product_stock_notification' ], 10, 2 );
		}

		// Comment Moderation notifications.
		if ( true === $wpnts_commentmoderationnotifications ) {
			add_action( 'wp_insert_comment',[ $this, 'wpnts_comment_moderation_notification' ], 10, 2 );
		}

		// New action hook for comment approval, deletion, and unapproval.
		if ( true === $commentactionNotice ) {
			add_action('transition_comment_status', [ $this, 'wpnts_comment_status_notification' ], 10, 3);
		}
	}



	// Product quantity status stock, out of stock Notifications to Slack.
	public function wpnts_product_stock_notification( $product_id ) {
		$product = wc_get_product( $product_id );
		$stock = $product->get_stock_quantity();

		$schedules_int = get_option( 'wpnts_schedules_interval_woocommerce_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;

		$slack_webhook_url = $wpnts_webhook;

		$message = '';
		if ( $stock <= 0 ) {
			$message = "Product '" . $product->get_name() . "' is out of stock.";
		} else {
			$message = "Product '" . $product->get_name() . "' is now back in stock with " . $stock . ' items available.';
		}

		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );
	}


	// Comment Moderation notifications.
	public function wpnts_comment_moderation_notification( $comment_ID, $comment_approved ) {

		$schedules_int = get_option( 'wpnts_schedules_interval_woocommerce_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;

		$slack_webhook_url = $wpnts_webhook;

		$comment = get_comment( $comment_ID );
		$post = get_post( $comment->comment_post_ID );
		$author = $comment->comment_author;
		$post_link = get_permalink( $post->ID );
		$message = "New comment by *$author* on *$post->post_title* ($post_link)\n\n";
		$message .= '> ' . $comment->comment_content;

		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );
	}

	/**
	 * New comment approved, unapproved, delete, trash, spam
	 */
	public function wpnts_comment_status_notification( $new_status, $old_status, $comment ) {
		$schedules_int = get_option('wpnts_schedules_interval_woocommerce_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;

		$slack_webhook_url = $wpnts_webhook;

		$post = get_post($comment->comment_post_ID);
		$author = $comment->comment_author;
		$post_link = get_permalink($post->ID);

		$message = "Comment by *$author* on *$post->post_title* ($post_link) has been ";

		if ( 'approved' === $new_status ) {
			$message .= 'approved.';
		} elseif ( 'unapproved' === $new_status ) {
			$message .= 'unapproved.';
		} elseif ( 'spam' === $new_status ) {
			$message .= 'spamed.';
		} elseif ( 'trash' === $new_status ) {
			$message .= 'deleted.';
		}

		$payload = json_encode([ 'text' => $message ]);

		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );
	}
}
