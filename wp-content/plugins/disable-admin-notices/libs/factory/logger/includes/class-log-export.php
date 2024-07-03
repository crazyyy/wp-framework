<?php

namespace WBCR\Factory_Logger_140;

/**
 * Prepares export files, ZIPs them and allows to download the package.
 *
 * Usage example:
 *
 * ```php
 * $export_model = new Log_Export('package.zip');
 * $prepared = $export_model->prepare();
 *
 * if($prepared) {
 *      // start streaming ZIP archive to be downloaded
 *      $export_model->download();
 * }
 * ```
 */
class Log_Export {

	/**
	 * @var Logger Logger class
	 */
	private $logger;

	/**
	 * @var string Default archive name on download. {datetime} will be replaced with current m-d-Y.
	 */
	private $_archive_name = 'plugin_log_export-{datetime}.zip';

	/**
	 * @var string|null Archive save path.
	 */
	private $_archive_save_path;

	/**
	 * Log_Export constructor.
	 *
	 * @param Logger $logger
	 * @param null|string $archive_name
	 */
	public function __construct( $logger, $archive_name = null ) {
		$this->logger = $logger;
		if ( $archive_name !== null ) {
			$this->_archive_name = $archive_name;
		}
	}

	/**
	 * Prepare export.
	 *
	 * @return bool
	 */
	public function prepare() {

		if ( ! class_exists( '\ZipArchive' ) ) {
			$this->logger->error( 'App does not have \ZipArchive class available. It is not possible to prepare export' );

			return false;
		}

		$zip = new \ZipArchive();

		$log_base_dir = $this->logger->get_base_dir();

		if ( $log_base_dir === false ) {
			$this->logger->error( sprintf( 'Failed to get log path %s', $log_base_dir ) );

			return false;
		}

		$uploads = wp_get_upload_dir();

		if ( isset( $uploads['error'] ) && $uploads['error'] !== false ) {
			$this->logger->error( 'Unable to get save path of ZIP archive from wp_get_upload_dir()' );

			return false;
		}

		$save_base_path   = isset( $uploads['basedir'] ) ? $uploads['basedir'] : null;
		$zip_archive_name = 'wplugin_export.zip';
		$zip_save_path    = $save_base_path . DIRECTORY_SEPARATOR . $zip_archive_name;


		if ( ! $zip->open( $zip_save_path, \ZipArchive::CREATE ) ) {
			$this->logger->error( sprintf( 'Failed to created ZIP archive in path %s. Skipping export...', $zip_save_path ) );

			return false;
		}

		// Add all logs to ZIP archive
		$glob_path = $log_base_dir . '*.log';
		$log_files = glob( $glob_path );

		if ( ! empty( $log_files ) ) {
			foreach ( $log_files as $file ) {
				if ( ! $zip->addFile( $file, wp_basename( $file ) ) ) {
					$this->logger->error( sprintf( 'Failed to add %s to %s archive. Skipping it.', $file, $zip_save_path ) );

					return false;
				}
			}
		}

		$system_info = $this->prepare_system_info();

		if ( ! empty( $system_info ) ) {
			$system_info_file_name = 'system-info.txt';
			$system_info_path      = $save_base_path . DIRECTORY_SEPARATOR . $system_info_file_name;
			if ( false !== @file_put_contents( $system_info_path, $system_info ) ) {
				if ( ! $zip->addFile( $system_info_path, $system_info_file_name ) ) {
					$this->logger->error( sprintf( 'Failed to add %s to %s archive. Skipping it.', $system_info_file_name, $system_info_path ) );
				}
			} else {
				$this->logger->error( sprintf( 'Failed to save %s in %s', $system_info_file_name, $zip_save_path ) );
			}
		}

		if ( ! $zip->close() ) {
			$this->logger->error( sprintf( 'Failed to close ZIP archive %s for unknown reason. ZipArchive::close() failed.' ) );
		}

		if ( isset( $system_info_path ) ) {
			// Clean-up as this is just temp file
			@unlink( $system_info_path );
		}

		$this->_archive_save_path = $zip_save_path;

		return true;
	}

