<?php
defined( 'ABSPATH' ) or die( 'Access forbidden!' );

if ( ! class_exists( 'Ari_Loader' ) )
	require_once dirname( __FILE__ ) . '/class-ari-loader.php';

Ari_Loader::register_prefix( 'Ari', dirname( __FILE__ ) . '/core' );
