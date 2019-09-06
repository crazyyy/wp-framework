<?php
	/**
	 * Ajax plugin configuration
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2017 Webraftic Ltd
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * This action allows you to process Ajax requests to activate external components Clearfy
	 */
	function wbcr_clearfy_update_package()
	{

		check_ajax_referer('package');

		$licensing = WCL_Licensing::instance();
		$licensing->getAddons(true); // обновляем список аддонов

		$package_plugin = WCL_Package::instance();

		if( !$licensing->isLicenseValid() and $licensing->isActivePaidAddons() ) {
			wp_send_json_error(array('error_message' => __('To use premium components, you need activate a license!', 'clearfy') . '<a href="admin.php?page=license-wbcr_clearfy" class="btn btn-gold">' . __('Activate license', 'clearfy') . '</a>'));
		}

		$old_components = $package_plugin->getActivedAddons();

		$data = array();
		$success = false;

		try {
			$result = $package_plugin->update();

			if( is_wp_error($result) ) {
				wp_send_json_error(array(
					'error_message' => __($result->get_error_message(), 'clearfy'),
					'code' => __($result->get_error_code(), 'clearfy'),
				));
			}
			$success = true;

			$data['message'] = __('Configuration updated.', 'clearfy');
			$data['result'] = $result;
		} catch( Exception $e ) {
			wp_send_json_error(array(
				'error_message' => $e->getMessage(),
				'code' => $e->getCode(),
			));
		}

		if( $success ) {

			do_action('wbcr_clearfy_package_updated', $package_plugin->getSlugs());

			$get_new_components = $package_plugin->getActivedAddons();

			if( !empty($old_components) ) {
				$net_components = array_diff_key($get_new_components, $old_components);
			} else {
				$net_components = $get_new_components;
			}

			if( !empty($net_components) ) {
				foreach($net_components as $component_name => $value) {
					/**
					 * После обновления пакета компонентов, мы принудительно вызываем классы активации для новых загруженных компонентов.
					 * Если компонент уже был загружен, для него не нужно вызывать хук активации, так как за это отвечает уже другой обработчик.
					 * @since 1.4.2
					 */
					do_action('wbcr/clearfy/activated_component', $component_name);
				}
			}

			wp_send_json_success($data);
		}

		wp_send_json_error(array('error_message' => __('An unknown error occurred during the activation of the component.', 'clearfy')));
	}

	add_action('wp_ajax_wbcr-clearfy-update-package', 'wbcr_clearfy_update_package');
