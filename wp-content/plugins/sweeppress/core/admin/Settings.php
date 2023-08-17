<?php

namespace Dev4Press\Plugin\SweepPress\Admin;

use Dev4Press\v42\Core\Options\Element as EL;
use Dev4Press\v42\Core\Options\Settings as BaseSettings;
use Dev4Press\v42\Core\Options\Type;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings extends BaseSettings {
	protected function value( $name, $group = 'settings', $default = null ) {
		return sweeppress_settings()->get( $name, $group, $default );
	}

	protected function init() {
		$this->settings = array(
			'expand'   => array(
				'expand_cli'  => array(
					'name'     => __( "WP_CLI", "sweeppress" ),
					'kb'       => array(
						'url' => 'cleanup-with-the-wp-cli',
					),
					'sections' => array(
						array(
							'label'    => '',
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'settings', 'expand_cli', __( "Status", "sweeppress" ), __( "Integrate access to plugin sweepers into WP-CLI.", "sweeppress" ) . '<br/>' . __( "To get started with available commands, run the following CLI command:", "sweeppress" ) . '<br/><code>wp help sweeppress</code>', Type::BOOLEAN, $this->value( 'expand_cli' ) ),
							),
						),
					),
				),
				'expand_rest' => array(
					'name'     => __( "REST API", "sweeppress" ),
					'kb'       => array(
						'url' => 'cleanup-with-wp-rest-api',
					),
					'sections' => array(
						array(
							'label'    => '',
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'settings', 'expand_rest', __( "Status", "sweeppress" ), __( "Integrate access to plugin sweepers into WordPress REST API. To get data from endpoints or run DELETE operations, administrator account authentication is required!", "sweeppress" ) . '<br/>' . __( "The plugin adds new endpoint for all the sweeper controls:", "sweeppress" ) . '<br/><code>/sweeppress/v1/</code>', Type::BOOLEAN, $this->value( 'expand_rest' ) ),
							),
						),
					),
				),
			),
			'sweepers' => array(
				'sweepers_database'  => array(
					'name'     => __( "Database Optimization", "sweeppress" ),
					'sections' => array(
						array(
							'label'    => __( "Thresholds", "sweeppress" ),
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'sweepers', 'db_table_optimize_threshold', __( "Minimal Fragmentation", "sweeppress" ), __( "How much of free space database table takes compared to the data and index.", "sweeppress" ), Type::ABSINT, $this->value( 'db_table_optimize_threshold', 'sweepers' ) )->args( array(
									'max'        => 100,
									'min'        => 10,
									'label_unit' => '%',
								) ),
								EL::l( 'sweepers', 'db_table_optimize_min_size', __( "Minimal Table Size", "sweeppress" ), __( "The size of table includes usable space (data and index) and free space. If table size is smaller than value specified here, it will be skipped.", "sweeppress" ), Type::ABSINT, $this->value( 'db_table_optimize_min_size', 'sweepers' ) )->args( array(
									'min'        => 2,
									'label_unit' => 'MB',
								) ),
							),
						),
						array(
							'label'    => __( "Optimization", "sweeppress" ),
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'sweepers', 'db_table_optimize_method', __( "Method", "sweeppress" ), __( "There are different optimization methods that may have different effects on the optimization results and statistics reported. Some experts recommend using only ALTER FORCE method.", "sweeppress" ), Type::SELECT, $this->value( 'db_table_optimize_method', 'sweepers' ) )->data( 'array', array(
									'optimize' => "OPTIMIZE",
									'alter'    => 'ALTER FORCE',
									'both'     => 'OPTIMIZE + ALTER FORCE',
								) ),
							),
						),
					),
				),
				'sweepers_keep_days' => array(
					'name'     => __( "Number of days to skip", "sweeppress" ),
					'sections' => array(
						array(
							'label'    => __( "Posts", "sweeppress" ),
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'sweepers', 'keep_days_posts-auto-draft', __( "Auto Drafts", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_posts-auto-draft', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_posts-spam', __( "Spam Content", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_posts-spam', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_posts-trash', __( "Trash Content", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_posts-trash', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_posts-revisions', __( "Revisions", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_posts-revisions', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_posts-draft-revisions', __( "Revisions for Draft Posts", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_posts-draft-revisions', 'sweepers' ) ),
							),
						),
						array(
							'label'    => __( "Comments", "sweeppress" ),
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'sweepers', 'keep_days_comments-spam', __( "Spam Comments", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_comments-spam', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_comments-trash', __( "Trash Comments", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_comments-trash', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_comments-unapproved', __( "Unapproved Comments", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_comments-unapproved', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_comments-pingback', __( "Pingbacks", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_comments-pingback', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_comments-trackback', __( "Trackbacks", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_comments-trackback', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_comments-ua', __( "User Agents", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_comments-ua', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_comments-akismet', __( "Akismet Meta", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_comments-akismet', 'sweepers' ) ),
							),
						),
						array(
							'label'    => __( "User Signups", "sweeppress" ),
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'sweepers', 'keep_days_signups-inactive', __( "Inactive Signups", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_signups-inactive', 'sweepers' ) ),
							),
						),
						array(
							'label'    => __( "Action Scheduler", "sweeppress" ),
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'sweepers', 'keep_days_actionscheduler-log', __( "Log Entries", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_actionscheduler-log', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_actionscheduler-failed', __( "Failed Actions", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_actionscheduler-failed', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_actionscheduler-complete', __( "Complete Actions", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_actionscheduler-complete', 'sweepers' ) ),
								EL::l( 'sweepers', 'keep_days_actionscheduler-canceled', __( "Canceled Actions", "sweeppress" ), '', Type::ABSINT, $this->value( 'keep_days_actionscheduler-canceled', 'sweepers' ) ),
							),
						),
					),
				),
			),
			'performance' => array(
				'performance_estimates' => array(
					'name'     => __( "Sweeper Estimates", "sweeppress" ),
					'sections' => array(
						array(
							'label'    => '',
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'sweepers', 'estimated_mode_full', __( "Full Mode", "sweeppress" ), __( "Full mode will estimate data size along with the number of records. But, estimating size on the large database can increase the time needed for the estimates queries to run, and that can increase the time needed to show the overviews for the dashboard and the Sweep panel (and other relevant plugin features).", "sweeppress" ), Type::BOOLEAN, $this->value( 'estimated_mode_full', 'sweepers' ) ),
								EL::l( 'sweepers', 'estimated_cache', __( "Cache Estimates", "sweeppress" ), __( "Estimates will be cached to avoid running them too often. This cache will be stored for the period of 2 hours, or until the sweeper is used. For large database it is highly recommended to use this option.", "sweeppress" ), Type::BOOLEAN, $this->value( 'estimated_cache', 'sweepers' ) ),
							),
						),
					),
				),
			),
			'advanced' => array(
				'advanced_notices' => array(
					'name'     => __( "Plugin Notices", "sweeppress" ),
					'sections' => array(
						array(
							'label'    => '',
							'name'     => '',
							'class'    => '',
							'settings' => array(
								EL::l( 'settings', 'hide_backup_notices', __( "Backup Notice", "sweeppress" ), __( "On every page where the sweeping is available, plugin will show notice about creating backup before running the sweeping process. If you understand the requirements of making backups, you can disable this notice.", "sweeppress" ), Type::BOOLEAN, $this->value( 'hide_backup_notices' ) )->args( array( 'label' => __( "Hide the Notice", "sweeppress" ) ) ),
							),
						),
					),
				),
			),
		);

		if ( ! sweeppress_is_actionscheduler_active() ) {
			unset( $this->settings['sweepers']['sweepers_keep_days']['sections'][3] );
		}

		$this->settings = apply_filters( 'sweeppress_admin_internal_settings', $this->settings );
	}
}