	/**
	 * Prepare generic system information, such as WordPress, PHP version, active plugins, loaded extenstions, etc.
	 *
	 * @return string
	 */
	public function prepare_system_info() {

		$space = PHP_EOL . PHP_EOL;
		$nl    = PHP_EOL;

		$report = 'Plugin version: ' . $this->logger->plugin->getPluginVersion() . $nl;

		global $wp_version;

		$report .= 'WordPress Version: ' . $wp_version . $nl;
		$report .= 'PHP Version: ' . PHP_VERSION . $nl;
		$report .= 'Locale: ' . get_locale() . $nl;
		$report .= 'HTTP Accept: ' . ( isset( $_SERVER['HTTP_ACCEPT'] ) ? $_SERVER['HTTP_ACCEPT'] : '*empty*' ) . $nl;
		$report .= 'HTTP User Agent: ' . ( isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '*empty*' ) . $nl;
		$report .= 'Server software: ' . ( isset( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE'] : '*empty*' ) . $nl;

		$report .= $space;

		$active_plugins = get_option( 'active_plugins', null );

		if ( $active_plugins !== null ) {

			$prepared_plugins = [];

			$all_plugins = get_plugins();

			foreach ( $active_plugins as $active_plugin ) {
				if ( isset( $all_plugins[ $active_plugin ] ) ) {
					$advanced_info      = $all_plugins[ $active_plugin ];
					$name               = isset( $advanced_info['Name'] ) ? $advanced_info['Name'] : '';
					$version            = isset( $advanced_info['Version'] ) ? $advanced_info['Version'] : '';
					$prepared_plugins[] = sprintf( "%s (%s)", $name, $version );
				}
			}

			$report .= 'Active plugins:' . PHP_EOL;
			$report .= implode( PHP_EOL, $prepared_plugins );
		}

		if ( function_exists( 'get_loaded_extensions' ) ) {

			$report .= PHP_EOL . PHP_EOL;
			$report .= 'Active extensions: ' . $nl;
			$report .= implode( ', ', get_loaded_extensions() );
		}

		$report .= $space;

		$report .= 'Generated at: ' . date( 'c' );

		return $report;
	}

	/**
	 * Download saved ZIP archive.
	 *
	 * It sets download headers, which streams content of the ZIP archive.
	 *
	 * Additionally it cleans-up by deleting the archive if `$and_delete` set to true.
	 *
	 * @param bool $should_clean_up Allows to delete temp ZIP archive if required.
	 *
	 * @return bool
	 */
	public function download( $should_clean_up = true ) {

		$zip_save_path = $this->_archive_save_path;

		if ( empty( $zip_save_path ) ) {
			return false;
		}

		$zip_content = @file_get_contents( $zip_save_path );

		if ( $zip_save_path === false ) {
			$this->logger->error( sprintf( 'Failed to get ZIP %s content as file_get_contents() returned false', $zip_save_path ) );

			return false;
		}

		if ( $should_clean_up ) {
			// Delete as ZIP is just for temporary usage
			@unlink( $zip_save_path );
		}

		$archive_name = str_replace( '{datetime}', date( 'c' ), $this->_archive_name );

		// Set-up headers to download export file
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: application/zip' );
		header( 'Content-Disposition: attachment; filename=' . $archive_name );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Connection: Keep-Alive' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . strlen( $zip_content ) );

		echo $zip_content;
		exit();
	}

	/**
	 * Get temporary stored archive path.
	 *
	 * @return string
	 */
	public function get_temp_archive_path() {
		return $this->_archive_save_path;
	}

	/**
	 * Delete temporary stored archive path.
	 *
	 * @return bool
	 */
	public function delete_temp_archive() {
		return @unlink( $this->get_temp_archive_path() );
	}
}
