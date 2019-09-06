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
 * Класс для хранения данных инсталла(сайта) freemius
 * @author Webcraftic <jokerov@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */
class WCL_FS_Site extends WCL_FS_ScopeEntity {
	
	/**
	 * @var number
	 */
	public $site_id;
	
	/**
	 * @var string
	 */
	public $public_key;
	
	/**
	 * @var string
	 */
	public $secret_key;
	
	/**
	 * @var number
	 */
	public $plugin_id;
	/**
	 * @var number
	 */
	public $user_id;
	/**
	 * @var string
	 */
	public $title;
	/**
	 * @var string
	 */
	public $url;
	/**
	 * @var string
	 */
	public $version;
	/**
	 * @var string E.g. en-GB
	 */
	public $language;
	/**
	 * @var string E.g. UTF-8
	 */
	public $charset;
	/**
	 * @var string Platform version (e.g WordPress version).
	 */
	public $platform_version;
	/**
	 * Freemius SDK version
	 *
	 * @author Leo Fajardo (@leorw)
	 * @since  1.2.2
	 *
	 * @var string SDK version (e.g.: 1.2.2)
	 */
	public $sdk_version;
	/**
	 * @var string Programming language version (e.g PHP version).
	 */
	public $programming_language_version;
	/**
	 * @var number|null
	 */
	public $plan_id;
	/**
	 * @var number|null
	 */
	public $license_id;
	/**
	 * @var number|null
	 */
	public $trial_plan_id;
	/**
	 * @var string|null
	 */
	public $trial_ends;
	/**
	 * @since 1.0.9
	 *
	 * @var bool
	 */
	public $is_premium = false;
	/**
	 * @author Leo Fajardo (@leorw)
	 *
	 * @since  1.2.1.5
	 *
	 * @var bool
	 */
	public $is_disconnected = false;
	/**
	 * @since  2.0.0
	 *
	 * @var bool
	 */
	public $is_active = true;
	/**
	 * @since  2.0.0
	 *
	 * @var bool
	 */
	public $is_uninstalled = false;
	
	/**
	 * @param stdClass|bool $site
	 */
	function __construct( $site = false ) {
		parent::__construct( $site );
		
		if ( is_object( $site ) and isset( $site->plan_id ) ) {
			$this->plan_id = $site->plan_id;
		}
		
		if ( ! is_bool( $this->is_disconnected ) ) {
			$this->is_disconnected = false;
		}
		
		$props = wcl_fs_get_object_public_vars( $this );
		
		foreach ( $props as $key => $def_value ) {
			$this->{$key} = isset( $site->{'install_' . $key} ) ? $site->{'install_' . $key} : $def_value;
		}
		if ( isset ( $site->install_id ) ) {
			$this->site_id = $site->install_id;
		}
	}
	
	static function get_type() {
		return 'install';
	}
}
