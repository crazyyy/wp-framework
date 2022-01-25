<?php
/* Security-Check */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class pbsfi_upgrade
{
	/** @var pbSEOFriendlyImages */
	protected $pbSEOFriendlyImages;

	/** @var string Current DB Version */
	var $current_dbv;

	public function __construct( pbSEOFriendlyImages $pbSEOFriendlyImages )
	{
		$this->pbSEOFriendlyImages = $pbSEOFriendlyImages;

		// get DB version
		$this->current_dbv = get_option( $this->pbSEOFriendlyImages->option_name_dbv );

		// If there is no dbv option it must be version 3.x.x or prior
		if( ! $this->current_dbv ) {
			$this->current_dbv = '3.0.0';
		}
	}

	public function maybe_do_upgrade()
	{
		if( version_compare($this->current_dbv, $this->pbSEOFriendlyImages->db_version, '<') ) {
			return $this->_upgrade_3xx_to_4xx();
		}

		// false could mean: No upgrade needed or upgrade has failed
		return false;
	}

	protected function _upgrade_3xx_to_4xx ()
	{
		$settings_v3 = $this->v3_settings();
		$upgrade_3xx_to_4xx = update_option($this->pbSEOFriendlyImages->option_name, $settings_v3);

		if( $upgrade_3xx_to_4xx ) {
			update_option($this->pbSEOFriendlyImages->option_name_dbv, $this->pbSEOFriendlyImages->db_version);

			$this->v3_clean_db();

			return true;
		}
	}

	public function v3_settings()
	{
		return array(
			'optimize_img' => get_option('pbsfi_optimize_img', 'all'),
			'sync_method' => get_option('pbsfi_sync_method', 'both'),
			'override_alt' => get_option('pbsfi_override_alt', false),
			'override_title' => get_option('pbsfi_override_title', false),
			'alt_scheme' => get_option('pbsfi_alt_scheme', '%name - %title'),
			'title_scheme' => get_option('pbsfi_title_scheme', '%title'),
			'pbsfi_enable_caching' => get_option('pbsfi_enable_caching', false),
			'pbsfi_enable_caching_ttl' => get_option('pbsfi_enable_caching_ttl', 86400),
			'enable_lazyload' => get_option('pbsfi_enable_lazyload', true),
			'enable_lazyload_acf' => get_option('pbsfi_enable_lazyload_acf', true),
			'enable_lazyload_styles' => get_option('pbsfi_enable_lazyload_styles', false),
			'lazyload_threshold' => get_option('pbsfi_lazyload_threshold', false),
			'wc_title' => get_option('pbsfi_wc_title', false),
			'wc_sync_method' => get_option('pbsfi_wc_sync_method', false),
			'wc_override_alt' => get_option('pbsfi_wc_override_alt', false),
			'wc_override_title' => get_option('pbsfi_wc_override_title', false),
			'wc_alt_scheme' => get_option('pbsfi_wc_alt_scheme', false),
			'wc_title_scheme' => get_option('pbsfi_wc_title_scheme', false),
			'disable_srcset' => get_option('pbsfi_disable_srcset', false),
			'link_title' => get_option('pbsfi_link_title', false),
			'encoding' => get_option('pbsfi_encoding', false),
			'encoding_mode' => get_option('pbsfi_encoding_mode', false)
		);
	}

	protected function v3_clean_db()
	{
		delete_option('pbsfi_optimize_img');
		delete_option('pbsfi_sync_method');
		delete_option('pbsfi_override_alt');
		delete_option('pbsfi_override_title');
		delete_option('pbsfi_alt_scheme');
		delete_option('pbsfi_title_scheme');
		delete_option('pbsfi_enable_caching');
		delete_option('pbsfi_enable_caching_ttl');
		delete_option('pbsfi_enable_lazyload');
		delete_option('pbsfi_enable_lazyload_acf');
		delete_option('pbsfi_enable_lazyload_styles');
		delete_option('pbsfi_lazyload_threshold');
		delete_option('pbsfi_wc_title');
		delete_option('pbsfi_wc_sync_method');
		delete_option('pbsfi_wc_override_alt');
		delete_option('pbsfi_wc_override_title');
		delete_option('pbsfi_wc_alt_scheme');
		delete_option('pbsfi_wc_title_scheme');
		delete_option('pbsfi_disable_srcset');
		delete_option('pbsfi_link_title');
		delete_option('pbsfi_encoding');
		delete_option('pbsfi_encoding_mode');
	}
}