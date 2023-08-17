<?php

namespace Dev4Press\Plugin\SweepPress\Admin;

use Dev4Press\Plugin\SweepPress\Basic\Plugin as CorePlugin;
use Dev4Press\Plugin\SweepPress\Basic\Settings as CoreSettings;
use Dev4Press\Plugin\SweepPress\Table\Sweepers;
use Dev4Press\v42\Core\Admin\Menu\Plugin as BasePlugin;
use Dev4Press\v42\Core\Quick\URL;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin extends BasePlugin {
	public $plugin = 'sweeppress';
	public $plugin_prefix = 'sweeppress';
	public $plugin_menu = 'SweepPress';
	public $plugin_title = 'SweepPress';

	public $has_metabox = true;
	public $auto_mod_interface_colors = true;

	public $enqueue_wp = array( 'dialog' => true );

	public function constructor() {
		$this->url  = SWEEPPRESS_URL;
		$this->path = SWEEPPRESS_PATH;

		add_action( 'sweeppress_plugin_core_ready', array( $this, 'ready' ) );

		add_action( 'load-sweeppress_page_sweeppress-sweepers', array( $this, 'screen_options_sweepers' ) );
	}

	public function settings() : CoreSettings {
		return sweeppress_settings();
	}

	public function plugin() : CorePlugin {
		return CorePlugin::instance();
	}

	public function settings_definitions() : Settings {
		return Settings::instance();
	}

	public function ready() {
	}

	public function admin_menu_items() {
		$this->setup_items = array(
			'install' => array(
				'title' => __( "Install", "sweeppress" ),
				'icon'  => 'ui-traffic',
				'type'  => 'setup',
				'info'  => __( "Before you continue, make sure plugin installation was successful.", "sweeppress" ),
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Install',
			),
			'update'  => array(
				'title' => __( "Update", "sweeppress" ),
				'icon'  => 'ui-traffic',
				'type'  => 'setup',
				'info'  => __( "Before you continue, make sure plugin was successfully updated.", "sweeppress" ),
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Update',
			),
		);

		$this->menu_items = array(
			'dashboard'  => array(
				'title' => __( "Overview", "sweeppress" ),
				'icon'  => 'ui-home',
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Dashboard',
			),
			'about'      => array(
				'title' => __( "About", "sweeppress" ),
				'icon'  => 'ui-info',
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\About',
			),
			'sweep'      => array(
				'title' => __( "Sweep", "sweeppress" ),
				'icon'  => 'plugin-sweeppress',
				'info'  => __( "Detailed view for all the available Sweeper tools with additional information about each tool.", "sweeppress" ),
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Sweep',
			),
			'statistics' => array(
				'title' => __( "Statistics", "sweeppress" ),
				'icon'  => 'ui-chart-area',
				'info'  => __( "Overview of the statistics gathered by the plugin with all time and monthly statistics.", "sweeppress" ),
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Statistics',
			),
			'settings'   => array(
				'title' => __( "Settings", "sweeppress" ),
				'icon'  => 'ui-cog',
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Settings',
			),
			'sweepers'   => array(
				'title' => __( "Sweepers List", "sweeppress" ),
				'icon'  => 'ui-list',
				'info'  => __( "List of all current sweepers, and where they can be used from.", "sweeppress" ),
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Sweepers',
			),
			'tools'      => array(
				'title' => __( "Tools", "sweeppress" ),
				'icon'  => 'ui-wrench',
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Tools',
			),
			'jobs'       => array(
				'title' => __( "Upgrade", "sweeppress" ) . ' <span style="color: #FFF; background: red; padding: 1px 5px 3px; border-radius: 3px; margin-left: 5px;">Pro</span>',
				'icon'  => 'ui-clock',
				'info'  => __( "Get more features with the SweepPress Pro version.", "sweeppress" ),
				'class' => '\\Dev4Press\\Plugin\\SweepPress\\Admin\\Panel\\Jobs',
				'kb'    => array(
					'url'   => URL::add_campaign_tracking( 'https://plugins.dev4press.com/sweeppress/lite-vs-pro/', 'sweeppress-upgrade-to-pro' ),
					'label' => 'Compare Lite vs Pro',
				),
			),
		);
	}

	public function action_url( $action, $nonce, $args = '', $panel = '', $subpanel = '', $network = null ) : string {
		$base = empty( $panel ) ? $this->current_url() : $this->panel_url( $panel, $subpanel, $network );
		$base = add_query_arg(
			array(
				$this->v()      => 'getback',
				'single-action' => $action,
				'_wpnonce'      => wp_create_nonce( $nonce ),
			),
			$base
		);

		if ( ! empty( $args ) ) {
			$base .= '&' . trim( $args, '&' );
		}

		return $base;
	}

	public function svg_icon() : string {
		return sweeppress()->svg_icon;
	}

	public function run_getback() {
		new GetBack( $this );
	}

	public function run_postback() {
		new PostBack( $this );
	}

	public function message_process( $code, $msg ) {
		switch ( $code ) {
			case 'job-run':
				$msg['message'] = __( "CRON job has been executed.", "sweeppress" );
				break;
			case 'job-deleted':
				$msg['message'] = __( "CRON job has been removed.", "sweeppress" );
				break;
			case 'job-cleared':
				$msg['message'] = __( "All instances of the CRON job have been removed.", "sweeppress" );
				break;
			case 'cache-purged':
				$msg['message'] = __( "Cached data has been purged.", "sweeppress" );
				break;
		}

		return $msg;
	}

	public function register_scripts_and_styles() {
		$this->enqueue->register( 'css', 'sweeppress-admin',
			array(
				'path' => 'css/',
				'file' => 'admin',
				'ext'  => 'css',
				'min'  => true,
				'ver'  => sweeppress_settings()->file_version(),
				'src'  => 'plugin',
			) )->register( 'js', 'sweeppress-admin',
			array(
				'path' => 'js/',
				'file' => 'admin',
				'ext'  => 'js',
				'min'  => true,
				'ver'  => sweeppress_settings()->file_version(),
				'src'  => 'plugin',
				'req'  => array( 'jquery', 'jquery-form' ),
			) );
	}

	public function screen_options_sweepers() {
		new Sweepers();
	}

	public function help_tab_getting_help() {
		if ( ! empty( $this->panel ) ) {
			Help::instance();
		}

		parent::help_tab_getting_help();
	}

	protected function extra_enqueue_scripts_plugin() {
		$this->enqueue->css( 'sweeppress-admin' )->js( 'sweeppress-admin' );
	}
}
