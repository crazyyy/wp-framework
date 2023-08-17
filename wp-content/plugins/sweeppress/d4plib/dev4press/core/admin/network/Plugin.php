<?php

namespace Dev4Press\v42\Core\Admin\Network;

use Dev4Press\v42\Core\Admin\Menu\Plugin as BasePlugin;
use Dev4Press\v42\Core\Quick\Sanitize;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Plugin extends BasePlugin {
	public $plugin_network = true;

	public function plugins_preparation() {
		$blog_menus = true;

		if ( $this->is_multisite ) {
			if ( is_network_admin() ) {
				add_action( 'network_admin_menu', array( $this, 'admin_menu_items' ), 1 );
				add_action( 'network_admin_menu', array( $this, 'admin_menu' ) );

				$blog_menus = false;
			} else {
				if ( ! $this->plugin_blog ) {
					$blog_menus = false;
				}
			}
		}

		if ( $blog_menus ) {
			parent::plugins_preparation();
		}
	}

	public function global_admin_notices() {
		$blog_notices = true;

		if ( $this->is_multisite ) {
			if ( $this->settings()->is_install() ) {
				add_action( 'network_admin_notices', array( $this, 'install_notice' ) );
			}

			if ( $this->settings()->is_update() ) {
				add_action( 'network_admin_notices', array( $this, 'update_notice' ) );
			}

			if ( $this->plugin_settings == 'network-only' ) {
				$blog_notices = false;
			}
		}

		if ( $blog_notices ) {
			parent::global_admin_notices();
		}
	}

	public function current_screen( $screen ) {
		if ( $this->is_multisite && is_network_admin() ) {
			$this->screen_id = $screen->id;

			$parts = explode( '_page_', $this->screen_id, 2 );
			if ( isset( $parts[ 1 ] ) ) {
				$parts[ 1 ] = substr( $parts[ 1 ], 0, strlen( $parts[ 1 ] ) - 8 );
				$panel      = substr( $parts[ 1 ], 0, strlen( $this->plugin ) ) == $this->plugin ? substr( $parts[ 1 ], strlen( $this->plugin ) + 1 ) : '';

				if ( ! empty( $panel ) ) {
					if ( isset( $this->menu_items[ $panel ] ) ) {
						$this->page  = true;
						$this->panel = $panel;

						if ( ! empty( $_GET[ 'subpanel' ] ) ) {
							$this->subpanel = Sanitize::slug( $_GET[ 'subpanel' ] );
						}

						$this->screen_setup();
					}
				}

				$this->global_admin_notices();
			}
		} else {
			parent::current_screen( $screen );
		}
	}
}
