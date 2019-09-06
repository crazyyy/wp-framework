<?php
/**
 * @package     Freemius
 * @copyright   Copyright (c) 2015, Freemius, Inc.
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 * @since       1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Класс для хранения данных пользователя с freemius
 * @author Webcraftic <jokerov@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */
class WCL_FS_User extends WCL_FS_ScopeEntity {
	
	/**
	 * @var int
	 */
	public $id;
	
	/**
	 * @var string
	 */
	public $public_key;
	
	/**
	 * @var string
	 */
	public $secret_key;
	
	/**
	 * @var string
	 */
	public $email;
	/**
	 * @var string
	 */
	public $first;
	/**
	 * @var string
	 */
	public $last;
	/**
	 * @var bool
	 */
	public $is_verified;
	/**
	 * @var string|null
	 */
	public $customer_id;
	/**
	 * @var float
	 */
	public $gross;
	
	
	/**
	 * @param object|bool $user
	 */
	public function __construct( $user = false ) {
		parent::__construct( $user );
		$props = wcl_fs_get_object_public_vars( $this );
		
		foreach ( $props as $key => $def_value ) {
			$this->{$key} = isset( $user->{'user_' . $key} ) ? $user->{'user_' . $key} : $def_value;
		}
	}
	
	public function get_name() {
		return trim( ucfirst( trim( is_string( $this->first ) ? $this->first : '' ) ) . ' ' . ucfirst( trim( is_string( $this->last ) ? $this->last : '' ) ) );
	}
	
	public function is_verified() {
		return ( isset( $this->is_verified ) && true === $this->is_verified );
	}
	
	static function get_type() {
		return 'user';
	}
}
