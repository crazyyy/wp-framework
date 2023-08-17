<?php

namespace Dev4Press\Plugin\SweepPress\Base;

use Dev4Press\Plugin\SweepPress\Basic\Cache;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Query {
	protected $_group = '';

	public function __construct() {

	}

	protected function retrieve( string $name ) {
		return Cache::instance()->get( $this->_group, $name );
	}

	protected function store( string $name, array $data ) {
		Cache::instance()->add( $this->_group, $name, $data );
	}

	protected function clear( string $name ) {
		Cache::instance()->delete( $this->_group, $name );
	}
}
