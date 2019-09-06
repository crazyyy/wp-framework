<?php
	/**
	 * The file contains a class to manage style assets.
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package factory-core
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('Wbcr_Factory409_StyleList') ) {

		/**
		 * Style List
		 *
		 * @since 1.0.0
		 */
		class Wbcr_Factory409_StyleList extends Wbcr_Factory409_AssetsList {

			/**
			 * Adds new items to the collection (default place).
			 *
			 * @param mixed
			 * @version 2.0
			 */
			public function add($file_url, $deps = array(), $handle = null, $version = false, $media = 'all')
			{

				if( empty($file_url) ) {
					return $this;
				}

				$resource = array();
				$resource['file_url'] = $file_url;
				$resource['deps'] = $deps;
				$resource['handle'] = $handle;
				$resource['version'] = $version;
				$resource['media'] = $media;

				$this->all[] = $resource;

				return $this;
			}

			public function connect($source = 'wordpress')
			{
				// register all global required scripts
				if( !empty($this->required[$source]) ) {

					foreach($this->required[$source] as $style) {
						if( 'wordpress' === $source ) {
							wp_enqueue_style($style);
						} elseif( 'bootstrap' === $source ) {
							$this->plugin->bootstrap->enqueueStyle($style);
						}
					}
				}

				if( $source == 'bootstrap' ) {
					return;
				}

				if( empty($this->all) ) {
					return;
				}

				// register all other styles
				foreach($this->all as $style) {

					if( empty($style['file_url']) ) {
						continue;
					}

					$handle = !empty($style['handle']) ? $style['handle'] : md5($style['file_url']);
					$deps = !is_array($style['deps']) ? array() : $style['deps'];
					$version = !empty($style['version']) ? $style['version'] : $this->plugin->getPluginVersion();

					wp_enqueue_style($handle, $style['file_url'], $deps, $version);
				}
			}
		}
	}
