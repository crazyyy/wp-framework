<?php
/**
 * FF7 Apps entries
 *
 * @since 3.1.0
 * @package Contact Form 7 Apps
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'CF7Apps_Entries_App' ) && class_exists( 'CF7Apps_App' ) ) :
	/**
	 * CF7Apps_Entries_App class
	 *
	 * @since 3.1.0
	 */
	class CF7Apps_Entries_App extends CF7Apps_App {
		/**
		 * CF7Apps_Entries_App constructor.
		 *
		 * @since 3.1.0
		 */
		public function __construct() {
			$this->id                 = 'cf7-entries';
			$this->priority           = -1;
			$this->title              = __( 'Entries', 'cf7apps' );
			$this->description        = __( 'Access and manage all Contact Form 7 submissions in a centralized database with filtering and export options.', 'cf7apps' );
			$this->icon               = plugin_dir_url( __FILE__ ) . 'assets/images/logo.svg';
			$this->has_admin_settings = true;
			$this->is_pro             = false;
			$this->by_default_enabled = false;
			$this->documentation_url  = 'https://cf7apps.com/docs/general/entries';
			$this->parent_menu        = __( 'General', 'cf7apps' );
			$this->setting_tabs       = array(
				'general' => __( 'General', 'cf7apps' ),
				'entries' => __( 'Entries', 'cf7apps' ),
			);

			include_once plugin_dir_path( __FILE__ ) . 'includes/cf7-form-entries.php';
			add_action( 'admin_init', array( $this, 'create_table' ) );
			add_action( 'wpcf7_mail_sent', array( $this, 'save_form_information' ), 10, 1 );
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		}

		/**
		 * Create the database table for storing form entries.
		 *
		 * @since 3.1.0
		 */
		public function create_table() {
			if ( current_user_can( 'manage_options') && $this->get_option( 'is_enabled') ) {
				$installed_version   = get_option( 'cf7_entries_version' );
				$required_version    = '1.0.0';

				if ( $installed_version !== $required_version ) {
					global $wpdb;
					$table_name = $wpdb->prefix . 'cf7apps_form_entries';
					$charset_collate = $wpdb->get_charset_collate();

					$sql = "CREATE TABLE $table_name (
    					id INT AUTO_INCREMENT,
    					form_id INT NOT NULL,
    					form_name VARCHAR(155) NOT NULL,
    					email VARCHAR(155) DEFAULT NULL,
    					date_time VARCHAR(155) NOT NULL,
    					data LONGTEXT NOT NULL,
    					PRIMARY KEY  (id)
					) $charset_collate;";

					require_once ABSPATH . 'wp-admin/includes/upgrade.php';
					dbDelta( $sql );

					update_option( 'cf7_entries_version', $required_version );
				}
			}
		}

		/**
		 * Save form information when a form is submitted.
		 *
		 * @since 3.1.0
		 * @param WPCF7_ContactForm $form The contact form object.
		 */
		public function save_form_information( $form ) {
			if ( ! $this->get_option( 'is_enabled' ) ) {
				return;
			}

			$submission = WPCF7_Submission::get_instance();

			if ( ! $submission ) { return; }

			$data = array();

			$posted_data = $submission->get_posted_data();

			foreach ( $form->scan_form_tags() as $form_tag ) {
				if ( ! empty( $form_tag['name'] ) ) {
					$data[ $form_tag['name'] ] = $posted_data[ $form_tag['name'] ];
				}
			}

			$data['ip'] = $_SERVER['REMOTE_ADDR'];

			$entry = new CF7Apps_Form_Entries();

			$entry->form_id   = $form->id();
			$entry->form_name = $form->name();
			$entry->email     = $submission->get_posted_data( 'your-email' ) ?: $submission->get_posted_data( 'email' );
			$entry->date_time = current_time( 'timestamp' );
			$entry->data      = $data;

			$entry->save();
		}

		/**
		 * Add admin menu item for entries.
		 *
		 * @since 3.1.0
		 */
		public function add_admin_menu() {
			if ( $this->get_option( 'is_enabled' ) ) {
				$rand = rand(1000, 9999);
				add_submenu_page( 'wpcf7', __( 'Entries', 'cf7apps' ), __( 'Entries', 'cf7apps' ), 'manage_options', 'admin.php?page=cf7apps&tab=entries' . $rand . '#/settings/cf7-entries/2', null, 3 );
			}
		}

		/**
		 * Get the app settings.
		 *
		 * @since 3.1.0
		 * @return array
		 */
		public function admin_settings() {
			return array(
				'general' => array(
					'fields' => array(
						'general' => array(
							'title'       => __( 'Entries Settings', 'cf7apps' ),
							'description' => __( 'Access and manage all Contact Form 7 submissions in a centralized database with filtering and export options.', 'cf7apps' ),
							'is_enabled'  => array(
								'title' 	  => __( 'Show Entries', 'cf7apps' ),
								'type'        => 'checkbox',
								'default'     => false,
							),

							'save_settings' => array(
								'type'  => 'save_button',
								'text'  => __( 'Save Settings', 'cf7apps' ),
								'class' => 'button-primary',
							),
						),
						'entries' => array(
							'template' => 'cf7Entries',
						),
					),
				),
			);
		}
	}

	if ( ! function_exists( 'cf7apps_register_cf7entries' ) ) :
		/**
		 * Register the CF7 entries app
		 *
		 * @since 3.1.0
		 * @param array $apps List of registered apps.
		 *
		 * @return array
		 */
		function cf7apps_register_cf7entries( $apps ) {
			$apps[] = 'CF7Apps_Entries_App';
			return $apps;
		}
	endif;

	add_filter( 'cf7apps_apps', 'cf7apps_register_cf7entries' );
endif;
