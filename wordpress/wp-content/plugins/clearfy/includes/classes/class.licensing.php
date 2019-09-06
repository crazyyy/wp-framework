<?php
/**
 * Class for working with the licensing system
 *
 * @author Webcraftic
 * Developed: Evgeniy Jokerov <jokerov@gmail.com>, Edited: Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_Licensing {
	
	/**
	 * @var int plugin number in the freemius service
	 */
	private $plugin_id;
	
	/**
	 * @var string plugin private key
	 */
	private $plugin_public_key;
	
	/**
	 * @var string plugin slug
	 */
	private $plugin_slug;
	
	/**
	 * @var string install_url - url to install addons freemius
	 */
	//private $install_url = 'https://clearfy.pro/zip/zip.php';
	
	/**
	 * @var WCL_Licensing
	 */
	private static $_instance;
	
	/**
	 * @var array license data store
	 */
	private $storage = array();
	
	/**
	 * @var WCL_FreemiusWPApi
	 */
	private $user_api;
	
	/**
	 * @var WCL_FreemiusWPApi
	 */
	private $site_api;
	
	/**
	 * Getting a licensing system
	 *
	 * @return WCL_Licensing
	 */
	static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new WCL_Licensing;
		}
		
		return self::$_instance;
	}
	
	/**
	 * Initialization of the licensing system
	 *
	 */
	private function __construct() {
		
		$this->plugin_id         = defined( 'WBCR_CLR_LICENSING_ID' ) ? WBCR_CLR_LICENSING_ID : WCL_Plugin::app()->getPluginInfoAttr( 'freemius_plugin_id' );
		$this->plugin_public_key = defined( 'WBCR_CLR_LICENSING_KEY' ) ? WBCR_CLR_LICENSING_KEY : WCL_Plugin::app()->getPluginInfoAttr( 'freemius_public_key' );
		$this->plugin_slug       = defined( 'WBCR_CLR_LICENSING_SLUG' ) ? WBCR_CLR_LICENSING_SLUG : WCL_Plugin::app()->getPluginInfoAttr( 'freemius_plugin_slug' );
		
		$this->storage = new WCL_Licensing_Storage;
	}
	
	
	/**
	 * Returns a storage object
	 *
	 * @return WCL_Licensing_Storage
	 */
	public function getStorage() {
		return $this->storage;
	}
	
	/**
	 * Returns the plugin api object
	 *
	 * @return WCL_FreemiusWPApi
	 */
	public function getPluginApi() {
		return new WCL_FreemiusWPApi( 'plugin',  // scope
			$this->plugin_id, // element_id
			$this->plugin_public_key, //public key
			$this->plugin_public_key, false );
	}
	
	/**
	 * Returns addi api object
	 *
	 * @return WCL_FreemiusWPApi
	 */
	public function getAddonApi( $addon ) {
		return new WCL_FreemiusWPApi( 'plugin',  // scope
			$addon->id, // element_id
			$addon->public_key, //public key
			false, false );
	}
	
	/**
	 * Returns the api object of the installer
	 *
	 * @return WCL_FreemiusWPApi
	 * @throws \WCL\LicenseException
	 */
	public function getSiteApi() {
		
		if ( isset( $this->site_api ) ) {
			return $this->site_api;
		}
		
		$site = $this->storage->getSite();
		
		if ( ! $site || empty( $site ) ) {
			$this->storage->flush();
			throw new WCL\LicenseException( 'Information about the site does not exist.' );
		}
		
		$this->site_api = new WCL_FreemiusWPApi( 'install',  // scope
			$site->site_id, // element_id
			$site->public_key, //public key
			$site->secret_key, false );
		
		return $this->site_api;
	}
	
	/**
	 * Returns the user api object
	 *
	 * @return WCL_FreemiusWPApi
	 * @throws \WCL\LicenseException
	 */
	public function getUserApi() {
		if ( isset( $this->user_api ) ) {
			return $this->user_api;
		}
		
		$user = $this->storage->getUser();
		
		if ( ! $user || empty( $user ) ) {
			$this->storage->flush();
			throw new WCL\LicenseException( 'Information about the user does not exist.' );
		}
		
		$this->user_api = new WCL_FreemiusWPApi( 'user',  // scope
			$user->id, // element_id
			$user->public_key, //public key
			$user->secret_key, false );
		
		return $this->user_api;
	}
	
	/**
	 * Deactivates current license
	 *
	 * @throws \WCL\LicenseException
	 * @return bool
	 */
	public function deactivate() {
		$site            = $this->storage->getSite();
		$current_license = $this->storage->getLicense();
		
		if ( ! $current_license || empty( $current_license->id ) ) {
			return false;
		}
		
		$license = $this->getSiteApi()->Api( '/licenses/' . $current_license->id . '.json?license_key=' . $current_license->secret_key, 'DELETE' );
		
		if ( isset( $license->error ) ) {
			throw new WCL\LicenseException( $license->error->message );
		}
		
		$install = $this->getUserApi()->Api( '/plugins/' . $this->plugin_id . '/installs.json?ids=' . $site->site_id, 'DELETE' );
		
		if ( isset( $install->error ) ) {
			throw new WCL\LicenseException( $install->error->message );
		}
		
		$this->storage->flush();
		
		$this->user_api = null;
		$this->site_api = null;
		
		if ( wp_next_scheduled( 'wbcr_clearfy_license_autosync' ) ) {
			wp_clear_scheduled_hook( 'wbcr_clearfy_license_autosync' );
		}
		
		return true;
	}
	
	/**
	 * @return bool
	 * @throws \WCL\LicenseException
	 */
	public function uninstall() {
		try {
			if ( ! $this->deactivate() ) {
				return false;
			}
		} catch( WCL\LicenseException $e ) {
			throw new WCL\LicenseException( $e->getMessage() );
		}
		
		return true;
	}
	
	/**
	 * Synchronizes current license data
	 *
	 * @return bool
	 * @throws \WCL\LicenseException
	 */
	public function sync() {
		$current_license = $this->storage->getLicense();
		
		if ( ! $current_license || empty( $current_license->id ) ) {
			return false;
		}
		
		$site = $this->storage->getSite();
		
		$api_install = $this->getSiteApi();
		$api_user    = $this->getUserApi();
		
		$license = $api_install->Api( '/licenses/' . $current_license->id . '.json?license_key=' . urlencode( $current_license->secret_key ), 'GET' );
		
		if ( isset( $license->error ) ) {
			throw new WCL\LicenseException( $license->error->message );
		}
		
		$install = $api_user->Api( '/plugins/' . $this->plugin_id . '/installs.json?ids=' . $site->site_id, 'GET' );
		
		if ( isset( $install->error ) ) {
			throw new WCL\LicenseException( $install->error->message );
		}
		
		if ( $install->installs[0]->license_id !== $current_license->id ) {
			$this->uninstall();
			
			return true;
		}
		
		$subscriptions = $api_install->Api( '/licenses/' . $current_license->id . '/subscriptions.json', 'GET' );
		
		if ( isset( $subscriptions->error ) ) {
			throw new WCL\LicenseException( $subscriptions->error->message );
		}
		
		$plan = $api_user->Api( '/plugins/' . $this->plugin_id . '/plans/' . $current_license->plan_id . '.json', 'GET' );
		
		if ( isset( $plan->error ) ) {
			throw new WCL\LicenseException( $plan->error->message );
		}
		
		$current_license->plan_title = $plan->title;
		
		if ( isset( $subscriptions->subscriptions ) and isset( $subscriptions->subscriptions[0] ) ) {
			if ( ! is_null( $subscriptions->subscriptions[0]->next_payment ) ) {
				$current_license->billing_cycle = $subscriptions->subscriptions[0]->billing_cycle;
			}
		}
		
		$current_license->sync( $license );
		
		$this->storage->setLicense( $current_license );
		$this->storage->save();
		
		$this->getAddons( true );
		
		return true;
	}
	
	/**
	 * Unsubscribes from a paid subscription to updates
	 *
	 * @return bool
	 * @throws \WCL\LicenseException
	 */
	public function unsubscribe() {
		$current_license = $this->storage->getLicense();
		
		try {
			$api_install = $this->getSiteApi();
		} catch( WCL\LicenseException $e ) {
			throw new WCL\LicenseException( $e->getMessage() );
		}
		
		$subscriptions = $api_install->Api( '/licenses/' . $current_license->id . '/subscriptions.json', 'GET' );
		
		if ( isset( $subscriptions->subscriptions ) and isset( $subscriptions->subscriptions[0] ) ) {
			$api_install->Api( 'downgrade.json', 'PUT' );
			$current_license->billing_cycle = null;
			
			$this->storage->setLicense( $current_license );
			$this->storage->save();
		}
		
		return true;
	}
	
	/**
	 * Activates the license
	 *
	 * @param string $license_key license key
	 *
	 * @return bool
	 * @throws WCL\LicenseException
	 */
	public function activate( $license_key ) {
		$current_license = $this->storage->getLicense();
		
		if ( $current_license && ! empty( $current_license->secret_key ) ) {
			if ( $current_license->secret_key == $license_key ) {
				if ( $this->sync() ) {
					return true;
				}
			}
			$this->deactivate();
		}
		
		$url          = 'https://wp.freemius.com/action/service/user/install/';
		$unique_id    = md5( get_site_url() . SECURE_AUTH_KEY );
		$request_body = array(
			'plugin_slug'                  => $this->plugin_slug,
			'plugin_id'                    => $this->plugin_id,
			'plugin_public_key'            => $this->plugin_public_key,
			'plugin_version'               => WCL_Plugin::app()->getPluginVersion(),
			'is_active'                    => true,
			'is_premium'                   => true,
			'format'                       => 'json',
			'is_disconnected'              => false,
			'license_key'                  => $license_key,
			'site_url'                     => get_home_url(), //site_uid
			'site_uid'                     => $unique_id,
			'language'                     => get_bloginfo( 'language' ),
			'charset'                      => get_bloginfo( 'charset' ),
			'platform_version'             => get_bloginfo( 'version' ),
			'sdk_version'                  => '2.1.1',
			'programming_language_version' => phpversion(),
		);
		
		$responce = wp_remote_post( $url, array(
			'body'    => $request_body,
			'timeout' => 15,
		) );
		
		if ( is_wp_error( $responce ) ) {
			throw new WCL\LicenseException( $responce->get_error_message(), 'alert-danger' );
		}
		
		if ( isset( $responce['response']['code'] ) and $responce['response']['code'] == 403 ) {
			throw new WCL\LicenseException( 'Freemius 403 error.', 'alert-danger' );
		}
		
		$responce_data = json_decode( $responce['body'] );
		
		if ( isset( $responce_data->error ) ) {
			throw new WCL\LicenseException( $responce_data->error );
		}
		
		$user = new WCL_FS_User( $responce_data );
		$site = new WCL_FS_Site( $responce_data );
		
		$this->storage->setUser( $user );
		$this->storage->setSite( $site );
		
		$api_user    = $this->getUserApi();
		$api_install = $this->getSiteApi();
		
		$user_licensies = $api_user->Api( '/plugins/' . $this->plugin_id . '/licenses.json', 'GET' );
		
		if ( isset( $user_licensies->error ) ) {
			throw new WCL\LicenseException( $user_licensies->error->message );
		}
		
		foreach ( $user_licensies->licenses as $user_license ) {
			if ( $user_license->secret_key == $license_key ) {
				$current_license = new WCL_FS_Plugin_License( $user_license );
			}
		}
		
		if ( ! $current_license ) {
			throw new WCL\LicenseException( 'Unknown error. The license key is not registered for the current user.' );
		}
		
		$plan = $api_user->Api( '/plugins/' . $this->plugin_id . '/plans/' . $current_license->plan_id . '.json', 'GET' );
		
		if ( isset( $plan->error ) ) {
			throw new WCL\LicenseException( $plan->error->message );
		}
		
		$subscriptions = $api_install->Api( '/licenses/' . $current_license->id . '/subscriptions.json', 'GET' );
		
		if ( isset( $subscriptions->error ) ) {
			throw new WCL\LicenseException( $subscriptions->error->message );
		}
		
		$current_license->plan_title = $plan->title;
		
		if ( isset( $subscriptions->subscriptions ) and isset( $subscriptions->subscriptions[0] ) ) {
			$current_license->billing_cycle = $subscriptions->subscriptions[0]->billing_cycle;
		}
		
		$this->storage->setLicense( $current_license );
		$this->storage->save();
		
		if ( ! wp_next_scheduled( 'wbcr_clearfy_license_autosync' ) ) {
			wp_schedule_event( time(), 'twicedaily', 'wbcr_clearfy_license_autosync' );
		}
		
		return true;
	}
	
	/**
	 * Checks if current license has expired
	 * @return bool
	 */
	public function isLicenseValid() {
		$current_license = $this->storage->getLicense();
		
		if ( ! $current_license || ! isset( $current_license->id ) ) {
			return false;
		}
		
		return $current_license->is_valid();
	}
	
	/**
	 * Gets plugin addons. Caches for a day
	 *
	 * @param bool $flush_cache if true, creates a request to bypass the cache
	 *
	 * @return stdClass addons list
	 */
	
	public function getAddons( $flush_cache = false ) {
		$addons             = WCL_Plugin::app()->getPopulateOption( 'freemius_addons', array() );
		$addons_last_update = WCL_Plugin::app()->getPopulateOption( 'freemius_addons_last_update', 0 );
		
		$next_update = $addons_last_update + DAY_IN_SECONDS;
		
		if ( ( $flush_cache or date( 'U' ) > $next_update ) || defined( 'WCL_PLUGIN_FREEMIUS_DEBUG' ) && WCL_PLUGIN_FREEMIUS_DEBUG ) {
			$api_plugin = $this->getPluginApi();
			$addons     = $api_plugin->Api( '/addons.json?enriched=true' );
			
			WCL_Plugin::app()->updatePopulateOption( 'freemius_addons_last_update', date( 'U' ) );
			
			if ( $addons and isset( $addons->plugins ) ) {
				WCL_Plugin::app()->updatePopulateOption( 'freemius_addons', $addons );
			}
		}
		
		return $addons;
	}
	
	public function getAddonData( $slug ) {
		$freemius_addons_data      = $this->getAddons();
		$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
		if ( isset( $freemius_addons_data->plugins ) ) {
			foreach ( $freemius_addons_data->plugins as $freemius_addon ) {
				if ( $freemius_addon->slug == $slug ) {
					$addon_data = array(
						'addon'      => $freemius_addon,
						'slug'       => $freemius_addon->slug,
						'is_actived' => in_array( $freemius_addon->slug, $freemius_activated_addons ) ? true : false,
						'is_free'    => $freemius_addon->free_releases_count ? true : false,
						'url'        => isset( $freemius_addon->info ) ? $freemius_addon->info->url : '#',
					);
					
					return $addon_data;
				}
			}
		}
		
		return false;
	}
	
	public function isActivePaidAddons() {
		$freemius_addons_data      = $this->getAddons();
		$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
		if ( isset( $freemius_addons_data->plugins ) ) {
			foreach ( $freemius_addons_data->plugins as $freemius_addon ) {
				if ( ! $freemius_addon->free_releases_count ) {
					if ( in_array( $freemius_addon->slug, $freemius_activated_addons ) ) {
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Returns addon data received from freemus service
	 *
	 * @param string $slug addon slug
	 *
	 * @return stdClass|bool object with addon description or false
	 */
	public function getFreemiusAddonData( $slug ) {
		$addons = $this->getAddons();
		foreach ( $addons->plugins as $addon ) {
			if ( $addon->slug == $slug ) {
				return $addon;
			}
		}
		
		return false;
	}
	
	public function getAddonCurrentVersion( $slug ) {
		$package_plugin = WCL_Package::instance();
		$addon          = $package_plugin->getAddon( $slug );
		if ( $addon ) {
			return $addon['current_version'];
		}
		
		return false;
	}
	
	/**
	 * Activates addon
	 *
	 * @param string $slug addon slug
	 *
	 * @return bool
	 */
	
	public function activateAddon( $slug ) {
		$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
		
		if ( ! in_array( $slug, $freemius_activated_addons ) ) {
			$freemius_activated_addons[] = $slug;
		}
		
		$freemius_activated_addons = $this->filteringExistsAddons( $freemius_activated_addons );
		
		do_action( 'wbcr_clearfy_pre_activate_component', $slug );
		
		WCL_Plugin::app()->updatePopulateOption( 'freemius_activated_addons', $freemius_activated_addons );
		
		return true;
	}
	
	/**
	 * Deactivates addon
	 *
	 * @param string $slug add-on slug
	 *
	 * @return bool
	 */
	
	public function deactivateAddon( $slug ) {
		$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
		
		if ( in_array( $slug, $freemius_activated_addons ) ) {
			foreach ( $freemius_activated_addons as $key => $component ) {
				if ( $component == $slug ) {
					unset( $freemius_activated_addons[ $key ] );
				}
			}
		}
		
		do_action( 'wbcr_clearfy_pre_deactivate_component', $slug );
		
		WCL_Plugin::app()->updatePopulateOption( 'freemius_activated_addons', $freemius_activated_addons );
		
		do_action( 'wbcr_clearfy_deactivated_component', $slug );
		
		return true;
	}
	
	/**
	 * Filters activated add-ons
	 * Filtering is needed to ensure that in activated add-ons there are only those that are in the service of Freemius
	 * Old add-ons will be filtered and will not fall on the assembly.
	 *
	 * @param array $freemius_activated_addons активированные аддоны
	 *
	 * @return array $freemius_activated_addons_filtered
	 */
	public function filteringExistsAddons( $freemius_activated_addons ) {
		$freemius_addons                    = $this->getAddons();
		$freemius_activated_addons_filtered = array();
		
		foreach ( $freemius_addons->plugins as $addon ) {
			if ( in_array( $addon->slug, $freemius_activated_addons ) ) {
				$freemius_activated_addons_filtered[] = $addon->slug;
			}
		}
		
		return $freemius_activated_addons_filtered;
	}
}

	
