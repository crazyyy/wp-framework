<?php
/**
 * This class configures the google analytics cache
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WGA_ConfigGACache extends Wbcr_FactoryClearfy206_Configurate {
	
	
	public function registerActionsAndFilters() {
		
		if ( $this->getPopulateOption( 'ga_cache' ) ) {
			add_filter( 'cron_schedules', array( $this, 'cron_additions' ) );
			
			// Load update script to schedule in wp_cron.
			add_action( 'wbcr/gac/update_analytic_library', array( $this, 'update_local_analytic' ) );
			
			if ( ! is_admin() ) {
				$this->add_google_analitics_script();
			}
		}
	}
	
	/**
	 * Extends the recurrence interval of cron tasks. In the core,
	 * the number of recurrence intervals for cron tasks is limited.
	 * Therefore, we create 3 additional recurrences weekly,
	 * twicemonthly, monthly.
	 *
	 * @param array $schedules an array of already recorded recurrences
	 *
	 * @return mixed
	 */
	public function cron_additions( $schedules ) {
		$schedules['weekly'] = array(
			'interval' => DAY_IN_SECONDS * 7,
			'display'  => __( 'Once Weekly' ),
		);
		
		$schedules['twicemonthly'] = array(
			'interval' => DAY_IN_SECONDS * 14,
			'display'  => __( 'Twice Monthly' ),
		);
		
		$schedules['monthly'] = array(
			'interval' => DAY_IN_SECONDS * 30,
			'display'  => __( 'Once Monthly' ),
		);
		
		return $schedules;
	}
	
	/**
	 * Enables update-local-ga.php, which creates and updates
	 * the Google analytics library locally on the user's site.
	 * This method performs via cron and manually if the library
	 * file has not yet been created.
	 *
	 * @since 3.0.1
	 * @return void
	 */
	public function update_local_analytic() {
		include( WGA_PLUGIN_DIR . '/includes/update-local-ga.php' );
	}
	
	/**
	 * Generates tracking code based on the user options set. Then it just
	 * prints this code on the page. The code can be printed to the header
	 * or footer, depending on which action called this method.
	 *
	 * @since 3.0.1
	 * @return void
	 */
	public function print_google_analytics() {
		
		$tracking_id = $this->getPopulateOption( 'ga_tracking_id' );
		$track_admin = $this->getPopulateOption( 'ga_track_admin' );
		
		// If user is admin we don't want to render the tracking code, when option is disabled.
		if ( empty( $tracking_id ) || ( current_user_can( 'manage_options' ) && ( ! $track_admin ) ) ) {
			return;
		}
		
		$adjusted_bounce_rate     = $this->getPopulateOption( 'ga_adjusted_bounce_rate', 0 );
		$anonymize_ip             = $this->getPopulateOption( 'ga_anonymize_ip', false );
		$disable_display_features = $this->getPopulateOption( 'ga_disable_display_features', false );
		
		echo "<!-- Google Analytics Local by " . $this->plugin->getPluginTitle() . " -->" . PHP_EOL;
		
		echo "<script>" . PHP_EOL;
		echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','" . WGA_PLUGIN_URL . "/cache/local-ga.js','ga');" . PHP_EOL;
		
		/**
		 * Allows you to complement the current configuration analytics.
		 * For example, one of the users wanted to add google adwords ID
		 * to this code.
		 *
		 * When using this action, you must enter only javascript code,
		 * without opening and closing tags.
		 *
		 * @since 3.0.1
		 */
		do_action( 'wbcr/gac/print_analytic_options', array(
			'tracking_id'              => $tracking_id,
			'track_admin'              => $track_admin,
			'adjusted_bounce_rate'     => $adjusted_bounce_rate,
			'anonymize_ip'             => $anonymize_ip,
			'disable_display_features' => $disable_display_features
		) );
		
		echo "ga('create', '" . $tracking_id . "', 'auto');" . PHP_EOL;
		echo $disable_display_features ? "ga('set', 'displayFeaturesTask', null);" . PHP_EOL : '';
		echo $anonymize_ip ? "ga('set', 'anonymizeIp', true);" . PHP_EOL : '';
		echo "ga('send', 'pageview');";
		echo $adjusted_bounce_rate ? PHP_EOL . 'setTimeout("ga(' . "'send','event','adjusted bounce rate','" . $adjusted_bounce_rate . " seconds')" . '"' . ',' . $adjusted_bounce_rate * 1000 . ');' : '';
		echo PHP_EOL . '</script>' . PHP_EOL;
		
		echo "<!-- end Google Analytics Local by " . $this->plugin->getPluginTitle() . " -->" . PHP_EOL;
	}
	
	/**
	 * Inserts tracking code in header and footer. Before insertion,
	 * it executes the wbcr_ga_update_local_script action to update
	 * Google local analytics library.
	 *
	 * @since 3.0.1
	 * @return void
	 */
	private function add_google_analitics_script() {
		$tracking_id = $this->getPopulateOption( 'ga_tracking_id' );
		
		if ( ! empty( $tracking_id ) ) {
			$local_ga_file = WGA_PLUGIN_DIR . '/cache/local-ga.js';
			// If file is not created yet, create now!
			if ( ! file_exists( $local_ga_file ) ) {
				ob_start();
				do_action( 'wbcr_ga_update_local_script' );
				ob_end_clean();
			}
			
			$enqueue_order = $this->getPopulateOption( 'ga_enqueue_order', 0 );
			
			if ( $this->getPopulateOption( 'ga_script_position', 'footer' ) == 'header' ) {
				add_action( 'wp_head', array( $this, 'print_google_analytics' ), $enqueue_order );
			} else {
				add_action( 'wp_footer', array( $this, 'print_google_analytics' ), $enqueue_order );
			}
		}
	}
}
