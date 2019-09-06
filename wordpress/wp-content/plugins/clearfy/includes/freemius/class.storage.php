<?php

/**
 * Licensing Data Class
 * @author Webcraftic <jokerov@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_Licensing_Storage {
	
	/**
	 * @var array
	 */
	private $license = array();
	
	/**
	 * @var array
	 */
	private $user = array();
	
	/**
	 * @var array
	 */
	private $site = array();
	
	/**
	 * Storage Initialization
	 *
	 */
	public function __construct() {
		$this->load();
	}
	
	/**
	 * Loading data from storage
	 *
	 */
	public function load() {
		$new_license_storage = WCL_Plugin::app()->getPopulateOption( 'license', false );
		
		if ( is_array( $new_license_storage ) ) {
			if ( isset( $new_license_storage['user'] ) && ! empty( $new_license_storage['user'] ) ) {
				$this->user = $new_license_storage['user'];
			}
			if ( isset( $new_license_storage['site'] ) && ! empty( $new_license_storage['site'] ) ) {
				$this->site = $new_license_storage['site'];
			}
			if ( isset( $new_license_storage['license'] ) && ! empty( $new_license_storage['license'] ) ) {
				$this->license = $new_license_storage['license'];
			}
		}
	}
	
	/**
	 * Get site license info
	 *
	 * @return WCL_FS_Plugin_License|null
	 */
	public function getLicense() {
		if ( isset( $this->license ) && ! empty( $this->license ) ) {
			$license = new stdClass;
			
			foreach ( $this->license as $key => $prop ) {
				$license->$key = $prop;
			}
			
			return new WCL_FS_Plugin_License( $license );
		}
		
		return null;
	}
	
	/**
	 * Get site info
	 *
	 * @return WCL_FS_Site|null
	 */
	public function getSite() {
		if ( isset( $this->site ) && ! empty( $this->site ) ) {
			$site = new stdClass;
			
			foreach ( $this->site as $key => $prop ) {
				$site->$key = $prop;
			}
			
			return new WCL_FS_Site( $site );
		}
		
		return null;
	}
	
	/**
	 * Get user info
	 *
	 * @return WCL_FS_User|null
	 */
	public function getUser() {
		if ( isset( $this->user ) && ! empty( $this->user ) ) {
			$user = new stdClass;
			
			foreach ( $this->user as $key => $prop ) {
				$user->$key = $prop;
			}
			
			return new WCL_FS_User( $user );
		}
		
		return null;
	}
	
	/**
	 * Set user attrs
	 *
	 * @param WCL_FS_User $user
	 */
	public function setUser( WCL_FS_User $user ) {
		$available_attrs = get_object_vars( $user );
		
		foreach ( $available_attrs as $attr => $value ) {
			$this->user[ $attr ] = $user->$attr;
		}
	}
	
	/**
	 * Set site attrs
	 *
	 * @param WCL_FS_Site $site
	 */
	public function setSite( WCL_FS_Site $site ) {
		$available_attrs = get_object_vars( $site );
		
		foreach ( $available_attrs as $attr => $value ) {
			$this->site[ $attr ] = $site->$attr;
		}
	}
	
	/**
	 * Sets license attrs
	 *
	 * @param WCL_FS_Plugin_License $license
	 */
	public function setLicense( WCL_FS_Plugin_License $license ) {
		$available_attrs = get_object_vars( $license );
		
		foreach ( $available_attrs as $attr => $value ) {
			$this->license[ $attr ] = $license->$attr;
		}
	}
	
	/**
	 * Removes the value of their repository.
	 *
	 * @param string $property available properties user, site, license
	 *
	 * @return bool
	 */
	public function delete( $property ) {
		if ( empty( $property ) || ! in_array( $property, array( 'user', 'site', 'license' ) ) ) {
			return false;
		}
		
		$this->$property = array();
		
		return true;
	}
	
	/**
	 * Сlears all license data from storage
	 */
	public function flush() {
		$this->delete( 'site' );
		$this->delete( 'license' );
		$this->delete( 'user' );
		$this->save();
	}
	
	/**
	 * Saving data
	 */
	public function save() {
		//WCL_Plugin::app()->updatePopulateOption( 'licensestorage', $this->storage );
		
		WCL_Plugin::app()->updatePopulateOption( 'license', array(
			'user'    => $this->user,
			'site'    => $this->site,
			'license' => $this->license
		) );
	}
}
