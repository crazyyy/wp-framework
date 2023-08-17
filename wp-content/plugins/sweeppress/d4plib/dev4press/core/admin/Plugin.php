<?php

/*
Name:    Dev4Press\v42\Core\Admin\Plugin
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

namespace Dev4Press\v42\Core\Admin;

use Dev4Press\v42\Core\Quick\Sanitize;
use Dev4Press\v42\Core\UI\Enqueue;
use Dev4Press\v42\WordPress;
use WP_Screen;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Plugin {
	public $plugin = '';
	public $plugin_prefix = '';
	public $plugin_menu = '';
	public $plugin_title = '';
	public $plugin_blog = true;
	public $buy_me_a_coffee = false;
	public $plugin_network = false;
	public $plugin_settings = '';

	public $variant = 'core';

	public $menu_cap = 'activate_plugins';
	public $has_widgets = false;
	public $has_metabox = false;

	public $is_multisite = false;

	public $url = '';
	public $path = '';

	public $is_debug = false;
	public $auto_mod_interface_colors = false;
	public $auto_mod_install_update = true;

	public $page = false;
	public $panel = '';
	public $subpanel = '';

	public $screen_id = '';
	public $per_page_options = array();

	/** @var \Dev4Press\v42\Core\UI\Admin\Panel */
	public $object = null;

	/** @var \Dev4Press\v42\Core\UI\Enqueue */
	public $enqueue = null;

	public $enqueue_packed = true;
	public $enqueue_wp = array();
	public $menu_items = array();
	public $setup_items = array();
	public $page_ids = array();

	public function __construct() {
		if ( is_multisite() ) {
			$this->is_multisite = true;
		}

		$this->constructor();

		if ( $this->is_multisite ) {
			add_filter( 'network_admin_plugin_action_links', array( $this, 'plugin_actions' ), 10, 2 );
		}

		add_filter( 'plugin_action_links', array( $this, 'plugin_actions' ), 10, 2 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_links' ), 10, 2 );

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ), 20 );
		add_action( 'plugins_loaded', array( $this, 'plugins_preparation' ), 30 );
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ), 20 );

		add_filter( 'set-screen-option', array( $this, 'screen_options_save' ), 10, 3 );
	}

	/** @return static */
	public static function instance() {
		static $instance = array();

		if ( ! isset( $instance[ static::class ] ) ) {
			$instance[ static::class ] = new static();
		}

		return $instance[ static::class ];
	}

	public function screen() : WP_Screen {
		return get_current_screen();
	}

	public function plugins_loaded() {
		$this->is_debug = WordPress::instance()->is_script_debug();

		$this->enqueue = Enqueue::instance( $this );

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'current_screen', array( $this, 'current_screen' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function plugins_preparation() {
		add_action( 'admin_menu', array( $this, 'admin_menu_items' ), 1 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function plugin_actions( $links, $file ) {
		if ( $file == $this->plugin_name() ) {
			$settings_link = '<a href="' . esc_url( $this->main_url() ) . '">' . esc_html__( "Dashboard", "d4plib" ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	public function plugin_links( $links, $file ) {
		if ( $file == $this->plugin_name() ) {
			$links[] = '<a target="_blank" rel="noopener" href="' . esc_url( $this->settings()->i()->url() ) . '"><span class="dashicons dashicons-flag" aria-hidden="true" style="font-size: 16px; line-height: 1.3"></span>' . esc_html__( "Home Page", "d4plib" ) . '</a>';
			$links[] = '<a target="_blank" rel="noopener" href="https://support.dev4press.com/kb/product/' . esc_attr( $this->plugin ) . '/"><span class="dashicons dashicons-book-alt" aria-hidden="true" style="font-size: 16px; line-height: 1.3"></span>' . esc_html__( "Knowledge Base", "d4plib" ) . '</a>';
			$links[] = '<a target="_blank" rel="noopener" href="https://support.dev4press.com/forums/forum/plugins/' . esc_attr( $this->plugin ) . '/"><span class="dashicons dashicons-sos" aria-hidden="true" style="font-size: 16px; line-height: 1.3"></span>' . esc_html__( "Support Forum", "d4plib" ) . '</a>';

			if ( $this->buy_me_a_coffee ) {
				$links[] = '<a target="_blank" rel="noopener" href="https://www.buymeacoffee.com/millan"><span class="dashicons dashicons-coffee" aria-hidden="true" style="font-size: 16px; line-height: 1.3"></span>' . esc_html__( "Buy Me A Coffee", "d4plib" ) . '</a>';
			}
		}

		return $links;
	}

	public function admin_init() {
	}

	public function after_setup_theme() {
	}

	public function admin_menu_items() {
	}

	/**
	 * Generate filter or action handle for the specified name, prefixed with plugin prefix and admin.
	 *
	 * @param string $hook
	 *
	 * @return string
	 */
	public function h( string $hook ) : string {
		return $this->plugin_prefix . '_' . $hook;
	}

	/**
	 * Generate string to use for the postback or getback handler.
	 *
	 * @return string
	 */
	public function v() : string {
		return $this->plugin_prefix . '_handler';
	}

	/**
	 * Generate string to use for the form basic value name.
	 *
	 * @return string
	 */
	public function n() : string {
		return $this->plugin_prefix . '_value';
	}

	/**
	 * Return plugin prefix.
	 *
	 * @return string
	 */
	public function p() : string {
		return $this->plugin_prefix;
	}

	public function e() : ?Enqueue {
		return $this->enqueue;
	}

	/**
	 * Generate plugin name according to WordPress specification.
	 *
	 * @return string
	 */
	public function plugin_name() : string {
		return $this->plugin . '/' . $this->plugin . '.php';
	}

	/**
	 * Returns the name of the plugin.
	 *
	 * @return string
	 */
	public function title() : string {
		return $this->plugin_title;
	}

	public function admin_load_hooks() {
		foreach ( $this->page_ids as $id ) {
			add_action( 'load-' . $id, array( $this, 'load_admin_page' ) );
		}
	}

	public function load_admin_page() {
		$this->help_tab_sidebar();

		do_action( $this->plugin_prefix . '_load_admin_page' );

		if ( $this->panel !== false && $this->panel != '' ) {
			do_action( $this->h( 'load_admin_page_' . $this->panel ) );

			if ( $this->subpanel !== false && $this->subpanel != '' ) {
				do_action( $this->h( 'load_admin_page_' . $this->panel . '_' . $this->subpanel ) );
			}
		}

		$this->help_tab_getting_help();
	}

	public function help_tab_sidebar() {
		$links = apply_filters( $this->plugin_prefix . '_admin_help_sidebar_links', array(
			'home'  => '<a target="_blank" rel="noopener" href="https://plugins.dev4press.com/' . esc_attr( $this->plugin ) . '/">' . esc_html__( "Home Page", "d4plib" ) . '</a>',
			'kb'    => '<a target="_blank" rel="noopener" href="https://support.dev4press.com/kb/product/' . esc_attr( $this->plugin ) . '/">' . esc_html__( "Knowledge Base", "d4plib" ) . '</a>',
			'forum' => '<a target="_blank" rel="noopener" href="https://support.dev4press.com/forums/forum/plugins/' . esc_attr( $this->plugin ) . '/">' . esc_html__( "Support Forum", "d4plib" ) . '</a>'
		), $this );

		$this->screen()->set_help_sidebar( '<p><strong>' . $this->title() . '</strong></p><p>' . join( '<br/>', $links ) . '</p>' );
	}

	public function help_tab_getting_help() {
		do_action( $this->plugin_prefix . '_admin_help_tabs_before', $this );

		$this->screen()->add_help_tab(
			array(
				'id'      => 'd4p-plugin-help-info',
				'title'   => esc_html__( "Help & Support", "d4plib" ),
				'content' => '<h2>' . esc_html__( "Help & Support", "d4plib" ) . '</h2><p>' . esc_html( sprintf( __( "To get help with %s, you can start with Knowledge Base list of frequently asked questions, user guides, articles (tutorials) and reference guide (for developers).", "d4plib" ), $this->title() ) ) .
				             '</p><p><a href="https://support.dev4press.com/kb/product/' . esc_attr( $this->plugin ) . '/" class="button-primary" target="_blank" rel="noopener">' . esc_html__( "Knowledge Base", "d4plib" ) . '</a> <a href="https://support.dev4press.com/forums/forum/plugins/' . esc_attr( $this->plugin ) . '/" class="button-secondary" target="_blank">' . esc_html__( "Support Forum", "d4plib" ) . '</a></p>'
			)
		);

		$this->screen()->add_help_tab(
			array(
				'id'      => 'd4p-plugin-help-bugs',
				'title'   => esc_html__( "Found a bug?", "d4plib" ),
				'content' => '<h2>' . esc_html__( "Found a bug?", "d4plib" ) . '</h2><p>' . esc_html( sprintf( __( "If you find a bug in %s, you can report it in the support forum.", "d4plib" ), $this->title() ) ) .
				             '</p><p>' . esc_html__( "Before reporting a bug, make sure you use latest plugin version, your website and server meet system requirements. And, please be as descriptive as possible, include server side logged errors, or errors from browser debugger.", "d4plib" ) .
				             '</p><p><a href="https://support.dev4press.com/forums/forum/plugins/' . esc_attr( $this->plugin ) . '/" class="button-primary" target="_blank" rel="noopener">' . esc_html__( "Open new topic", "d4plib" ) . '</a></p>'
			)
		);

		do_action( $this->plugin_prefix . '_admin_help_tabs', $this );
	}

	public function install_or_update() : bool {
		if ( $this->auto_mod_install_update ) {
			$install = $this->settings()->is_install();
			$update  = $this->settings()->is_update();

			if ( $install ) {
				$this->panel = 'install';
			} else if ( $update ) {
				$this->panel = 'update';
			}

			return $install || $update;
		}

		return false;
	}

	public function svg_icon() : string {
		return '';
	}

	public function global_admin_notices() {
		if ( $this->settings()->is_install() ) {
			add_action( 'admin_notices', array( $this, 'install_notice' ) );
		}

		if ( $this->settings()->is_update() ) {
			add_action( 'admin_notices', array( $this, 'update_notice' ) );
		}
	}

	public function install_notice() {
		if ( current_user_can( 'install_plugins' ) && $this->page === false ) {
			echo '<div class="notice notice-info is-dismissible"><p>';
			echo esc_html( sprintf( __( "%s is activated and it needs to finish installation.", "d4plib" ), $this->title() ) );
			echo ' <a href="' . esc_url( $this->main_url() ) . '">' . esc_html__( "Click Here", "d4plib" ) . '</a>.';
			echo '</p></div>';
		}
	}

	public function update_notice() {
		if ( current_user_can( 'install_plugins' ) && $this->page === false ) {
			echo '<div class="notice notice-info is-dismissible"><p>';
			echo esc_html( sprintf( __( "%s is updated, and you need to review the update process.", "d4plib" ), $this->title() ) );
			echo ' <a href="' . esc_url( $this->main_url() ) . '">' . esc_html__( "Click Here", "d4plib" ) . '</a>.';
			echo '</p></div>';
		}
	}

	public function panel_object() : object {
		if ( isset( $this->setup_items[ $this->panel ] ) ) {
			return (object) $this->setup_items[ $this->panel ];
		} else if ( isset( $this->menu_items[ $this->panel ] ) ) {
			return (object) $this->menu_items[ $this->panel ];
		}

		return $this->default_panel_object();
	}

	public function enqueue_scripts( $hook ) {
		$this->register_scripts_and_styles();

		if ( $this->page ) {
			$this->e()->wp( $this->enqueue_wp );

			do_action( $this->h( 'enqueue_scripts_early' ) );

			$this->e()->js( 'shared' )->js( 'admin' );

			if ( $this->enqueue_packed ) {
				$this->e()->css( 'pack' );
			} else {
				$this->e()->css( 'font' )
				     ->css( 'shared' )
				     ->css( 'grid' )
				     ->css( 'admin' )
				     ->css( 'options' );
			}

			if ( $this->e()->is_rtl() ) {
				$this->e()->css( 'rtl' );
			}

			$this->extra_enqueue_scripts_plugin();

			do_action( $this->h( 'enqueue_scripts' ), $this->panel );
		}

		if ( $this->has_widgets && $hook == 'widgets.php' ) {
			$this->e()->js( 'widgets' );
			$this->e()->css( 'widgets' )->css( 'font' );

			$this->extra_enqueue_scripts_widgets( $hook );

			do_action( $this->h( 'enqueue_scripts_widgets' ) );
		}

		if ( $this->has_metabox && ( $hook == 'post.php' || $hook == 'post-new.php' ) ) {
			if ( $this->is_metabox_available() ) {
				$this->e()->js( 'ctrl' )->js( 'meta' );
				$this->e()->css( 'ctrl' )->css( 'meta' )->css( 'font' );

				$this->extra_enqueue_scripts_metabox( $hook );

				do_action( $this->h( 'enqueue_scripts_metabox' ), $hook );
			}
		}

		if ( $hook == 'edit.php' ) {
			$this->extra_enqueue_scripts_postslist( $hook );

			do_action( $this->h( 'enqueue_scripts_postslist' ), $hook );
		}

		$this->extra_enqueue_scripts_final( $hook );

		do_action( $this->h( 'enqueue_scripts_final' ), $hook, $this );
	}

	public function admin_panel() {
		$this->object->prepare();
		$this->object->show();
	}

	public function lib_path() : string {
		return $this->path . 'd4plib/';
	}

	public function panels() : array {
		return $this->setup_items + $this->menu_items;
	}

	public function message_process( $code, $msg ) {
		return $msg;
	}

	public function export_url( $run = 'export', $nonce = null ) : string {
		$nonce = is_null( $nonce ) ? 'dev4press-plugin-' . $this->plugin_prefix : $nonce;

		$url = $this->panel_url( 'tools' );

		$url = add_query_arg( $this->v(), 'getback', $url );
		$url = add_query_arg( 'run', $run, $url );

		return add_query_arg( '_wpnonce', wp_create_nonce( $nonce ), $url );
	}

	public function get_post_type() {
		$post_type = '';

		if ( isset( $_GET[ 'post_type' ] ) ) {
			$post_type = Sanitize::key( $_GET[ 'post_type' ] );
		} else {
			global $post;

			if ( $post ) {
				$post_type = $post->post_type;
			}
		}

		if ( $post_type == '' ) {
			global $typenow;

			$post_type = $typenow;
		}

		return $post_type;
	}

	public function getback_url( $args = array() ) : string {
		$url = $this->current_url();
		$url = add_query_arg( $this->v(), 'getback', $url );

		return add_query_arg( $args, $url );
	}

	public function is_plugin_panel() : bool {
		return ! empty( $this->panel );
	}

	public function is_plugin_subpanel() : bool {
		return ! empty( $this->subpanel );
	}

	public function is_metabox_available() : bool {
		return true;
	}

	protected function screen_setup() {
		$this->install_or_update();
		$this->load_post_get_back();

		$panel = $this->panel_object();
		$class = $panel->class;

		$this->object = $class::instance( $this );

		$this->subpanel = $this->object->validate_subpanel( $this->subpanel );
	}

	protected function default_panel_object() : object {
		return (object) array(
			'default' => true,
			'icon'    => 'ui-cog',
			'title'   => __( "Panel", "d4plib" ),
			'info'    => __( "Information", "d4plib" )
		);
	}

	protected function load_post_get_back() {
		if ( isset( $_POST[ $this->v() ] ) && Sanitize::key( $_POST[ $this->v() ] ) == 'postback' ) {
			$this->run_postback();
		} else if ( isset( $_GET[ $this->v() ] ) && Sanitize::key( $_GET[ $this->v() ] ) == 'getback' ) {
			$this->run_getback();
		}
	}

	protected function register_scripts_and_styles() {
	}

	protected function extra_enqueue_scripts_plugin() {
	}

	protected function extra_enqueue_scripts_widgets( $hook ) {
	}

	protected function extra_enqueue_scripts_metabox( $hook ) {
	}

	protected function extra_enqueue_scripts_postslist( $hook ) {
	}

	protected function extra_enqueue_scripts_final( $hook ) {
	}

	abstract public function main_url();

	abstract public function current_url( $with_subpanel = true );

	abstract public function panel_url( $panel = 'dashboard', $subpanel = '', $args = '', $network = null );

	abstract public function admin_menu();

	abstract public function current_screen( $screen );

	abstract public function constructor();

	abstract public function run_getback();

	abstract public function run_postback();

	/** @return \Dev4Press\v42\Core\Plugins\Settings */
	abstract public function settings();

	/** @return \Dev4Press\v42\Core\Plugins\Core */
	abstract public function plugin();

	abstract public function settings_definitions();

	public function features_definitions( $feature ) {

	}

	public function screen_options_save( $status, $option, $value ) {
		if ( in_array( $option, $this->per_page_options ) ) {
			return absint( $value );
		}

		return $status;
	}
}
