<?php
namespace Ari\Utils;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

class Options {
	function __construct( $options = array() ) {
		foreach ( $options as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
                $this->$key = $value;
            }
		}
	}
}
