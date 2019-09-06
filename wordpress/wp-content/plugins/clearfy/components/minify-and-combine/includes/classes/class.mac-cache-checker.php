<?php
/**
 * CacheChecker - new in AO 2.0
 *
 * Daily cronned job (filter to change freq. + filter to disable).
 * Checks if cachesize is > 0.5GB (size is filterable), if so, an option is set which controls showing an admin notice.
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WMAC_PluginCacheChecker
 */
class WMAC_PluginCacheChecker
{
    const SCHEDULE_HOOK = 'wmac_cachechecker';

	/**
	 * WMAC_PluginCacheChecker constructor.
	 */
    public function __construct()
    {
    }

	/**
	 * Run
	 */
    public function run()
    {
	    if ( is_admin() ) {
		    $this->setup();
	    }
        $this->addHooks();
    }

	/**
	 * Add hooks
	 */
    public function addHooks()
    {
        add_action( self::SCHEDULE_HOOK, array( $this, 'cronjob' ) );
        add_action( 'admin_notices', array( $this, 'showAdminNotice' ) );
    }

	/**
	 * Setup
	 */
    public function setup()
    {
        $do_cache_check = (bool) apply_filters( 'wmac_filter_cachecheck_do', true );
        $schedule       = wp_get_schedule( self::SCHEDULE_HOOK );
        $frequency      = apply_filters( 'wmac_filter_cachecheck_frequency', 'daily' );
        if ( ! in_array( $frequency, array( 'hourly', 'daily', 'weekly', 'monthly' ) ) ) {
            $frequency = 'daily';
        }
        if ( $do_cache_check && ( ! $schedule || $schedule !== $frequency ) ) {
            wp_schedule_event( time(), $frequency, self::SCHEDULE_HOOK );
        } elseif ( $schedule && ! $do_cache_check ) {
            wp_clear_scheduled_hook( self::SCHEDULE_HOOK );
        }
    }

	/**
	 * Cron job
	 */
    public function cronjob()
    {
        $max_size       = (int) apply_filters( 'wmac_filter_cachecheck_maxsize', 536870912 );
        $do_cache_check = (bool) apply_filters( 'wmac_filter_cachecheck_do', true );
        $stat_array     = WMAC_PluginCache::stats();
        $cache_size     = round( $stat_array[1] );
        if ( ( $cache_size > $max_size ) && ( $do_cache_check ) ) {
            update_option( 'wmac_cachesize_notice', true );
            if ( apply_filters( 'wmac_filter_cachecheck_sendmail', true ) ) {
                $site_url  = esc_url( site_url() );
                $ao_mailto = apply_filters( 'wmac_filter_cachecheck_mailto', get_option( 'admin_email', '' ) );

                $ao_mailsubject = __( 'Мinify And Combine cache size warning', 'minify-and-combine' ) . ' (' . $site_url . ')';
                $ao_mailbody    = __( 'Мinify And Combine\'s cache size is getting big, consider purging the cache. Have a look at https://wordpress.org/plugins/ to see how you can keep the cache size under control.', 'minify-and-combine' ) . ' (site: ' . $site_url . ')';

                if ( ! empty( $ao_mailto ) ) {
                    $ao_mailresult = wp_mail( $ao_mailto, $ao_mailsubject, $ao_mailbody );
                    if ( ! $ao_mailresult ) {
                        error_log( 'Мinify And Combine could not send cache size warning mail.' );
                    }
                }
            }
        }

        // Nukes advanced cache clearing artifacts if they exists...
        WMAC_PluginCache::deleteAdvancedCacheClearArtifacts();
    }

	/**
	 * Notice
	 */
    public function showAdminNotice()
    {
        if ( (bool) get_option( 'wmac_cachesize_notice', false ) ) {
            echo '<div class="notice notice-warning"><p>';
            _e( '<strong>Мinify And Combine\'s cache size is getting big</strong>, consider purging the cache. Have a look at <a href="https://wordpress.org/plugins/" target="_blank" rel="noopener noreferrer">the Мinify And Combine FAQ</a> to see how you can keep the cache size under control.', 'minify-and-combine' );
            echo '</p></div>';
            update_option( 'wmac_cachesize_notice', false );
        }
    }
}
