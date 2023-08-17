<?php

/*
Name:    Dev4Press\v42\Core\Task\AJAX
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

namespace Dev4Press\v42\Core\Task;

use Dev4Press\v42\Core\Quick\Sanitize;
use Dev4Press\v42\Core\Quick\WPR;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class AJAX {
	protected $transient = '';
	protected $action = '';
	protected $nonce = '';
	protected $priv = false;
	protected $timeout = 20;

	protected $data = array();
	protected $messages = array();

	protected $timer = 0;

	public function __construct() {
		add_action( 'wp_ajax_' . $this->action, array( $this, 'handler' ) );

		if ( $this->priv ) {
			add_action( 'wp_ajax_nopriv_' . $this->action, array( $this, 'handler' ) );
		}
	}

	/** @return static */
	public static function instance() {
		static $instance = array();

		if ( ! isset( $instance[ static::class ] ) ) {
			$instance[ static::class ] = new static();
		}

		return $instance[ static::class ];
	}

	public function check_nonce() {
		$ajax_nonce = isset( $_REQUEST[ '_ajax_nonce' ] ) ? Sanitize::key( $_REQUEST[ '_ajax_nonce' ] ) : '';
		$nonce      = wp_verify_nonce( $ajax_nonce, $this->nonce );

		if ( $nonce === false ) {
			wp_die( - 1 );
		}
	}

	public function handler() {
		$this->check_nonce();
		$this->get();

		$this->timer = microtime( true );

		@ini_set( 'memory_limit', '256M' );
		@set_time_limit( 0 );

		$operation = isset( $_POST[ 'operation' ] ) ? Sanitize::key( $_POST[ 'operation' ] ) : '';
		$response  = array();

		switch ( $operation ) {
			case 'start':
				$this->do_start();

				$this->message( __( "Process is starting.", "d4plib" ) );

				$this->save();

				$response[ 'total' ] = $this->data[ 'total' ];
				break;
			case 'break':
				$this->do_break();

				$this->message( __( "Process has been interrupted by user.", "d4plib" ) );

				$this->delete();
				break;
			case 'stop':
				$this->do_stop();

				$this->message( __( "Process has completed.", "d4plib" ) );

				$this->delete();
				break;
			case 'run':
				$this->do_run();

				$this->message( sprintf( __( "Completed %s out of %s items.", "d4plib" ), $this->data[ 'done' ], $this->data[ 'total' ] ) );

				$this->save();

				$response[ 'done' ] = $this->data[ 'done' ];
				break;
		}

		$response[ 'message' ] = join( D4P_EOL, $this->messages );

		WPR::json_die( $response );
	}

	protected function init_data() : array {
		return array(
			'data'     => array(),
			'messages' => array(),
			'total'    => 0,
			'done'     => 0
		);
	}

	protected function message( $msg ) {
		$this->data[ 'messages' ][] = $msg;
		$this->messages[]           = $msg;
	}

	protected function get() {
		$this->data = get_transient( $this->transient );

		if ( $this->data === false ) {
			$this->data = $this->init_data();
		}
	}

	protected function save() {
		set_transient( $this->transient, $this->data );
	}

	protected function delete() {
		delete_transient( $this->transient );
	}

	protected function time_passed() {
		return microtime( true ) - $this->timer;
	}

	abstract protected function do_start();

	abstract protected function do_break();

	abstract protected function do_stop();

	abstract protected function do_run();
}
