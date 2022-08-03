<?php

namespace WBCR\Factory_Feedback_117;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base class for feedback module.
 *
 * Предназначен для обратной связи с пользователями.
 * В первой версии при деактивации плагина появляется всплывающее окно с небольшим опросом:
 * "Почему вы деактивировали плагин?"
 * Данные отправляются на сайт CreativeMotion
 *
 * @author        Artem Prihodko <webtemyk@yandex.ru>
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 *
 * @since         1.0.0 Added
 * @package       factory-feedback
 * @copyright (c) 2019 Webcraftic Ltd
 */
class Base {

	/**
	 * Plugin instance this module interacts with
	 *
	 * @since  1.0.0 Added
	 * @var \Wbcr_Factory457_Plugin
	 */
	private $plugin;

	/**
	 * Экземпляр класса для работы API CreativeMotion
	 *
	 * @since  1.0.0
	 * @var \WBCR\Factory_Feedback_117\Creative_Motion_API
	 */
	private $api;

	/**
	 * Wbcr_Factory_Feedback constructor.
	 *
	 * @param \Wbcr_Factory457_Plugin $plugin
	 *
	 * @since 1.0.0 Added
	 *
	 */
	public function __construct( \Wbcr_Factory457_Plugin $plugin ) {
		$this->plugin = $plugin;

		$this->api = new Creative_Motion_API( $this->plugin );

		// Plugin hook for adding CSS and JS files required for this plugin
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ], 10, 1 );
		add_action( 'admin_footer-plugins.php', [ $this, 'render_deactivate_form' ] );

		if ( $this->plugin->isNetworkActive() ) {
			add_filter( 'network_admin_plugin_action_links', [ $this, 'plugin_deactivate_action_link' ], 10, 2 );
		} else {
			add_filter( 'plugin_action_links', [ $this, 'plugin_deactivate_action_link' ], 10, 2 );
		}

		if ( wp_doing_ajax() ) {
			add_action( "wp_ajax_wbcr-factory-feedback-117-save_{$plugin->getPluginName()}", [
				$this,
				'send_feedback'
			] );
		}
	}

	/**
	 * Enqueues module assets for work feedback popup.
	 *
	 * @param $hook_suffix
	 *
	 * @return void
	 * @since  1.0.0 Added
	 *
	 */
	public function admin_assets( $hook_suffix ) {
		if ( 'plugins.php' === $hook_suffix ) {
			wp_enqueue_script( 'wbcr-factory-feedback-117-deactivate', FACTORY_FEEDBACK_117_URL . '/assets/js/deactivate-feedback.js', [ 'jquery' ], FACTORY_FEEDBACK_117_VERSION, true );
			wp_enqueue_style( 'wbcr-factory-feedback-117-deactivate', FACTORY_FEEDBACK_117_URL . '/assets/css/dialog-boxes.css' );
		}
	}


	/**
	 * Render html form in footer on the plugins page.
	 *
	 * @since  1.0.0 Added
	 */
	public function render_deactivate_form() {
		include FACTORY_FEEDBACK_117_DIR . "/views/deactivate-form.php";
	}

	/**
	 * Adds invisible element to action link to able to listen js events.
	 *
	 * @param array $actions Links array under plugin title
	 * @param string $plugin_file Plugin basename: plugin-name/plugin-name.php
	 *
	 * @return array Links array
	 * @since  1.0.0 Added
	 *
	 */
	public function plugin_deactivate_action_link( $actions, $plugin_file ) {
		if ( $plugin_file !== $this->plugin->get_paths()->basename ) {
			return $actions;
		}
		$actions['deactivate'] = $actions['deactivate'] . '<i class="wbcr-factory-feedback-117-plugin-slug" data-plugin="' . $this->plugin->getPluginName() . '"></i>';

		return $actions;
	}

	/**
	 *
	 * Ajax action sends request to remote server to register deactivation reason.
	 *
	 * @since  1.0.1 Refactoring, fixed minor bugs. Added new data attrs.
	 * @since  1.0.0 Added
	 */
	public function send_feedback() {
		global $wp_version;

		if ( defined( 'FACTORY_FEEDBACK_DEBUG' ) && FACTORY_FEEDBACK_DEBUG ) {
			return;
		}

		check_ajax_referer( 'wbcr_factory_send_feedback' );

		if ( ! current_user_can( 'manage_options' ) || ( $this->plugin->plugin_slug !== $_POST['plugin'] ) ) {
			wp_send_json_error( [ 'error_message' => "You haven't permissions for the action." ] );
		}

		if ( isset( $_POST['reason_id'] ) && isset( $_POST['reason_more'] ) ) {
			$anonymous   = $this->plugin->request->post( 'anonymous', 0, 'intval' );
			$license_key = $this->plugin->premium->is_activate() ? $this->plugin->premium->get_license()->get_key() : '';

			$data = [
				'uid'            => md5( home_url() . get_bloginfo( 'admin_email' ) ),
				'plugin_name'    => $this->plugin->getPluginName(),
				'plugin_title'   => $this->plugin->getPluginTitle(),
				'site_url'       => $anonymous ? '' : site_url(),
				'plugin_version' => $anonymous ? '' : $this->plugin->getPluginVersion(),
				'php_version'    => $anonymous ? '' : phpversion(),
				'wp_version'     => $anonymous ? '' : $wp_version,
				'license_key'    => $anonymous ? '' : $license_key,
				'reason'         => $this->plugin->request->post( 'reason_id', 0, 'intval' ),
				'reason_more'    => $this->plugin->request->post( 'reason_more', '', true )
			];

			$plugin = explode( '/', plugin_basename( __FILE__ ) )[0];

			$response = $this->api->send_feedback( $plugin, $data );

			wp_send_json_success();
		}

		wp_send_json_error( [ 'error_message' => '' ] );
	}
}
