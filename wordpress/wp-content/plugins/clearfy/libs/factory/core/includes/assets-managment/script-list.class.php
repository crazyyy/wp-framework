<?php
	/**
	 * The file contains a class to manage script assets.
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

	if( !class_exists('Wbcr_Factory409_ScriptList') ) {

		/**
		 * Script List
		 *
		 * @since 1.0.0
		 */
		class Wbcr_Factory409_ScriptList extends Wbcr_Factory409_AssetsList {

			public $localize_data = array();
			public $use_ajax = false;

			/**
			 * Adds new items to the collection (default place).
			 *
			 * @param mixed
			 * @version 2.0
			 */
			public function add($file_url, $deps = array('jquery'), $handle = null, $version = false, $place = 'default')
			{

				if( empty($file_url) ) {
					return $this;
				}

				$resource = array();
				$resource['file_url'] = $file_url;
				$resource['deps'] = $deps;
				$resource['handle'] = $handle;
				$resource['version'] = $version;

				$this->all[] = $resource;

				switch( $place ) {
					case 'header':
						$this->header_place[] = $resource;
						break;
					case 'footer':
						$this->footer_place[] = $resource;
						break;
					default:
						$this->default_place[] = $resource;
						break;
				}

				return $this;
			}

			/**
			 * Adds new items to the collection (header).
			 * @param mixed
			 */
			public function addToHeader($file_url, $deps = array('jquery'), $handle = null)
			{
				return $this->add($file_url, $deps, $handle, 'header');
			}

			/**
			 * Adds new items to the collection (footer).
			 * @param mixed
			 */
			public function addToFooter($file_url, $deps = array('jquery'), $handle = null)
			{
				return $this->add($file_url, $deps, $handle, 'footer');
			}

			/**
			 * Осуществляет подключение всех зарегистрированных скриптов
			 *
			 * @param string $source
			 */
			public function connect($source = 'wordpress')
			{

				// register all global required scripts
				if( !empty($this->required[$source]) ) {
					foreach($this->required[$source] as $script) {
						if( 'wordpress' === $source ) {
							wp_enqueue_script($script);
						} elseif( 'bootstrap' === $source ) {
							$this->plugin->bootstrap->enqueueScript($script);
						}
					}
				}

				if( $source == 'bootstrap' ) {
					return;
				}

				$is_first_script = true;
				$is_footer = false;

				// register all other scripts
				foreach(array($this->header_place, $this->footer_place) as $script_place) {
					foreach($script_place as $script) {

						if( empty($script['file_url']) ) {
							continue;
						}

						$handle = !empty($script['handle']) ? $script['handle'] : $script['file_url'];
						$deps = !is_array($script['deps']) ? array() : $script['deps'];
						$version = !empty($script['version']) ? $script['version'] : $this->plugin->getPluginVersion();

						wp_register_script($handle, $script['file_url'], $deps, $version, $is_footer);

						if( $is_first_script && $this->use_ajax ) {
							wp_localize_script($handle, 'factory', array('ajaxurl' => admin_url('admin-ajax.php')));
						}

						if( !empty($this->localize_data[$handle]) ) {
							wp_localize_script($handle, $this->localize_data[$handle][0], $this->localize_data[$handle][1]);
						}

						wp_enqueue_script($handle);

						$is_first_script = false;
					}

					$is_footer = true;
				}
			}

			/**
			 * Если вызвать этот метод, на странице будет обязательно добавлена
			 * глобальная JS переменная с ссылкой на ajax обработчик
			 */
			public function useAjax()
			{
				$this->use_ajax = true;
			}

			/**
			 * Регистрирует глобальную JS переменную с пользовательскими данными
			 *
			 * @param string $varname
			 * @param string $data
			 * @return Wbcr_Factory409_ScriptList $this
			 */
			public function localize($varname, $data)
			{
				$bindTo = count($this->all) == 0 ? null : end($this->all);

				if( !$bindTo ) {
					return $this;
				}

				$this->localize_data[$bindTo] = array($varname, $data);

				return $this;
			}
		}
	}
