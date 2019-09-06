<?php

/**
 * The page Settings.
 *
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_ClearfySettingsPage extends Wbcr_FactoryClearfy206_PageBase {

	/**
	 * The id of the page in the admin menu.
	 *
	 * Mainly used to navigate between pages.
	 *
	 * @since 1.0.0
	 * @see   FactoryPages410_AdminPage
	 *
	 * @var string
	 */
	public $id = "clearfy_settings";

	/**
	 * @var string
	 */
	public $page_parent_page = 'none';

	/**
	 * @var string
	 */
	public $page_menu_dashicon = 'dashicons-list-view';

	/**
	 * @var bool
	 */
	public $available_for_multisite = true;

	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		$this->menu_title                  = __( 'Clearfy Settings', 'clearfy' );
		$this->page_menu_short_description = __( 'Useful tweaks', 'clearfy' );

		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}


	/**
	 * Requests assets (js and css) for the page.
	 *
	 * @since 1.0.0
	 * @return void
	 * @see   FactoryPages410_AdminPage
	 *
	 */
	public function assets( $scripts, $styles ) {
		parent::assets( $scripts, $styles );

		$this->scripts->add( WCL_PLUGIN_URL . '/admin/assets/js/general.js' );

		$params = [
			'import_options_nonce' => wp_create_nonce( 'wbcr_clearfy_import_options' ),
			'i18n'                 => [
				'success_update_settings' => __( 'Settings successfully updated!', 'clearfy' ),
				'unknown_error'           => __( 'During the setup, an unknown error occurred, please try again or contact the plugin support.', 'clearfy' ),
			]
		];

		wp_localize_script( 'jquery', 'wbcr_clearfy_ajax', $params );
	}

	/**
	 * Permalinks options.
	 *
	 * @since 1.0.0
	 * @return mixed[]
	 */
	public function getPageOptions() {

		$options = [];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __( 'Advanced settings', 'clearfy' ) . '</strong>' . '<p>' . __( 'This group of settings allows you to configure the work of the Clearfy plugin.', 'clearfy' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'disable_clearfy_extra_menu',
			'title'   => __( 'Disable menu in adminbar', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'red' ],
			'hint'    => __( 'This setting allows you to disable the additional menu of the Clearfy plugin, in the admin bar. This menu is required to work with the Minify and Combine and Assets Manager components.', 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'complete_uninstall',
			'title'   => __( 'Complete Uninstall', 'clearfy' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( "When the plugin is deleted from the Plugins menu, also delete all plugin settings.", 'clearfy' ),
			'default' => false
		];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __( 'Import/Export', 'clearfy' ) . '</strong>' . '<p>' . __( 'This group of settings allows you to configure the work of the Clearfy plugin.', 'clearfy' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type' => 'html',
			'html' => [ $this, 'export' ]
		];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-clearfy-group-header">' . '<strong>' . __( 'Support', 'clearfy' ) . '</strong>' . '<p>' . __( 'This group of settings allows you to configure the work of the Clearfy plugin.', 'clearfy' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type' => 'html',
			'html' => [ $this, 'supports' ]
		];

		$formOptions = [];

		$formOptions[] = [
			'type'  => 'form-group',
			'items' => $options,
			//'cssClass' => 'postbox'
		];

		return apply_filters( 'wbcr/clearfy/settings_form_options', $formOptions, $this );
	}

	public function export() {
		?>
        <div class="wbcr-clearfy-export-import">
            <p>
                <label for="wbcr-clearfy-import-export">
                    <strong><?php _e( 'Import/Export settings', 'clearfy' ) ?></strong>
                </label>
                <textarea id="wbcr-clearfy-import-export"><?= WCL_Helper::getExportOptions(); ?></textarea>
                <button class="button wbcr-clearfy-import-options-button"><?php _e( 'Import options', 'clearfy' ) ?></button>
            </p>
        </div>
		<?php
	}

	public function supports() {
		?>
        <div class="wbcr-clearfy-troubleshooting">
            <p><?php _e( 'If you faced with any issues, please follow the steps below to get quickly quality support:', 'clearfy' ) ?></p>
            <ol>
                <li>
                    <p><?php _e( 'Generate a debug report which will contains inforamtion about your configuratin and installed plugins', 'clearfy' ) ?></p>
                    <p>
                        <a href="<?= $this->getActionUrl( 'gererate_report' ); ?>" class="button"><?php _e( 'Generate Debug Report', 'clearfy' ) ?></a>
                    </p>
                </li>
                <li>
                    <p><?php printf( __( 'Create a new ticket in our <a href="%s" target="_blank">support forum</a>, include the debug report into the message body.', 'clearfy' ), "https://forum.webcraftic.com" ); ?></p>
                </li>
            </ol>
            <p style="margin-bottom: 0px;"><?php _e( 'We guarantee to respond you within 7 business day.', 'clearfy' ) ?></p>
        </div>
		<?php
	}

	/**
	 * Collects error and system error data
	 *
	 * @return string
	 */
	public function getDebugReport() {
		$run_time     = number_format( microtime( true ), 3 );
		$pps          = number_format( 1 / floatval( $run_time ), 0 );
		$memory_avail = ini_get( 'memory_limit' );
		$memory_used  = number_format( memory_get_usage( true ) / ( 1024 * 1024 ), 2 );
		$memory_peak  = number_format( memory_get_peak_usage( true ) / ( 1024 * 1024 ), 2 );

		$debug = '';
		if ( PHP_SAPI == 'cli' ) {
			// if run for command line, display some info
			$debug = PHP_EOL . "======================================================================================" . PHP_EOL . " Config: php " . phpversion() . " " . php_sapi_name() . " / zend engine " . zend_version() . PHP_EOL . " Load: {$memory_avail} (avail) / {$memory_used}M (used) / {$memory_peak}M (peak)" . "  | Time: {$run_time}s | {$pps} req/sec" . PHP_EOL . "  | Server Timezone: " . date_default_timezone_get() . "  | Agent: CLI" . PHP_EOL . "======================================================================================" . PHP_EOL;
		} else {
			// if not run from command line, only display if debug is enabled
			$debug = "" //<hr />"
			         . "<div style=\"text-align: left;\">" . "<hr />" . " Config: " . "<br />" . " &nbsp;&nbsp; | php " . phpversion() . " " . php_sapi_name() . " / zend engine " . zend_version() . "<br />" . " &nbsp;&nbsp; | Server Timezone: " . date_default_timezone_get() . "<br />" . " Load: " . "<br />" . " &nbsp;&nbsp; | Memory: {$memory_avail} (avail) / {$memory_used}M (used) / {$memory_peak}M (peak)" . "<br />" . " &nbsp;&nbsp; | Time: {$run_time}s &nbsp;&nbsp; | {$pps} req/sec" . "<br />" . "Url: " . "<br />" . " &nbsp;&nbsp; |" . "<br />" . " &nbsp;&nbsp; | Agent: " . ( @$_SERVER["HTTP_USER_AGENT"] ) . "<br />" . "Version Control: " . "<br />" . " &nbsp;&nbsp; </div>" . "<br />";
		}

		$debug .= "Plugins<br>";
		$debug .= "=====================<br>";

		$plugins = get_plugins();

		require_once ABSPATH . '/wp-admin/includes/plugin.php';

		foreach ( $plugins as $path => $plugin ) {
			if ( is_plugin_active( $path ) ) {
				$debug .= $plugin['Name'] . '<br>';
			}
		}

		return $debug;
	}

	/**
	 * Generates a report about the system and plug-in error
	 *
	 * @return string
	 */
	public function gererateReportAction() {
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.zip-archive.php' );

		$reposts_dir  = WCL_PLUGIN_DIR . '/reports';
		$reports_temp = $reposts_dir . '/temp';

		if ( ! file_exists( $reposts_dir ) ) {
			mkdir( $reposts_dir, 0777, true );
		}

		if ( ! file_exists( $reports_temp ) ) {
			mkdir( $reports_temp, 0777, true );
		}

		$file = fopen( $reports_temp . '/site-info.html', 'w+' );
		fputs( $file, $this->getDebugReport() );
		fclose( $file );

		$download_file_name = 'webcraftic-clearfy-report-' . date( 'Y.m.d-H.i.s' ) . '.zip';
		$download_file_path = WCL_PLUGIN_DIR . '/reports/' . $download_file_name;

		Wbcr_ExtendedZip::zipTree( WCL_PLUGIN_DIR . '/reports/temp', $download_file_path, ZipArchive::CREATE );

		array_map( 'unlink', glob( WCL_PLUGIN_DIR . "/reports/temp/*" ) );

		wp_redirect( WCL_PLUGIN_URL . '/reports/' . $download_file_name );
		exit;
	}
}
