<?php

/*
Name:    Dev4Press\v42\Core\Scope
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

namespace Dev4Press\v42\Core;

use Dev4Press\v42\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Scope {
	/**
	 * @var string
	 */
	private $scope;

	/**
	 * @var bool
	 */
	private $multisite;

	/**
	 * @var bool
	 */
	private $admin = false;
	/**
	 * @var bool
	 */
	private $network_admin = false;
	/**
	 * @var bool
	 */
	private $user_admin = false;
	/**
	 * @var bool
	 */
	private $blog_admin = false;

	/**
	 * @var bool
	 */
	private $frontend = false;

	/**
	 * @var int
	 */
	private $blog_id;

	public function __construct() {
		$this->multisite = is_multisite();
		$this->blog_id   = get_current_blog_id();

		if ( WordPress::instance()->is_cli() ) {
			$this->scope = 'cli';
		} else {
			if ( is_admin() ) {
				$this->admin = true;

				if ( is_blog_admin() ) {
					$this->blog_admin = true;
				} else if ( is_network_admin() ) {
					$this->network_admin = true;
				} else if ( is_user_admin() ) {
					$this->user_admin = true;
				}
			} else {
				$this->frontend = true;
			}

			if ( is_network_admin() ) {
				$this->scope = 'network';
			} else {
				$this->scope = 'blog';
			}
		}
	}

	public static function instance() : Scope {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Scope();
		}

		return $instance;
	}

	public function is_multisite() : bool {
		return $this->multisite;
	}

	public function is_admin() : bool {
		return $this->admin;
	}

	public function is_network_admin() : bool {
		return $this->network_admin;
	}

	public function is_master_network_admin() : bool {
		return ! $this->is_multisite() || $this->is_network_admin();
	}

	public function is_user_admin() : bool {
		return $this->user_admin;
	}

	public function is_multisite_blog_admin( int $blog_id = 0 ) : bool {
		if ( ! $this->is_multisite() ) {
			return false;
		}

		$blog_id = absint( $blog_id );

		if ( $blog_id == 0 ) {
			return $this->blog_admin;
		} else {
			return $this->blog_admin && $this->blog_id = $blog_id;
		}
	}

	public function is_blog_admin( int $blog_id = 0 ) : bool {
		$blog_id = absint( $blog_id );

		if ( $blog_id == 0 ) {
			return $this->blog_admin;
		} else {
			return $this->blog_admin && $this->blog_id = $blog_id;
		}
	}

	public function is_frontend( int $blog_id = 0 ) : bool {
		$blog_id = absint( $blog_id );

		if ( $blog_id == 0 ) {
			return $this->frontend;
		} else {
			return $this->frontend && $this->blog_id = $blog_id;
		}
	}

	public function is_main_blog( int $blog_id = 0 ) : bool {
		if ( $this->multisite ) {
			$blog_id = $blog_id == 0 ? $this->blog_id : $blog_id;

			return $blog_id == get_main_site_id();
		}

		return true;
	}

	public function is_scope_cli() : bool {
		return $this->scope === 'cli';
	}

	public function get_blog_id() : int {
		return $this->blog_id;
	}

	public function get_scope() : string {
		return $this->scope;
	}

	public function scope() : array {
		return array(
			'is_multisite'            => $this->is_multisite(),
			'is_frontend'             => $this->is_frontend(),
			'is_admin'                => $this->is_admin(),
			'is_blog_admin'           => $this->is_blog_admin(),
			'is_user_admin'           => $this->is_user_admin(),
			'is_network_admin'        => $this->is_network_admin(),
			'is_master_network_admin' => $this->is_master_network_admin(),
			'is_multisite_blog_admin' => $this->is_multisite_blog_admin(),
			'blog_id'                 => $this->get_blog_id(),
			'scope'                   => $this->get_scope()
		);
	}
}
