<?php

class EHSSL_Certificate_Expiry_Menu extends EHSSL_Admin_Menu {
	public $menu_page_slug = EHSSL_CERTIFICATE_EXPIRY_MENU_SLUG;

	// Specify all the tabs of this menu in the following array.
	public $dashboard_menu_tabs = array(
		'expiring-certificates' => 'Expiring Certificates',
		'expiry-notification'    => 'Expiry Notification',
	);

	public function __construct() {
		$this->render_menu_page();
	}

	public function get_current_tab() {
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : array_keys( $this->dashboard_menu_tabs )[0];

		return $tab;
	}

	/**
	 * Renders our tabs of this menu as nav items
	 */
	public function render_page_tabs() {
		$current_tab = $this->get_current_tab();
		foreach ( $this->dashboard_menu_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->menu_page_slug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
	}

	/**
	 * The menu rendering goes here
	 */
	public function render_menu_page() {
		$tab = $this->get_current_tab();

		?>
        <div class="wrap">
            <h2><?php _e( "Certificate Expiry", 'https-redirection' ) ?></h2>
            <h2 class="nav-tab-wrapper"><?php $this->render_page_tabs(); ?></h2>
            <div id="poststuff">
                <div id="post-body">
					<?php
					switch ( $tab ) {
						case 'expiring-certificates':
							$this->render_expiring_certificates_tab();
							break;
						case 'expiry-notification';
						default:
							$this->render_email_notification_tab();
							break;
					}
					?>
                </div>
            </div>
			<?php $this->documentation_link_box(); ?>
        </div><!-- end or wrap -->
		<?php
	}

	public function render_expiring_certificates_tab() {
		if ( isset( $_POST['ehssl_scan_for_ssl_submit'] ) ){

			if (!check_admin_referer('ehssl_scan_for_ssl_nonce')){
				wp_die('Nonce verification failed!');
			}

			EHSSL_SSL_Utils::check_and_save_current_cert_info();

			echo '<div class="notice notice-success"><p>'. __('SSL certificate scan completed successfully.', 'https-redirection') .'</p></div>';
		}

		if ( isset( $_POST['ehssl_delete_all_cert_info_submit'] ) ){

			if (!check_admin_referer('ehssl_delete_all_cert_info_nonce')){
				wp_die('Nonce verification failed!');
			}

			$is_deleted = EHSSL_SSL_Utils::delete_all_certificate_info();

            if ($is_deleted){
			    echo '<div class="notice notice-success"><p>'. __('SSL certificate info was deleted successfully.', 'https-redirection') .'</p></div>';
            } else {
			    echo '<div class="notice notice-info"><p>'. __('No saved SSL certificate info was detected for deletion.', 'https-redirection') .'</p></div>';
            }
		}

        $certs_info = EHSSL_SSL_Utils::get_all_saved_certificates_info();
		?>
        <div class="postbox">
            <h3 class="hndle">
                <label for="title"><?php _e( "Certificates", 'https-redirection' ); ?></label>
            </h3>
            <div class="inside">
                <?php if (!empty($certs_info)) { ?>
                <table class="widefat striped">
                    <thead>
                    <tr>
                        <th><?php _e('ID', 'https-redirection') ?></th>
                        <th><?php _e('Label', 'https-redirection') ?></th>
                        <th><?php _e('Issuer', 'https-redirection') ?></th>
                        <th><?php _e('Issued on', 'https-redirection') ?></th>
                        <th><?php _e('Expires on', 'https-redirection') ?></th>
                        <th><?php _e('Status', 'https-redirection') ?></th>
                    </tr>
                    </thead>
                    <?php foreach ($certs_info as $cert){
                        $formatted_issued_on_date = EHSSL_Utils::parse_timestamp( $cert['issued_on'] );
                        $formatted_expires_on = EHSSL_Utils::parse_timestamp( $cert['expires_on'] );
	                    $formatted_ssl_status = ucfirst(EHSSL_SSL_Utils::get_certificate_status($cert['expires_on']));
                        ?>
                        <tr>
                            <td><?php esc_attr_e($cert['id']) ?></td>
                            <td><?php esc_attr_e($cert['label']) ?></td>
                            <td><?php esc_attr_e($cert['issuer']) ?></td>
                            <td><?php esc_attr_e($formatted_issued_on_date) ?></td>
                            <td><?php esc_attr_e($formatted_expires_on) ?></td>
                            <td><?php esc_attr_e($formatted_ssl_status) ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php } else { ?>
                <p class="description">
                    <?php _e('No SSL certificate information found. Click the Scan button to search for installed certificates.', 'https-redirection') ?>
                </p>
                <?php } ?>
            </div><!-- end of inside -->
        </div><!-- end of postbox -->

        <div class="postbox">
            <h3 class="hndle">
                <label for="title"><?php _e( "Certificate Actions", 'https-redirection' ); ?></label>
            </h3>
            <div class="inside">
                <div class="">
                    <form action="" method="post">
                        <div><?php _e('Click the Scan button to manually scan for available SSL certificates.', 'https-redirection') ?></div>
                        <br>
                        <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('ehssl_scan_for_ssl_nonce') ?>">
                        <input type="submit"
                               class="button-primary"
                               value="<?php _e('Scan Now', 'https-redirection') ?>"
                               name="ehssl_scan_for_ssl_submit"
                        >
                    </form>
                </div>

                <br>

                <div class="">
                    <form action="" method="post" onsubmit="return confirm('<?php _e('Do you really want to delete all saved SSL info?', 'https-redirection') ?>');">
                        <div><?php _e('Delete all SSL certificate records from the table.', 'https-redirection') ?></div>
                        <br>
                        <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('ehssl_delete_all_cert_info_nonce') ?>">
                        <input type="submit"
                               class="button-secondary"
                               style="border-color: #CC0000; color: #CC0000"
                               value="<?php _e('Delete All SSL Info', 'https-redirection') ?>"
                               name="ehssl_delete_all_cert_info_submit"
                        >
                    </form>
                </div>

            </div><!-- end of inside -->
        </div><!-- end of postbox -->
		<?php
	}

	public function render_email_notification_tab() {
        $settings = get_option('httpsrdrctn_options', array());

		if ( isset( $_POST['ehssl_expiry_notification_settings_form_submit'] ) && check_admin_referer( 'ehssl_expiry_notification_settings_nonce' ) ) {
			$settings['ehssl_enable_expiry_notification']             = isset( $_POST['ehssl_enable_expiry_notification'] ) ? esc_attr( $_POST['ehssl_enable_expiry_notification'] ) : '';
			$settings['ehssl_expiry_notification_email_content_type'] = isset( $_POST['ehssl_expiry_notification_email_content_type'] ) ? sanitize_text_field( $_POST['ehssl_expiry_notification_email_content_type'] ) : 'text';
			$settings['ehssl_expiry_notification_email_before_days']  = isset( $_POST['ehssl_expiry_notification_email_before_days'] ) ? intval( sanitize_text_field( $_POST['ehssl_expiry_notification_email_before_days'] ) ) : 'text';
			$settings['ehssl_expiry_notification_email_from']         = isset( $_POST['ehssl_expiry_notification_email_from'] ) ? $_POST['ehssl_expiry_notification_email_from'] : '';
			$settings['ehssl_expiry_notification_email_to']           = isset( $_POST['ehssl_expiry_notification_email_to'] ) ? sanitize_email( $_POST['ehssl_expiry_notification_email_to'] ) : '';
			$settings['ehssl_expiry_notification_email_subject']      = isset( $_POST['ehssl_expiry_notification_email_subject'] ) ? sanitize_text_field( $_POST['ehssl_expiry_notification_email_subject'] ) : '';
			$settings['ehssl_expiry_notification_email_body']         = isset( $_POST['ehssl_expiry_notification_email_body'] ) ? wp_kses_post( $_POST['ehssl_expiry_notification_email_body'] ) : '';

			update_option( 'httpsrdrctn_options', $settings )

			?>
            <div class="notice notice-success">
                <p><?php _e( "Settings Saved.", 'https-redirection' ); ?></p>
            </div>
			<?php
		}

		$expiry_notification_enabled = isset( $settings['ehssl_enable_expiry_notification'] ) ? sanitize_text_field( $settings['ehssl_enable_expiry_notification'] ) : 0;
		$expiry_notification_email_content_type = isset( $settings['ehssl_expiry_notification_email_content_type'] ) ? sanitize_text_field( $settings['ehssl_expiry_notification_email_content_type'] ) : '';

        $expiry_notification_email_before_days = isset( $settings['ehssl_expiry_notification_email_before_days'] ) ? sanitize_text_field( $settings['ehssl_expiry_notification_email_before_days'] ) : '';
		if (empty($expiry_notification_email_before_days)){
			$expiry_notification_email_before_days = 7;
		}

        $expiry_notification_email_from = isset( $settings['ehssl_expiry_notification_email_from'] ) ? $settings['ehssl_expiry_notification_email_from'] : '';
        if (empty($expiry_notification_email_from)){
            $default_domain_email_address = 'admin@' . EHSSL_Utils::get_domain();
	        $expiry_notification_email_from = get_bloginfo( 'name' ) . ' <'.$default_domain_email_address.'>';
        }

        $expiry_notification_email_to = isset( $settings['ehssl_expiry_notification_email_to'] ) ? sanitize_email( $settings['ehssl_expiry_notification_email_to'] ) : '';

		$expiry_notification_email_sub = isset( $settings['ehssl_expiry_notification_email_subject'] ) ? sanitize_text_field( $settings['ehssl_expiry_notification_email_subject'] ) : '';
		if (empty($expiry_notification_email_sub)){
			$expiry_notification_email_sub = 'SSL Certificate Expiry Notification';
		}

        $expiry_notification_email_body = isset( $settings['ehssl_expiry_notification_email_body'] ) ? wp_kses_post( $settings['ehssl_expiry_notification_email_body'] ) : '';
        if (empty($expiry_notification_email_body)){
            $expiry_notification_email_body = 'Dear Admin,' . "\r\n\r\n"
                                              . 'This is a reminder that your SSL certificate issued by {issuer} '
                                              . 'is set to expire on {expiry_datetime}.' . "\r\n\r\n"
                                              . 'Please take the necessary steps to renew the certificate to avoid any security or accessibility issues.' . "\r\n\r\n"
                                              . 'Thanks';
        }

		?>
        <div class="postbox">
            <h3 class="hndle">
                <label for="title"><?php _e( "Notification Email Settings", 'https-redirection' ); ?></label>
            </h3>
            <div class="inside">
                <form method="post" action="">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">
                                <label>
									<?php _e( 'Enable Certificate Expiry Notification', 'https-redirection' ); ?>
                                </label>
                            </th>
                            <td>
                                <input type="checkbox"
                                       name="ehssl_enable_expiry_notification"
                                       value="1"
                                    <?php echo !empty($expiry_notification_enabled) ? 'checked="checked"' : '' ?>
                                />
                                <br/>
                                <p class="description"><?php _e( "Enable this option to send SSL certificate expiry notifications.", 'https-redirection' ); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label>
									<?php _e( 'Email Content Type', 'https-redirection' ); ?>
                                </label>
                            </th>
                            <td>
                                <select name="ehssl_expiry_notification_email_content_type">
                                    <option value="text" <?php echo ($expiry_notification_email_content_type == 'text') ? 'selected' : '' ?>><?php _e('Plain Text', 'https-redirection') ?></option>
                                    <option value="html" <?php echo ($expiry_notification_email_content_type == 'html') ? 'selected' : '' ?>><?php _e('HTML', 'https-redirection') ?></option>
                                </select>
                                <br/>
                                <p class="description"><?php _e( "Choose whether the SSL expiry notification email should be sent in plain text or HTML format.", 'https-redirection' ); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label>
									<?php _e( 'Notification Email Before Days', 'https-redirection' ); ?>
                                </label>
                            </th>
                            <td>
                                <input type="number"
                                       name="ehssl_expiry_notification_email_before_days"
                                       class="ehssl-settings-field-cat-1"
                                       value="<?php esc_attr_e( $expiry_notification_email_before_days ) ?>"
                                       required
                                />
                                <br/>
                                <p class="description"><?php _e( "Set how many days in advance the expiry email should be sent. Default is 7 days.", 'https-redirection' ); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label>
									<?php _e( 'Notification Email From', 'https-redirection' ); ?>
                                </label>
                            </th>
                            <td>
                                <input type="text"
                                       name="ehssl_expiry_notification_email_from"
                                       class="ehssl-settings-field-cat-2"
                                       value="<?php esc_attr_e( $expiry_notification_email_from ) ?>"
                                />
                                <br/>
                                <p class="description"><?php _e( "The email address used as the 'From' address in the notification email.", 'https-redirection' ); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label>
									<?php _e( 'Notification Email To', 'https-redirection' ); ?>
                                </label>
                            </th>
                            <td>
                                <input type="email"
                                       name="ehssl_expiry_notification_email_to"
                                       class="ehssl-settings-field-cat-2"
                                       value="<?php esc_attr_e( $expiry_notification_email_to ) ?>"
                                       required
                                />
                                <br/>
                                <p class="description"><?php _e( "Email address where expiry notifications will be sent.", 'https-redirection' ); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label>
									<?php _e( 'Notification Email Subject', 'https-redirection' ); ?>
                                </label>
                            </th>
                            <td>
                                <input type="text"
                                       name="ehssl_expiry_notification_email_subject"
                                       class="ehssl-settings-field-cat-2"
                                       value="<?php esc_attr_e( $expiry_notification_email_sub ) ?>"
                                       required
                                />
                                <br/>
                                <p class="description"><?php _e( "Certificate expiry notification email subject.", 'https-redirection' ); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label>
									<?php _e( 'Notification Email Body', 'https-redirection' ); ?>
                                </label>
                            </th>
                            <td>
                                <?php if ($expiry_notification_email_content_type == 'html') {
	                                add_filter( 'wp_default_editor', array( $this, 'set_default_editor' ) );
                                    ?>
                                    <div class="ehssl-settings-field-cat-3">
                                        <?php
                                        wp_editor(
                                            html_entity_decode( $expiry_notification_email_body ),
                                            'ehssl_expiry_notification_email_body',
                                            array(
                                                'textarea_name' => 'ehssl_expiry_notification_email_body',
                                                'teeny'         => true,
                                                'media_buttons' => false,
                                                'textarea_rows' => 12,
                                            )
                                        );
                                        ?>
                                    </div>
                                    <?php
	                                remove_filter( 'wp_default_editor', array( $this, 'set_default_editor' ) );
                                } else { ?>
                                    <textarea
                                            name="ehssl_expiry_notification_email_body"
                                            class="ehssl-settings-field-cat-3"
                                            rows="10"
                                            required
                                    ><?php esc_attr_e( $expiry_notification_email_body ) ?></textarea>
                                    <br/>
                                <?php } ?>
                                <p class="description"><?php _e( "Certificate expiry notification email body.", 'https-redirection' ); ?></p>
                                <?php echo EHSSL_Email_handler::get_merge_tags_hints() ?>
                            </td>
                        </tr>
                    </table>

					<?php wp_nonce_field( 'ehssl_expiry_notification_settings_nonce' ); ?>
                    <p class="submit">
                        <input type="submit" name="ehssl_expiry_notification_settings_form_submit"
                               class="button-primary" value="<?php _e( 'Save Changes' ) ?>"/>
                    </p>
                </form>
            </div><!-- end of inside -->
        </div><!-- end of postbox -->
		<?php
	}

	public function set_default_editor( $r ) {
		$r = 'html';
		return $r;
	}


} // End class