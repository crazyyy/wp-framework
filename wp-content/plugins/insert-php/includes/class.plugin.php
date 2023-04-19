<?php
/**
 * PHP snippets plugin base
 *
 * @author        Webcraftic <WordPress.webraftic@gmail.com>
 * @copyright (c) 19.02.2018, Webcraftic
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WINP_Plugin' ) ) {

	class WINP_Plugin extends Wbcr_Factory463_Plugin {

		/**
		 * @var Wbcr_Factory463_Plugin
		 */
		private static $app;

		/**
		 * @param string $plugin_path
		 * @param array $data
		 *
		 * @throws Exception
		 */
		public function __construct( $plugin_path, $data ) {
			parent::__construct( $plugin_path, $data );

			self::$app = $this;

			$this->load_global();

			if ( is_admin() ) {
				$this->initActivation();

				if ( WINP_Helper::doing_ajax() ) {
					require WINP_PLUGIN_DIR . '/admin/ajax/ajax.php';
					require WINP_PLUGIN_DIR . '/admin/ajax/check-license.php';
					require WINP_PLUGIN_DIR . '/admin/ajax/snippet-library.php';
				}

				$this->load_backend();
			}
		}

		/**
		 * @return WINP_Plugin
		 */
		public static function app() {
			return self::$app;
		}

		/**
		 * @return bool
		 */
		public function currentUserCan() {
			return current_user_can( 'manage_options' );
		}

		/**
		 * Get Execute_Snippet object
		 *
		 * @return WINP_Execute_Snippet
		 */
		public function getExecuteObject() {
			require_once WINP_PLUGIN_DIR . '/includes/class.execute.snippet.php';

			return new WINP_Execute_Snippet();
		}

		/**
		 * Get WINP_Api object
		 *
		 * @return WINP_Api
		 */
		public function get_api_object() {
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.api.php';

			return new WINP_Api();
		}

		/**
		 * Get WINP_Common_Snippet object
		 *
		 * @return WINP_Common_Snippet
		 */
		public function get_common_object() {
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.common.snippet.php';

			return new WINP_Common_Snippet();
		}

		/**
		 * @throws \Exception
		 * @since  2.2.0
		 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
		 */
		/*
		public function plugins_loaded() {
			$this->register_pages();
		}*/

		protected function initActivation() {
			include_once WINP_PLUGIN_DIR . '/admin/activation.php';
			$this->registerActivation( 'WINP_Activation' );
		}

		/**
		 * @throws \Exception
		 * @since   2.2.0
		 * @author  Alexander Kovalev <alex.kovalevv@gmail.com>
		 */
		public function register_pages() {
			require_once WINP_PLUGIN_DIR . '/admin/pages/page.php';

			$this->registerPage( 'WINP_NewItemPage', WINP_PLUGIN_DIR . '/admin/pages/new-item.php' );
			$this->registerPage( 'WINP_SettingsPage', WINP_PLUGIN_DIR . '/admin/pages/settings.php' );
			$this->registerPage( 'WINP_SnippetLibraryPage', WINP_PLUGIN_DIR . '/admin/pages/snippet-library.php' );
			$this->registerPage( 'WINP_License_Page', WINP_PLUGIN_DIR . '/admin/pages/license.php' );
			$this->registerPage( 'WINP_AboutPage', WINP_PLUGIN_DIR . '/admin/pages/about.php' );
		}

		/**
		 * @throws \Exception
		 * @since   2.2.0
		 * @author  Alexander Kovalev <alex.kovalevv@gmail.com>
		 */
		public function register_depence_pages() {
			require_once WINP_PLUGIN_DIR . '/admin/pages/page.php';

			if ( ! ( defined( 'WASP_PLUGIN_ACTIVE' ) && WASP_PLUGIN_ACTIVE ) ) {
				$this->registerPage( 'WINP_ImportPage', WINP_PLUGIN_DIR . '/admin/pages/import.php' );
			}
		}

		/**
		 * @throws \Exception
		 * @since   2.2.0
		 * @author  Alexander Kovalev <alex.kovalevv@gmail.com>
		 */
		private function register_types() {
			require_once WINP_PLUGIN_DIR . '/admin/types/snippets-post-types.php';
			Wbcr_FactoryTypes413::register( 'WINP_SnippetsType', $this );

			require_once WINP_PLUGIN_DIR . '/admin/types/snippets-taxonomy.php';
			Wbcr_FactoryTaxonomies333::register( 'WINP_SnippetsTaxonomy', $this );
		}

		/**
		 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
		 * @since  2.2.0
		 */
		private function register_shortcodes() {
			$action = self::app()->request->get( 'action', '' );
			if ( ! ( 'edit' == $action && is_admin() ) ) {
				if ( self::app()->getOption( 'support_old_shortcodes' ) ) {
					// todo: Deprecated
					require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-insert-php.php';
				}

				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcodes.php';
				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-php.php';
				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-text.php';
				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-universal.php';
				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-css.php';
				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-js.php';
				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-html.php';
				require_once WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-ad.php';

				WINP_Helper::register_shortcode( 'WINP_SnippetShortcodePhp', $this );
				WINP_Helper::register_shortcode( 'WINP_SnippetShortcodeText', $this );
				WINP_Helper::register_shortcode( 'WINP_SnippetShortcodeUniversal', $this );
				WINP_Helper::register_shortcode( 'WINP_SnippetShortcodeCss', $this );
				WINP_Helper::register_shortcode( 'WINP_SnippetShortcodeJs', $this );
				WINP_Helper::register_shortcode( 'WINP_SnippetShortcodeHtml', $this );
				WINP_Helper::register_shortcode( 'WINP_SnippetShortcodeAdvert', $this );
			}
		}

		/**
		 * Initialization and require files for backend and frontend.
		 *
		 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
		 * @since  2.2.0
		 */
		private function load_global() {
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.gutenberg.snippet.php';

			new WINP_Gutenberg_Snippet();

			$this->getExecuteObject()->registerHooks();
			$this->register_shortcodes();

			/**
			 * Enables/Disable safe mode, in which the php code will not be executed.
			 */
			add_action( 'plugins_loaded', function () {
				if ( isset( $_GET['wbcr-php-snippets-safe-mode'] ) ) {
					WINP_Helper::enable_safe_mode();
					wp_safe_redirect( esc_url( remove_query_arg( [ 'wbcr-php-snippets-safe-mode' ] ) ) );
					die();
				}

				if ( isset( $_GET['wbcr-php-snippets-disable-safe-mode'] ) ) {
					WINP_Helper::disable_safe_mode();
					wp_safe_redirect( esc_url( remove_query_arg( [ 'wbcr-php-snippets-disable-safe-mode' ] ) ) );
					die();
				}
			}, - 1 );
		}

		/**
		 * Initialization and require files for backend.
		 *
		 * @throws \Exception
		 * @since  2.2.0
		 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
		 */
		private function load_backend() {
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.snippets.viewtable.php';
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.filter.snippet.php';
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.actions.snippet.php';
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.import.snippet.php';
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.notices.php';
			require_once WINP_PLUGIN_DIR . '/admin/includes/class.request.php';
			require_once WINP_PLUGIN_DIR . '/admin/metaboxes/metabox.php';
			require_once WINP_PLUGIN_DIR . '/admin/boot.php';

			$this->get_common_object()->registerHooks();

			$this->register_types();

			new WINP_Filter_List();
			new WINP_Export_Snippet();
			new WINP_Import_Snippet();
			new WINP_WarningNotices();

			# Required for i18n to be loaded properly
			add_action( 'plugins_loaded', [ $this, 'register_pages' ] );

			# Required for compatibility with the premium plugin.
			# We set the priority to 30 to wait for the premium plugin to load.
			add_action( 'plugins_loaded', [ $this, 'register_depence_pages' ], 30 );

			add_action( 'wbcr_factory_forms_460_register_controls', function () {
				$colorControls = [
					[
						'type'    => 'winp-dropdown',
						'class'   => 'WINP_FactoryForms_Dropdown',
						'include' => WINP_PLUGIN_DIR . '/includes/controls/class.dropdown.php',
					],
				];
				$this->forms->registerControls( $colorControls );
			} );
		}

		/**
		 * Метод проверяет активацию премиум плагина и наличие действующего лицензионного ключа
		 *
		 * @return bool
		 */
		public function is_premium() {
			if ( $this->premium->is_active() && $this->premium->is_activate() //&& $this->premium->is_install_package()
			) {
				return true;
			} else {
				return false;
			}
		}

	}
}
