<?php

namespace WBCR\Factory_Freemius_164\Sdk;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists('WBCR\Factory_Freemius_164\Sdk\Freemius_Exception') ) {
	exit;
}

if( !class_exists('WBCR\Factory_Freemius_164\Sdk\Freemius_OAuthException') ) {
	class Freemius_OAuthException extends Freemius_Exception {

		public function __construct($pResult)
		{
			parent::__construct($pResult);
		}
	}
}