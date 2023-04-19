<?php

/**
 * This class configures hide admin notices
 *
 * Github: https://github.com/alexkovalevv
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WDN_ConfigHideNotices extends WBCR\Factory_Templates_116\Configurate {

	public function registerActionsAndFilters() {
		if ( is_admin() ) {
			$hide_notices_type = $this->getPopulateOption( 'hide_admin_notices', 'only_selected' );

			if ( 'not_hide' !== $hide_notices_type && 'compact_panel' !== $hide_notices_type ) {
				add_action( 'admin_print_scripts', [ $this, 'catchNotices' ], 999 );

				if ( empty( $hide_notices_type ) || $hide_notices_type === 'only_selected' ) {
					add_action( 'admin_head', [ $this, 'printNotices' ], 999 );
				}

				if ( ! empty( $hide_notices_type ) ) {
					add_action( 'admin_bar_menu', [ $this, 'notificationsPanel' ], 999 );
					add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
				}
			}
		}
	}

	public function printNotices() {
		if ( is_multisite() && is_network_admin() ) {
			add_action( 'network_admin_notices', [ $this, 'noticesCollection' ] );
		} else {
			add_action( 'admin_notices', [ $this, 'noticesCollection' ] );
		}
	}


	public function enqueue_styles() {
		wp_enqueue_style( 'wbcr-notification-hide-style', WDN_PLUGIN_URL . '/admin/assets/css/general.css', [], $this->plugin->getPluginVersion() );

		if ( ! $this->getPopulateOption( 'show_notices_in_adminbar', false ) && current_user_can( 'manage_network' ) ) {
			return;
		}
		wp_enqueue_style( 'wbcr-notification-panel-styles', WDN_PLUGIN_URL . '/admin/assets/css/notifications-panel.css', [], $this->plugin->getPluginVersion() );
		wp_enqueue_script( 'wbcr-notification-panel-scripts', WDN_PLUGIN_URL . '/admin/assets/js/notifications-panel.js', [], $this->plugin->getPluginVersion(), true );
	}

	public function notificationsPanel( &$wp_admin_bar ) {
		if ( ! $this->getPopulateOption( 'show_notices_in_adminbar', false ) ) {
			return;
		}

		if ( current_user_can( 'manage_options' ) ) {
			$notifications_user = get_user_meta( get_current_user_id(), $this->plugin->getOptionName( 'hidden_notices' ), true );
			$notifications_all  = apply_filters( 'wdan/notifications/all', [] );

			if ( ! is_array( $notifications_user ) ) {
				$notifications_user = [];
			}

			if ( empty( $notifications_user ) && empty( $notifications_all ) ) {
				return;
			}

			$cont_notifications = sizeof( $notifications_user ) + sizeof( $notifications_all );

			// Add top menu
			$wp_admin_bar->add_menu( [
					'id'     => 'wbcr-han-notify-panel',
					'parent' => 'top-secondary',
					'title'  => sprintf( __( 'Notifications %s', 'disable-admin-notices' ), '<span class="wbcr-han-adminbar-counter">' . $cont_notifications . '</span>' ),
					'href'   => $this->plugin->getPluginPageUrl( 'wdan-notices' ),
			] );

			$i = 0;

			// User
			if ( ! empty( $notifications_user ) ) {
				$wp_admin_bar->add_menu( [
						'id'     => 'wbcr-han-notify-panel-group-user',
						'parent' => 'wbcr-han-notify-panel',
						'title'  => __( 'Hidden for you', 'disable-admin-notices' ),
						'href'   => false,
						'meta'   => [
								'class' => '',
						],
				] );

				foreach ( $notifications_user as $notice_id => $message ) {
					$message = wp_kses( $message, [] );
					$message = $this->getExcerpt( stripslashes( $message ), 0, 350 );
					$message .= '<div class="wbcr-han-panel-restore-notify-line">';
					$message .= '<a href="#" data-nonce="' . wp_create_nonce( $this->plugin->getPluginName() . '_ajax_restore_notice_nonce' );
					$message .= '" data-notice-id="' . esc_attr( $notice_id ) . '" class="wbcr-han-panel-restore-notify-link">';
					$message .= __( 'Restore notice', 'clearfy' );
					$message .= '</a></div>';

					$wp_admin_bar->add_menu( [
							'id'     => 'wbcr-han-notify-panel-item-' . $i,
							'parent' => 'wbcr-han-notify-panel',
							'title'  => $message,
							'href'   => false,
							'meta'   => [
								'class'  => '',
							],
					] );

					$i ++;
				}
			}

			if ( $this->plugin->is_premium() && ( current_user_can( 'manage_options' ) || ( is_multisite() && current_user_can( 'manage_network' ) ) ) ) {
				// All
				do_action( 'wdn/notifications/panel/all', $wp_admin_bar, $notifications_all, $i );
			}
		}
	}

	public function noticesCollection() {
		global $wbcr_dan_plugin_all_notices;

		if ( empty( $wbcr_dan_plugin_all_notices ) ) {
			return;
		}
		?>
		<!-- Disable admin notices plugin (Clearfy tools) -->
		<script>
			jQuery(document).ready(function ($) {
				$(document).on('click', '.wbcr-dan-hide-notice-link', function () {
					var self = $(this),
							target = self.data('target'),
							noticeID = self.data('notice-id'),
							nonce = self.data('nonce'),
							noticeHtml = self.closest('.wbcr-dan-hide-links').prev('.wbcr-dan-hide-notices').clone(),
							contanierEl = self.closest('.wbcr-dan-hide-links').prev('.wbcr-dan-hide-notices').parent();

					contanierEl.find('.wbcr-dan-hide-links').remove();
					contanierEl.slideUp();

					if (!noticeID) {
						alert('Undefinded error. Please report the bug to our support forum.');
					}

					$.ajax(ajaxurl, {
						type: 'post',
						dataType: 'json',
						data: {
							action: 'wbcr-dan-hide-notices',
							target: target,
							security: nonce,
							notice_id: noticeID,
							notice_html: noticeHtml.html()
						},
						success: function (response) {
							if (!response || !response.success) {

								if (response.data.error_message) {
									console.log(response.data.error_message);
									self.closest('li').show();
								} else {
									console.log(response);
								}

								contanierEl.show();
								return;
							}

							contanierEl.remove();
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.log(xhr.status);
							console.log(xhr.responseText);
							console.log(thrownError);
						}
					});
					return false;
				});
			});
		</script>
		<?php
		foreach ( $wbcr_dan_plugin_all_notices as $val ) {
			echo $val;
		}
	}

	public function catchNotices() {
		global $wbcr_dan_plugin_all_notices;

		try {
			$wp_filter_admin_notices     = &wdan_get_wp_filter( 'admin_notices' );
			$wp_filter_all_admin_notices = &wdan_get_wp_filter( 'all_admin_notices' );

			$wp_filter_notices = $this->array_merge( $wp_filter_admin_notices, $wp_filter_all_admin_notices );
		} catch ( Exception $e ) {
			$wp_filter_notices = null;
		}

		$hide_notices_type = $this->getPopulateOption( 'hide_admin_notices' );

		if ( empty( $hide_notices_type ) || $hide_notices_type == 'only_selected' ) {
			$get_hidden_notices     = get_user_meta( get_current_user_id(), $this->plugin->getOptionName( 'hidden_notices' ), true );
			$get_hidden_notices_all = apply_filters( 'wdan/notifications/all', [] );

			$content = [];
			foreach ( (array) $wp_filter_notices as $filters ) {
				foreach ( $filters as $callback_name => $callback ) {

					if ( 'usof_hide_admin_notices_start' == $callback_name || 'usof_hide_admin_notices_end' == $callback_name ) {
						continue;
					}

					ob_start();

					// #CLRF-140 fix bug for php7
					// when the developers forgot to delete the argument in the function of implementing the notification.
					$args          = [];
					$accepted_args = isset( $callback['accepted_args'] ) && ! empty( $callback['accepted_args'] ) ? $callback['accepted_args'] : 0;

					if ( $accepted_args > 0 ) {
						for ( $i = 0; $i < (int) $accepted_args; $i ++ ) {
							$args[] = null;
						}
					}
					//===========

					call_user_func_array( $callback['function'], $args );
					$cont = ob_get_clean();

					if ( empty( $cont ) ) {
						continue;
					}

					$salt     = is_multisite() ? get_current_blog_id() : '';
					$txt      = preg_replace( '/<(script|style)([^>]+)?>(.*?)<\/(script|style)>/is', '', $cont );
					$uniq_id1 = md5( strip_tags( str_replace( [ "\t", "\r", "\n", " " ], "", $txt ) ) . $salt );
					$uniq_id2 = md5( $callback_name . $salt );

					if ( is_array( $callback['function'] ) && sizeof( $callback['function'] ) == 2 ) {
						$class = $callback['function'][0];
						if ( is_object( $class ) ) {
							$class_name  = get_class( $class );
							$method_name = $callback['function'][1];
							$uniq_id2    = md5( $class_name . ':' . $method_name );
						}
					}
					//$txt = rtrim( trim( $txt ) );
					//$txt = preg_replace( '/^(<div[^>]+>)(.*?)(<\/div>)$/is', '<p>$2</p>', $txt );

					// All
					$skip_notice = apply_filters( 'wdn/notifications/catch/all', true, $get_hidden_notices_all, $uniq_id1, $uniq_id2 );
					if ( ! $skip_notice ) {
						continue;
					}

					if ( ! empty( $get_hidden_notices ) ) {
						$skip_notice = true;
						foreach ( (array) $get_hidden_notices as $key => $notice ) {
							$splited_notice_id = explode( '_', $key );
							if ( empty( $splited_notice_id ) || sizeof( $splited_notice_id ) < 2 ) {
								continue;
							}
							$compare_notice_id_1 = $splited_notice_id[0];
							$compare_notice_id_2 = $splited_notice_id[1];

							if ( $compare_notice_id_1 == $uniq_id1 || $compare_notice_id_2 == $uniq_id2 ) {
								$skip_notice = false;
								break;
							}
						}

						if ( ! $skip_notice ) {
							continue;
						}
					}

					$nonce             = wp_create_nonce( $this->plugin->getPluginName() . '_ajax_hide_notices_nonce' );
					$hide_link_for_me  = "<button data-target='user' data-nonce='{$nonce}' data-notice-id='{$uniq_id1}_{$uniq_id2}' class='wbcr-dan-hide-notice-link'>" . __( 'Hide  <b>for me</b>', 'disable-admin-notices' ) . "</button>";
					$hide_link_for_all = "";

					if ( $this->plugin->is_premium() && ( current_user_can( 'manage_options' ) || ( is_multisite() && current_user_can( 'manage_network' ) ) ) ) {
						$hide_link_for_all = "<button data-target='all'  data-nonce='{$nonce}' data-notice-id='{$uniq_id1}_{$uniq_id2}' class='wbcr-dan-hide-notice-link'>" . __( 'Hide  <b>for all</b>', 'disable-admin-notices' ) . "</button>";
					}

					if ( strpos( $cont, 'redux-connect-message' ) ) {
						$a = 1;
					}

					// Fix for Woocommerce membership and Jetpack message
					if ( $cont != '<div class="js-wc-memberships-admin-notice-placeholder"></div>' && false === strpos( $cont, 'jetpack-jitm-message' ) ) {
						$cont = preg_replace( '/<(noscript|script|style)([^>]+)?>(.*?)<\/(noscript|script|style)>(<\/(noscript|script|style)>)*/is', '', $cont );
						$cont = preg_replace( '/<!--(.*?)-->/is', '', $cont );
						$cont = rtrim( trim( $cont ) );
						$cont = preg_replace( '/^(<div[^>]+>)(.*?)(<\/div>)$/is', "$1<div class='wbcr-dan-hide-notices'>$2</div><div class='wbcr-dan-hide-links'>{$hide_link_for_me} {$hide_link_for_all}</div>$3", $cont );
					}

					if ( empty( $cont ) ) {
						continue;
					}
					$content[] = $cont;
				}
			}

			$wbcr_dan_plugin_all_notices = $content;
		}

		wdan_clear_all_notices( 'user_admin_notices' );
		wdan_clear_all_notices( 'network_admin_notices' );
		wdan_clear_all_notices( 'admin_notices', [
				'Learndash_Admin_Menus_Tabs',
				'WC_Memberships_Admin',
				'YIT_Plugin_Panel_WooCommerce',
		], [ 'et_pb_export_layouts_interface' ] );

		wdan_clear_all_notices( 'all_admin_notices', [
				'Learndash_Admin_Menus_Tabs',
				'WC_Memberships_Admin',
				'YIT_Plugin_Panel_WooCommerce',
		], [ 'et_pb_export_layouts_interface' ] );
	}


	/**
	 * Get excerpt from string
	 *
	 * @param String $str String to get an excerpt from
	 * @param Integer $startPos Position int string to start excerpt from
	 * @param Integer $maxLength Maximum length the excerpt may be
	 *
	 * @return String excerpt
	 */
	public function getExcerpt(
			$str, $startPos = 0, $maxLength = 100
	) {
		if ( strlen( $str ) > $maxLength ) {
			$excerpt   = substr( $str, $startPos, $maxLength - 3 );
			$lastSpace = strrpos( $excerpt, ' ' );
			$excerpt   = substr( $excerpt, 0, $lastSpace );
			$excerpt   .= '...';
		} else {
			$excerpt = $str;
		}

		return $excerpt;
	}

	/**
	 * @param array $arr1
	 * @param array $arr2
	 *
	 * @return array
	 */
	protected function array_merge(
			array $arr1, array $arr2
	) {
		if ( ! empty( $arr2 ) ) {
			foreach ( $arr2 as $key => $value ) {
				if ( ! isset( $arr1[ $key ] ) ) {
					$arr1[ $key ] = $value;
				} else if ( is_array( $arr1[ $key ] ) ) {
					$arr1[ $key ] = $arr1[ $key ] + $value;
				}
			}
		}

		return $arr1;
	}
}