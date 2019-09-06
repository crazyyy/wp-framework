<?php

class WCL_Plugin_Upgrader extends Plugin_Upgrader {

	/**
	 * Download a package.
	 *
	 * @since 2.8.0
	 *
	 * @param string $package   The URI of the package. If this is the full path to an
	 *                          existing local file, it will be returned untouched.
	 *
	 * @return string|WP_Error The full path to the downloaded package file, or a WP_Error object.
	 */
	public function download_package( $package ) {

		/**
		 * Filters whether to return the package.
		 *
		 * @since 3.7.0
		 *
		 * @param bool        $reply     Whether to bail without returning the package.
		 *                               Default false.
		 * @param string      $package   The package file name.
		 * @param WP_Upgrader $this      The WP_Upgrader instance.
		 */
		$reply = apply_filters( 'upgrader_pre_download', false, $package, $this );
		if ( false !== $reply ) {
			return $reply;
		}

		if ( ! preg_match( '!^(http|https|ftp)://!i', $package ) && file_exists( $package ) ) //Local file or remote?
		{
			return $package;
		} //must be a local file..

		if ( empty( $package ) ) {
			return new WP_Error( 'no_package', $this->strings['no_package'] );
		}

		$download_file = download_url( $package, 10000 );

		if ( is_wp_error( $download_file ) ) {
			return new WP_Error( 'download_failed', $this->strings['download_failed'], $download_file->get_error_message() );
		}

		// Temporary fix. Components package is definitely more than 2kb,
		// if the file weight is less than 2kb, the server returned an error and
		// empty file saved
		$filesize = filesize( $download_file );
		if ( $filesize < ( 2 * 1000 ) ) {
			@unlink( $download_file );

			return new WP_Error( 'download_failed', 'Component package cannot be loaded. The server returned an error.' );
		}

		return $download_file;
	}
}
