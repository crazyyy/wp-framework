<?php
/**
 * This class configures the parameters advanced
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_ConfigAdvanced extends Wbcr_FactoryClearfy206_Configurate {
	
	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		parent::__construct( $plugin );
		
		$this->plugin = $plugin;
	}
	
	public function registerActionsAndFilters() {
		if ( $this->getPopulateOption( 'disable_heartbeat' ) && $this->getPopulateOption( 'disable_heartbeat' ) != 'default' ) {
			add_action( 'init', array( $this, 'disableHeartbeat' ), 1 );
		}
		
		if ( $this->getPopulateOption( 'heartbeat_frequency' ) && $this->getPopulateOption( 'heartbeat_frequency' ) != 'default' ) {
			add_filter( 'heartbeat_settings', array( $this, 'clearfyHeartbeatFrequency' ) );
		}
		
		//============================================================
		//                      ADMINBAR MANAGER COMPONENT
		//============================================================
		
		if ( $this->plugin->isActivateComponent( 'adminbar_manager' ) && is_user_logged_in() ) {
			if ( $this->getPopulateOption( 'disable_admin_bar' ) == 'for_all_users' ) {
				add_filter( 'show_admin_bar', '__return_false', 999999 );
			}
			
			if ( $this->getPopulateOption( 'disable_admin_bar' ) == 'for_all_users_except_administrator' ) {
				add_filter( 'show_admin_bar', array( $this, 'removeFunctionAdminBar' ) );
			}
		}
		
		//============================================================
		//                      WIDGETS TOOLS COMPONENT
		//============================================================
		
		if ( $this->plugin->isActivateComponent( 'widget_tools' ) ) {
			add_action( 'widgets_init', array( $this, 'unregisterDefaultWidgets' ), 11 );
		}
	}
	
	// unregister all widgets
	public function unregisterDefaultWidgets() {
		if ( $this->getPopulateOption( 'remove_unneeded_widget_page' ) ) {
			unregister_widget( 'WP_Widget_Pages' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_calendar' ) ) {
			unregister_widget( 'WP_Widget_Calendar' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_tag_cloud' ) ) {
			unregister_widget( 'WP_Widget_Tag_Cloud' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_archives' ) ) {
			unregister_widget( 'WP_Widget_Archives' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_links' ) ) {
			unregister_widget( 'WP_Widget_Links' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_meta' ) ) {
			unregister_widget( 'WP_Widget_Meta' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_search' ) ) {
			unregister_widget( 'WP_Widget_Search' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_text' ) ) {
			unregister_widget( 'WP_Widget_Text' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_categories' ) ) {
			unregister_widget( 'WP_Widget_Categories' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_recent_posts' ) ) {
			unregister_widget( 'WP_Widget_Recent_Posts' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_recent_comments' ) ) {
			unregister_widget( 'WP_Widget_Recent_Comments' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_rss' ) ) {
			unregister_widget( 'WP_Widget_RSS' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_menu' ) ) {
			unregister_widget( 'WP_Nav_Menu_Widget' );
		}
		if ( $this->getPopulateOption( 'remove_unneeded_widget_twenty_eleven_ephemera' ) ) {
			unregister_widget( 'Twenty_Eleven_Ephemera_Widget' );
		}
	}
	
	/**
	 * Revisions limit
	 *
	 * @since 0.9.5
	 */
	
	public function clearfyHeartbeatFrequency( $settings ) {
		if ( 0 < (int) $this->getPopulateOption( 'heartbeat_frequency' ) ) {
			$settings['interval'] = (int) $this->getPopulateOption( 'heartbeat_frequency' );
		}
		
		return $settings;
	}
	
	public function disableHeartbeat() {
		switch ( $this->getPopulateOption( 'disable_heartbeat' ) ) {
			case 'everywhere':
				wp_deregister_script( 'heartbeat' );
				break;
			case 'allow_only_on_post_edit_pages':
				global $pagenow;
				if ( $pagenow != 'post.php' && $pagenow != 'post-new.php' ) {
					wp_deregister_script( 'heartbeat' );
				}
				break;
			case 'on_dashboard_page':
				global $pagenow;
				if ( 'index.php' === $pagenow ) {
					wp_deregister_script( 'heartbeat' );
				}
				break;
		}
	}
	
	/**
	 * @param $content
	 *
	 * @return bool
	 */
	public function removeFunctionAdminBar( $content ) {
		return ( current_user_can( 'administrator' ) ) ? $content : false;
	}
}




