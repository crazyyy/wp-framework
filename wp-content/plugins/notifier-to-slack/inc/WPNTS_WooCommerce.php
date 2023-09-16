<?php
/**
 * Admin Chat Box Rest Route
 *
 * This class is used to response and all rest route works
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use \WPNTS\Inc\WPNTS_Activate;
use \WPNTS\Inc\WPNTS_Deactivate;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * WPNTS_Update used to rest route created
 *
 * @since 1.0.0
 */
class WPNTS_WooCommerce {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$schedules_int = get_option( 'wpnts_schedules_interval_woocommerce_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_salesnotifications = $schedules_interval->salesnotifications ?? 'false';
		$wpnts_stockoutofstocknotifications = $schedules_interval->stockoutofstocknotifications ?? 'false';
		$wpnts_commentmoderationnotifications = $schedules_interval->commentmoderationnotifications ?? 'false';

		// Now add Sales Notifications to Slack.
		if ( true === $wpnts_salesnotifications ) {
			add_action( 'woocommerce_order_status_changed', [ $this, 'wpnts_sales_notification' ], 10, 4 );
		}

		// Product quantity status stock, out of stock Notifications to Slack.
		if ( true === $wpnts_stockoutofstocknotifications ) {
			add_action( 'woocommerce_product_set_stock', [ $this, 'wpnts_product_stock_notification' ], 10, 2 );
		}

		// Comment Moderation notifications.
		if ( true === $wpnts_commentmoderationnotifications ) {
			add_action( 'wp_insert_comment',[ $this, 'wpnts_comment_moderation_notification' ], 10, 2 );
			add_action( 'edit_comment',[ $this, 'wpnts_comment_approval_notification' ], 10, 2 );
		}

	}

	/**
	 * WordPress sales notification.
	 *
	 * @since 1.0.0
	 */

	public function wpnts_sales_notification( $order_id, $old_status, $new_status, $order ) {

		$schedules_int = get_option( 'wpnts_schedules_interval_woocommerce_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;

		$slack_webhook_url = $wpnts_webhook;

		$message = 'Order #' . $order_id . ' has been updated from ' . $old_status . ' to ' . $new_status . ' for customer ' . $order->get_user()->display_name . "\n";

		foreach ( $order->get_items() as $item_id => $item ) {
			$product = $item->get_product();
			$product_name = $product->get_name();
			$product_price = $product->get_price();
			$product_quantity = $item->get_quantity();
			$product_total = $product_price * $product_quantity;

			$message .= "\nProduct: " . $product_name . "\nQuantity: " . $product_quantity . "\nPrice: $" . $product_price . "\nTotal: $" . $product_total;
		}

		$message .= "\n\nTotal Sales: $" . $order->get_total() . "\nOrder Number: " . $order_id;

		$payload = json_encode( [ 'text' => $message ] );
		$args = [
			'body'        => $payload,
			'headers'     => [ 'Content-Type' => 'application/json' ],
			'timeout'     => '5',
			'sslverify'   => false,
		];
		$response = wp_remote_post( $slack_webhook_url, $args );
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
	// For comment approval.
	public function wpnts_comment_approval_notification( $comment_ID, $approved ) {
		$schedules_int = get_option( 'wpnts_schedules_interval_woocommerce_settings');
		$schedules_interval = json_decode($schedules_int);
		$wpnts_webhook = $schedules_interval->webhook;

		$slack_webhook_url = $wpnts_webhook;

		$comment = get_comment( $comment_ID );
		$post = get_post( $comment->comment_post_ID );
		$author = $comment->comment_author;
		$post_link = get_permalink( $post->ID );

		if ( $approved ) {
			$message = "Comment by *$author* on *$post->post_title* ($post_link) has been approved.";
		} else {
			$message = "Comment by *$author* on *$post->post_title* ($post_link) has been unapproved.";
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
}
