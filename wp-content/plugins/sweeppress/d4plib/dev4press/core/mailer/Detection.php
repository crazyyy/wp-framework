<?php

/*
Name:    Dev4Press\v42\Core\Mailer\Detection
Version: v4.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com/

== Copyright ==
Copyright 2008 - 2023 Milan Petrovic (email: support@dev4press.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

namespace Dev4Press\v42\Core\Mailer;

use Dev4Press\v42\Core\Helpers\Source;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Detection {
	protected $detection;
	protected $supported = array();
	protected $aliases = array(
		'bp_send_email'
	);

	public function __construct() {
		$this->reset();
		$this->init();
		$this->listen();
	}

	public static function instance() : Detection {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new Detection();
		}

		return $instance;
	}

	public function reset() {
		$this->detection = array(
			'name' => '',
			'data' => '',
			'call' => array()
		);
	}

	public function broadcast( $atts ) {
		$name = $this->detection[ 'name' ];

		if ( ! empty( $name ) && isset( $this->supported[ $name ] ) ) {
			$this->detection[ 'data' ] = $this->supported[ $name ];
		}

		$this->caller();

		do_action( 'd4p_mailer_notification_detected', $this->detection, $atts );

		return $atts;
	}

	protected function caller() {
		$backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
		$file_path = '';
		$file_line = '';

		foreach ( $backtrace as $item ) {
			if ( isset( $item[ 'file' ] ) && isset( $item[ 'line' ] ) && isset( $item[ 'function' ] ) ) {
				if ( in_array( $item[ 'function' ], $this->aliases ) || $item[ 'function' ] == 'wp_mail' ) {
					$file_path = $item[ 'file' ];
					$file_line = $item[ 'line' ];
					break;
				}
			}
		}

		if ( ! empty( $file_path ) ) {
			$this->detection[ 'call' ]           = Source::instance()->origin( $file_path );
			$this->detection[ 'call' ][ 'line' ] = $file_line;
		}
	}

	protected function identify( string $name, string $type ) {
		foreach ( $this->supported as $code => $data ) {
			if ( isset( $data[ $type ] ) && $data[ $type ] == $name ) {
				$this->detection[ 'name' ] = $code;
				break;
			}
		}
	}

	protected function listen() {
		add_filter( 'wp_mail', array( $this, 'intercept_wp_mail' ), 1 );
		add_action( 'bp_send_email', array( $this, 'intercept_buddypress' ), 10, 2 );
		add_filter( 'wpmem_email_filter', array( $this, 'intercept_wp_members' ) );

		foreach ( $this->supported as $data ) {
			if ( isset( $data[ 'filter' ] ) ) {
				add_filter( $data[ 'filter' ], array( $this, 'intercept_filter' ) );
			} else if ( isset( $data[ 'action' ] ) ) {
				add_action( $data[ 'action' ], array( $this, 'intercept_action' ) );
			}
		}

		add_filter( 'wp_mail', array( $this, 'broadcast' ), 5 );
		add_action( 'wp_mail_succeeded', array( $this, 'reset' ), 100000 );
		add_action( 'wp_mail_failed', array( $this, 'reset' ), 100000 );
	}

	protected function init() {
		$this->supported = array(
			'wp-comment-notify-moderator'                            => array(
				'filter' => 'comment_moderation_headers',
				'source' => 'WordPress',
				'label'  => _x( "Comment Notify Moderator", "Email Detection Type", "d4plib" )
			),
			'wp-comment-notify-postauthor'                           => array(
				'filter' => 'comment_notification_headers',
				'source' => 'WordPress',
				'label'  => _x( "Comment Notify Post Author", "Email Detection Type", "d4plib" )
			),
			'wp-email-change-confirmation'                           => array(
				'filter' => 'new_user_email_content',
				'source' => 'WordPress',
				'label'  => _x( "Email Change Confirmation", "Email Detection Type", "d4plib" )
			),
			'wp-email-change-notification'                           => array(
				'filter' => 'email_change_email',
				'source' => 'WordPress',
				'label'  => _x( "Email Change Notification", "Email Detection Type", "d4plib" )
			),
			'wp-password-change-notification'                        => array(
				'filter' => 'password_change_email',
				'source' => 'WordPress',
				'label'  => _x( "Password Change Notification", "Email Detection Type", "d4plib" )
			),
			'wp-retrieve-password-message'                           => array(
				'filter' => 'retrieve_password_notification_email',
				'source' => 'WordPress',
				'label'  => _x( "Retrieve Password Notification", "Email Detection Type", "d4plib" )
			),
			'wp-privacy-personal-data-email'                         => array(
				'filter' => 'wp_privacy_personal_data_email_headers',
				'source' => 'WordPress',
				'label'  => _x( "Privacy Personal Data Email", "Email Detection Type", "d4plib" )
			),
			'wp-privacy-request-confirmation'                        => array(
				'filter' => 'user_request_confirmed_email_subject',
				'source' => 'WordPress',
				'label'  => _x( "Privacy Request Confirmation", "Email Detection Type", "d4plib" )
			),
			'wp-privacy-erasure-fulfillment'                         => array(
				'filter' => 'user_confirmed_action_email_content',
				'source' => 'WordPress',
				'label'  => _x( "Privacy Erasure Fulfillment", "Email Detection Type", "d4plib" )
			),
			'wp-send-user-request'                                   => array(
				'filter' => 'user_request_action_email_subject',
				'source' => 'WordPress',
				'label'  => _x( "Send User Request", "Email Detection Type", "d4plib" )
			),
			'wp-site-admin-email-change'                             => array(
				'filter' => 'site_admin_email_change_email',
				'source' => 'WordPress',
				'label'  => _x( "Site Admin Email Change", "Email Detection Type", "d4plib" )
			),
			'wp-site-admin-email-change-attempt'                     => array(
				'filter' => 'new_admin_email_content',
				'source' => 'WordPress',
				'label'  => _x( "Site Admin Email Change Attempt", "Email Detection Type", "d4plib" )
			),
			'wp-auto-plugin-theme-update-email'                      => array(
				'filter' => 'auto_plugin_theme_update_email',
				'source' => 'WordPress',
				'label'  => _x( "Plugin or Theme Update Email", "Email Detection Type", "d4plib" )
			),
			'wp-auto-core-update-email'                              => array(
				'filter' => 'auto_core_update_email',
				'source' => 'WordPress',
				'label'  => _x( "Core Update Email", "Email Detection Type", "d4plib" )
			),
			'wp-automatic-updates-debug-email'                       => array(
				'filter' => 'automatic_updates_debug_email',
				'source' => 'WordPress',
				'label'  => _x( "Auto Update Debug Email", "Email Detection Type", "d4plib" )
			),
			'wp-new-user-notification-admin'                         => array(
				'filter' => 'wp_new_user_notification_email_admin',
				'source' => 'WordPress',
				'label'  => _x( "New User Notification Admin", "Email Detection Type", "d4plib" )
			),
			'wp-new-user-notification'                               => array(
				'filter' => 'wp_new_user_notification_email',
				'source' => 'WordPress',
				'label'  => _x( "New User Notification", "Email Detection Type", "d4plib" )
			),
			'wp-password-change-notification-admin'                  => array(
				'filter' => 'wp_password_change_notification_email',
				'source' => 'WordPress',
				'label'  => _x( "Password Change Notification Admin", "Email Detection Type", "d4plib" )
			),
			'wp-recovery-mode-email'                                 => array(
				'filter' => 'recovery_mode_email',
				'source' => 'WordPress',
				'label'  => _x( "Recovery Mode Email", "Email Detection Type", "d4plib" )
			),
			'wp-network-signup-blog-confirmation'                    => array(
				'filter' => 'wpmu_signup_blog_notification_subject',
				'source' => 'WordPress',
				'label'  => _x( "Signup Blog Confirmation", "Email Detection Type", "d4plib" )
			),
			'wp-network-signup-user-confirmation'                    => array(
				'filter' => 'wpmu_signup_user_notification_subject',
				'source' => 'WordPress',
				'label'  => _x( "Signup User Confirmation", "Email Detection Type", "d4plib" )
			),
			'wp-network-delete-site-email-content'                   => array(
				'filter' => 'delete_site_email_content',
				'source' => 'WordPress',
				'label'  => _x( "Site Deleted Email", "Email Detection Type", "d4plib" )
			),
			'wp-network-welcome-blog'                                => array(
				'filter' => 'update_welcome_subject',
				'source' => 'WordPress',
				'label'  => _x( "Welcome Blog", "Email Detection Type", "d4plib" )
			),
			'wp-network-welcome-user'                                => array(
				'filter' => 'update_welcome_user_subject',
				'source' => 'WordPress',
				'label'  => _x( "Welcome User", "Email Detection Type", "d4plib" )
			),
			'wp-network-new-blog-siteadmin'                          => array(
				'filter' => 'newblog_notify_siteadmin',
				'source' => 'WordPress',
				'label'  => _x( "New Blog Site Admin", "Email Detection Type", "d4plib" )
			),
			'wp-network-new-user-siteadmin'                          => array(
				'filter' => 'newuser_notify_siteadmin',
				'source' => 'WordPress',
				'label'  => _x( "New User Site Admin", "Email Detection Type", "d4plib" )
			),
			'wp-network-network-admin-email-confirmation'            => array(
				'filter' => 'new_network_admin_email_content',
				'source' => 'WordPress',
				'label'  => _x( "Network Admin Email Confirmation", "Email Detection Type", "d4plib" )
			),
			'wp-network-network-admin-email-notification'            => array(
				'filter' => 'network_admin_email_change_email',
				'source' => 'WordPress',
				'label'  => _x( "Network Admin Email Notification", "Email Detection Type", "d4plib" )
			),
			'gdpol-digest-notify-moderators'                         => array(
				'action' => 'gdpol_daily_digest_notify_moderators_pre_notify',
				'source' => 'GD Topic Polls',
				'label'  => _x( "Digest Notify Moderators", "Email Detection Type", "d4plib" )
			),
			'gdpol-digest-notify-author'                             => array(
				'action' => 'gdpol_daily_digest_notify_author_pre_notify',
				'source' => 'GD Topic Polls',
				'label'  => _x( "Digest Notify Author", "Email Detection Type", "d4plib" )
			),
			'gdpol-instant-notify'                                   => array(
				'action' => 'gdpol_instant_notify_pre_notify',
				'source' => 'GD Topic Polls',
				'label'  => _x( "Instant Notify", "Email Detection Type", "d4plib" )
			),
			'bbpress-new-reply-in-topic'                             => array(
				'action' => 'bbp_pre_notify_subscribers',
				'source' => 'bbPress',
				'label'  => _x( "New Reply In Topic", "Email Detection Type", "d4plib" )
			),
			'bbpress-new-topic-in-forum'                             => array(
				'action' => 'bbp_pre_notify_forum_subscribers',
				'source' => 'bbPress',
				'label'  => _x( "New Topic In Forum", "Email Detection Type", "d4plib" )
			),
			'gd-bbpress-toolbox-topic-auto-close'                    => array(
				'action' => 'bbp_pre_notify_topic_auto_close',
				'source' => 'GD bbPress Toolbox',
				'label'  => _x( "Topic Auto Close", "Email Detection Type", "d4plib" )
			),
			'gd-bbpress-toolbox-topic-manual-close'                  => array(
				'action' => 'bbp_pre_notify_topic_manual_close',
				'source' => 'GD bbPress Toolbox',
				'label'  => _x( "Topic Manual Close", "Email Detection Type", "d4plib" )
			),
			'gd-bbpress-toolbox-topic-edit'                          => array(
				'action' => 'bbp_pre_notify_topic_edit_subscribers',
				'source' => 'GD bbPress Toolbox',
				'label'  => _x( "Topic Edit", "Email Detection Type", "d4plib" )
			),
			'gd-bbpress-toolbox-reply-edit'                          => array(
				'action' => 'bbp_pre_notify_reply_edit_subscribers',
				'source' => 'GD bbPress Toolbox',
				'label'  => _x( "Reply Edit", "Email Detection Type", "d4plib" )
			),
			'gd-bbpress-toolbox-new-topic-moderators'                => array(
				'action' => 'bbp_pre_notify_new_topic_moderators',
				'source' => 'GD bbPress Toolbox',
				'label'  => _x( "New Topic Moderators", "Email Detection Type", "d4plib" )
			),
			'gd-bbpress-toolbox-new-reply-moderators'                => array(
				'action' => 'bbp_pre_notify_new_reply_moderators',
				'source' => 'GD bbPress Toolbox',
				'label'  => _x( "New Reply Moderators", "Email Detection Type", "d4plib" )
			),
			'wpmembers-custom'                                       => array(
				'source' => 'WP Members',
				'label'  => _x( "Custom", "Email Detection Type", "d4plib" )
			),
			'wpmembers-newreg'                                       => array(
				'source' => 'WP Members',
				'label'  => _x( "New User Registration", "Email Detection Type", "d4plib" )
			),
			'wpmembers-newmod'                                       => array(
				'source' => 'WP Members',
				'label'  => _x( "New User Registration Moderated", "Email Detection Type", "d4plib" )
			),
			'wpmembers-appmod'                                       => array(
				'source' => 'WP Members',
				'label'  => _x( "Registration Approved", "Email Detection Type", "d4plib" )
			),
			'wpmembers-repass'                                       => array(
				'source' => 'WP Members',
				'label'  => _x( "Password Reset", "Email Detection Type", "d4plib" )
			),
			'wpmembers-getuser'                                      => array(
				'source' => 'WP Members',
				'label'  => _x( "Retrieve Username", "Email Detection Type", "d4plib" )
			),
			'wpmembers-admin-notify'                                 => array(
				'filter' => 'wpmem_notify_filter',
				'source' => 'WP Members',
				'label'  => _x( "Admin Notification for User Registration", "Email Detection Type", "d4plib" )
			),
			'asgaros-subscriber-new-topic'                           => array(
				'filter' => 'asgarosforum_subscriber_mails_new_topic',
				'source' => 'Asgaros Forum',
				'label'  => _x( "New Topic Email", "Email Detection Type", "d4plib" )
			),
			'asgaros-subscriber-new-post'                            => array(
				'filter' => 'asgarosforum_subscriber_mails_new_post',
				'source' => 'Asgaros Forum',
				'label'  => _x( "New Post Email", "Email Detection Type", "d4plib" )
			),
			'rank-math-auto-update-email'                            => array(
				'filter' => 'rank_math/auto_update_email',
				'source' => 'Rank Math',
				'label'  => _x( "Auto Update Email", "Email Detection Type", "d4plib" )
			),
			'cf7-email'                                              => array(
				'source' => 'Contact Form 7',
				'label'  => _x( "Contact Email", "Email Detection Type", "d4plib" )
			),
			'buddypress-core-user-registration-with-blog'            => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Core User Registration With Blog", "Email Detection Type", "d4plib" )
			),
			'buddypress-core-user-registration'                      => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Core User Registration", "Email Detection Type", "d4plib" )
			),
			'buddypress-core-user-activation'                        => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Core User Activation", "Email Detection Type", "d4plib" )
			),
			'buddypress-bp-members-invitation'                       => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Core User Activation", "Email Detection Type", "d4plib" )
			),
			'buddypress-members-membership-request'                  => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Members Membership Request", "Email Detection Type", "d4plib" )
			),
			'buddypress-members-membership-request-rejected'         => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Members Membership Request Rejected", "Email Detection Type", "d4plib" )
			),
			'buddypress-friends-request'                             => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Friends Request", "Email Detection Type", "d4plib" )
			),
			'buddypress-friends-request-accepted'                    => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Friends Request Accepted", "Email Detection Type", "d4plib" )
			),
			'buddypress-activity-comment'                            => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Activity Comment", "Email Detection Type", "d4plib" )
			),
			'buddypress-activity-comment-author'                     => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Activity Comment Author", "Email Detection Type", "d4plib" )
			),
			'buddypress-messages-unread'                             => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Messages Unread", "Email Detection Type", "d4plib" )
			),
			'buddypress-settings-verify-email-change'                => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Settings Verify Email Change", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-details-updated'                      => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Details Updated", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-membership-request'                   => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Membership Request", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-membership-request-accepted'          => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Membership Request Accepted", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-membership-request-rejected'          => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Membership Request Rejected", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-membership-request-accepted-by-admin' => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Membership Request Accepted by Admin", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-membership-request-rejected-by-admin' => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Membership Request Rejected by Admin", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-member-promoted'                      => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Member Promoted", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-invitation'                           => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups Invitation", "Email Detection Type", "d4plib" )
			),
			'buddypress-groups-at-message'                           => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Groups At Message", "Email Detection Type", "d4plib" )
			),
			'buddypress-activity-at-message'                         => array(
				'source' => 'BuddyPress',
				'label'  => _x( "Activity At Message", "Email Detection Type", "d4plib" )
			)
		);
	}

	public function get_data( string $code ) {
		return $this->supported[ $code ] ?? array();
	}

	public function intercept_wp_mail( $atts ) {
		if ( is_string( $atts[ 'headers' ] ) && ! empty( $atts[ 'headers' ] ) ) {
			if ( strpos( $atts[ 'headers' ], 'X-WPCF7-Content-Type' ) !== false ) {
				$this->detection[ 'name' ] = 'cf7-email';
			}
		}

		return $atts;
	}

	public function intercept_buddypress( &$email, $email_type ) {
		$this->detection[ 'name' ] = 'buddypress-' . $email_type;
	}

	public function intercept_wp_members( $return ) {
		$this->detection[ 'name' ] = 'wpmembers-' . ( ! empty( $return[ 'tag' ] ) ? $return[ 'tag' ] : 'custom' );

		return $return;
	}

	public function intercept_filter( $return ) {
		$this->identify( current_filter(), 'filter' );

		return $return;
	}

	public function intercept_action() {
		$this->identify( current_action(), 'action' );
	}
}
