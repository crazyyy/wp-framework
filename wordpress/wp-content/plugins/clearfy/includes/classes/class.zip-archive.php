<?php
	/**
	 * A class for packing files into an archive.
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2017 Webraftic Ltd
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('ZipArchive') ) {
		wp_die(__('The ZipArchive class does not exist in this version of php.'));
	}

	class Wbcr_ExtendedZip extends ZipArchive {

		// Member function to add a whole file system subtree to the archive
		public function addTree($dirname, $localname = '')
		{
			if( $localname ) {
				$this->addEmptyDir($localname);
			}
			$this->_addTree($dirname, $localname);
		}

		// Internal function, to recurse
		protected function _addTree($dirname, $localname)
		{
			$dir = opendir($dirname);
			while( $filename = readdir($dir) ) {
				// Discard . and ..
				if( $filename == '.' || $filename == '..' ) {
					continue;
				}

				// Proceed according to type
				$path = $dirname . '/' . $filename;
				$localpath = $localname
					? ($localname . '/' . $filename)
					: $filename;
				if( is_dir($path) ) {
					// Directory: add & recurse
					$this->addEmptyDir($localpath);
					$this->_addTree($path, $localpath);
				} else if( is_file($path) ) {
					// File: just add
					$this->addFile($path, $localpath);
				}
			}
			closedir($dir);
		}

		// Helper function
		public static function zipTree($dirname, $zipFilename, $flags = 0, $localname = '')
		{
			$zip = new self();
			$zip->open($zipFilename, $flags);
			$zip->addTree($dirname, $localname);
			$zip->close();
		}
	}
