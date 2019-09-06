<?php

/**
 * This class configures hide admin notices
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WDN_ConfigHideNotices extends Wbcr_FactoryClearfy206_Configurate {
	
	public function registerActionsAndFilters() {
		if ( is_admin() ) {
			$hide_notices_type = $this->getPopulateOption( 'hide_admin_notices' );
			
			if ( $hide_notices_type != 'not_hide' ) {
				add_action( 'admin_print_scripts', array( $this, 'catchNotices' ), 999 );
				
				if ( empty( $hide_notices_type ) || $hide_notices_type == 'only_selected' ) {
					add_action( 'admin_head', array( $this, 'printNotices' ), 999 );
				}
				
				if ( ! empty( $hide_notices_type ) ) {
					add_action( 'admin_bar_menu', array( $this, 'notificationsPanel' ), 999 );
					add_action( 'admin_enqueue_scripts', array( $this, 'notificationsPanelStyles' ) );
				}
			}
		}
	}
	
	public function printNotices() {
		if ( is_multisite() && is_network_admin() ) {
			add_action( 'network_admin_notices', array( $this, 'noticesCollection' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'noticesCollection' ) );
		}
	}
	
	
	public function notificationsPanelStyles() {
		if ( ! $this->getPopulateOption( 'show_notices_in_adminbar', false ) && current_user_can( 'manage_network' ) ) {
			return;
		}
		
		wp_enqueue_style( 'wbcr-notification-panel-styles', WDN_PLUGIN_URL . '/admin/assets/css/notifications-panel.css', array(), $this->plugin->getPluginVersion() );
		wp_enqueue_script( 'wbcr-notification-panel-scripts', WDN_PLUGIN_URL . '/admin/assets/js/notifications-panel.js', array(), $this->plugin->getPluginVersion() );
	}
	
	public function notificationsPanel( &$wp_admin_bar ) {
		if ( ! $this->getPopulateOption( 'show_notices_in_adminbar', false ) ) {
			return;
		}
		
		if ( current_user_can( 'manage_options' ) || current_user_can( 'manage_network' ) ) {
			$titles = array();
			
			$notifications = get_user_meta( get_current_user_id(), WDN_Plugin::app()->getOptionName( 'hidden_notices' ), true );
			
			if ( empty( $notifications ) ) {
				return;
			}
			
			$cont_notifications = sizeof( $notifications );
			
			// Add top menu
			$wp_admin_bar->add_menu( array(
				'id'     => 'wbcr-han-notify-panel',
				'parent' => 'top-secondary',
				'title'  => sprintf( __( 'Notifications %s', 'disable-admin-notices' ), '<span class="wbcr-han-adminbar-counter">' . $cont_notifications . '</span>' ),
				'href'   => false
			) );
			
			// loop
			if ( ! empty( $notifications ) ) {
				$i = 0;
				foreach ( $notifications as $notice_id => $message ) {
					$message = $this->getExcerpt( stripslashes( $message ), 0, 350 );
					$message .= '<div class="wbcr-han-panel-restore-notify-line">';
					$message .= '<a href="#" data-nonce="' . wp_create_nonce( $this->plugin->getPluginName() . '_ajax_restore_notice_nonce' );
					$message .= '" data-notice-id="' . esc_attr( $notice_id ) . '" class="wbcr-han-panel-restore-notify-link">';
					$message .= __( 'Restore notice', 'clearfy' ) . ( isset( $titles[ $notice_id ] ) ? ' (' . $titles[ $notice_id ] . ')' : '' );
					$message .= '</a></div>';
					
					$wp_admin_bar->add_menu( array(
						'id'     => 'wbcr-han-notify-panel-item-' . $i,
						'parent' => 'wbcr-han-notify-panel',
						'title'  => $message,
						'href'   => false,
						'meta'   => array(
							'class' => ''
						)
					) );
					
					$i ++;
				}
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
        <style>
            .wbcr-dan-hide-notices {
                position: relative;
                padding: 5px 5px 0;
                background: #fff;
            }

            .wbcr-dan-hide-notices > div {
                margin: 0 !important;
            }

            .wbcr-dan-hide-notice-link {
                display: block;
                text-align: right;
                margin: 5px 0 5px 5px;
                font-weight: bold;
                color: #F44336;
            }

            .is-dismissible .wbcr-dan-hide-notice-link {
                margin-right: -30px;
            }

            .wbcr-dan-hide-notice-link:active, .wbcr-dan-hide-notice-link:focus {
                box-shadow: none;
                outline: none;
            }
        </style>
        <!-- Disable admin notices plugin (Clearfy tools) -->
        <script>
			jQuery(document).ready(function($) {
				$(document).on('click', '.wbcr-dan-hide-notice-link', function() {
					var self = $(this),
						noticeID = self.data('notice-id'),
						nonce = self.data('nonce'),
						noticeHtml = self.closest('.wbcr-dan-hide-notices').clone(),
						contanierEl = self.closest('.wbcr-dan-hide-notices').parent();

					noticeHtml.find('.wbcr-dan-hide-notice-link').remove();

					if( !noticeID ) {
						alert('Undefinded error. Please report the bug to our support forum.');
					}

					contanierEl.hide();

					$.ajax(ajaxurl, {
						type: 'post',
						dataType: 'json',
						data: {
							action: 'wbcr-dan-hide-notices',
							security: nonce,
							notice_id: noticeID,
							notice_html: noticeHtml.html()
						},
						success: function(response) {
							if( !response || !response.success ) {

								if( response.data.error_message ) {
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
						error: function(xhr, ajaxOptions, thrownError) {
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
			if ( is_multisite() && is_network_admin() ) {
				$wp_filter_admin_notices = &$this->getWPFilter( 'network_admin_notices' );
			} else {
				$wp_filter_admin_notices = &$this->getWPFilter( 'admin_notices' );
			}
			//todo: Доработать all admin notices
			
		} catch( Exception $e ) {
			$wp_filter_admin_notices = null;
		}
		
		$hide_notices_type = $this->getPopulateOption( 'hide_admin_notices' );
		
		if ( empty( $hide_notices_type ) || $hide_notices_type == 'only_selected' ) {
			$get_hidden_notices = get_user_meta( get_current_user_id(), WDN_Plugin::app()->getOptionName( 'hidden_notices' ), true );
			
			$content = array();
			foreach ( (array) $wp_filter_admin_notices as $filters ) {
				foreach ( $filters as $callback_name => $callback ) {
					
					if ( 'usof_hide_admin_notices_start' == $callback_name || 'usof_hide_admin_notices_end' == $callback_name ) {
						continue;
					}
					
					ob_start();
					
					// #CLRF-140 fix bug for php7
					// when the developers forgot to delete the argument in the function of implementing the notification.
					$args          = array();
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
					$uniq_id1 = md5( $cont . $salt );
					$uniq_id2 = md5( $callback_name . $salt );
					
					if ( is_array( $callback['function'] ) && sizeof( $callback['function'] ) == 2 ) {
						$class = $callback['function'][0];
						if ( is_object( $class ) ) {
							$class_name  = get_class( $class );
							$method_name = $callback['function'][1];
							$uniq_id2    = md5( $class_name . ':' . $method_name );
						}
					}
					//838339d1a188e17fec838c2df3058603
					//838339d1a188e17fec838c2df3058603
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
							}
						}
						
						if ( ! $skip_notice ) {
							continue;
						}
					}
					
					$hide_link = '<a href="#" data-nonce="' . wp_create_nonce( $this->plugin->getPluginName() . '_ajax_hide_notices_nonce' ) . '" data-notice-id="' . $uniq_id1 . '_' . $uniq_id2 . '" class="wbcr-dan-hide-notice-link">[' . __( 'Hide notification forever', 'disable-admin-notices' ) . ']</a>';
					
					// Fix for Woocommerce membership
					if ( $cont != '<div class="js-wc-memberships-admin-notice-placeholder"></div>' ) {
						$cont = preg_replace( '/<(script|style)([^>]+)?>(.*?)<\/(script|style)>/is', '', $cont );
						$cont = rtrim( trim( $cont ) );
						$cont = preg_replace( '/^(<div[^>]+>)(.*?)(<\/div>)$/is', '$1<div class="wbcr-dan-hide-notices">$2' . $hide_link . '</div>$3', $cont );
					}
					
					if ( empty( $cont ) ) {
						continue;
					}
					$content[] = $cont;
				}
			}
			
			$wbcr_dan_plugin_all_notices = $content;
		}
		
		try {
			$wp_filter_user_admin_notices = &$this->getWPFilter( 'user_admin_notices' );
		} catch( Exception $e ) {
			$wp_filter_user_admin_notices = null;
		}
		
		try {
			$wp_filter_network_admin_notices = &$this->getWPFilter( 'network_admin_notices' );
		} catch( Exception $e ) {
			$wp_filter_network_admin_notices = null;
		}
		
		if ( is_user_admin() && $wp_filter_user_admin_notices !== null ) {
			$wp_filter_user_admin_notices = null;
		} else if ( is_network_admin() && $wp_filter_network_admin_notices !== null ) {
			//unset($wp_filter['network_admin_notices']);
			foreach ( $wp_filter_network_admin_notices as $f_key => $f ) {
				foreach ( $f as $c_name => $clback ) {
					if ( is_array( $clback['function'] ) && sizeof( $clback['function'] ) == 2 ) {
						$class = $clback['function'][0];
						if ( is_object( $class ) ) {
							$class_name = get_class( $class );
						}
					}
					
					unset( $wp_filter_network_admin_notices[ $f_key ][ $c_name ] );
				}
			}
		} else if ( $wp_filter_admin_notices !== null ) {
			foreach ( $wp_filter_admin_notices as $f_key => $f ) {
				foreach ( $f as $c_name => $clback ) {
					if ( is_array( $clback['function'] ) && sizeof( $clback['function'] ) == 2 ) {
						$class = $clback['function'][0];
						if ( is_object( $class ) ) {
							$class_name = get_class( $class );
						}
					}
					
					unset( $wp_filter_admin_notices[ $f_key ][ $c_name ] );
				}
			}
			
			unset( $f_key );
			unset( $f );
		}
		
		try {
			$wp_filter_all_admin_notices = &$this->getWPfilter( 'all_admin_notices' );
		} catch( Exception $e ) {
			$wp_filter_all_admin_notices = null;
		}
		
		if ( $wp_filter_all_admin_notices !== null ) {
			foreach ( $wp_filter_all_admin_notices as $f_key => $f ) {
				foreach ( $f as $c_name => $clback ) {
					if ( is_array( $clback['function'] ) && sizeof( $clback['function'] ) == 2 ) {
						$class = $clback['function'][0];
						if ( is_object( $class ) ) {
							$class_name = get_class( $class );
							
							#Fix for Learn dash && Woocommerce membership
							if ( $class_name == 'Learndash_Admin_Menus_Tabs' || $class_name == 'WC_Memberships_Admin' ) {
								continue;
							}
						}
					}
					
					#Fix for Divi theme
					if ( $c_name == 'et_pb_export_layouts_interface' ) {
						continue;
					}
					
					unset( $wp_filter_all_admin_notices[ $f_key ][ $c_name ] );
				}
			}
			
			unset( $f_key );
			unset( $f );
		}
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
	public function getExcerpt( $str, $startPos = 0, $maxLength = 100 ) {
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
	 * Access to global variable $wp_filter in WP core.
	 * Migration from WP 4.2 to 4.9
	 * @see https://codex.wordpress.org/Version_4.7 WP 4.7 changelog (WP_Hook)
	 *
	 * @param $key string filter name
	 *
	 * @return array $wp_filter callbacks array by link
	 * @throws Exception if key not exists
	 */
	private function &getWPFilter( $key ) {
		global $wp_version, $wp_filter;
		
		if ( ! isset( $wp_filter[ $key ] ) ) {
			throw new Exception( 'key not exists' );
		}
		if ( version_compare( $wp_version, '4.7.0', '>=' ) ) {
			return $wp_filter[ $key ]->callbacks;
		} else {
			return $wp_filter[ $key ];
		}
	}
}