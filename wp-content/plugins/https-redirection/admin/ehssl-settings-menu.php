<?php

class EHSSL_Settings_Menu extends EHSSL_Admin_Menu
{
    public $menu_page_slug = EHSSL_SETTINGS_MENU_SLUG;

    // Specify all the tabs of this menu in the following array.
    public $dashboard_menu_tabs = array('general' => 'General', 'mixed-contents' => 'Mixed Contents');

    public function __construct()
    {
        $this->render_menu_page();
    }

    public function get_current_tab()
    {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : array_keys($this->dashboard_menu_tabs)[0];
        return $tab;
    }

    /**
     * Renders our tabs of this menu as nav items
     */
    public function render_page_tabs()
    {
        $current_tab = $this->get_current_tab();
        foreach ($this->dashboard_menu_tabs as $tab_key => $tab_caption) {
            $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
            echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->menu_page_slug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
        }
    }

    /**
     * The menu rendering goes here
     */
    public function render_menu_page()
    {
        $tab = $this->get_current_tab();

        ?>
        <div class="wrap">
            <h2><?php _e("Settings", 'https-redirection')?></h2>
            <h2 class="nav-tab-wrapper"><?php $this->render_page_tabs();?></h2>
            <div id="poststuff"><div id="post-body">
            <?php

        switch ($tab) {
	        case 'mixed-contents':
		        //include_once('file-to-handle-this-tab-rendering.php');//If you want to include a file
		        $this->render_mixed_content_tab();
		        break;
	        case 'general':
	        default:
                //include_once('file-to-handle-this-tab-rendering.php');//If you want to include a file
                $this->render_general_tab();
                break;
        }
        ?>
            </div>
        </div>
        <?php $this->documentation_link_box();?>
        </div><!-- end or wrap -->
        <?php
    }

    public function render_general_tab()
    {
	    $settings = get_option('httpsrdrctn_options', array());

	    // Save data for settings page.
	    if (isset($_REQUEST['httpsrdrctn_form_submit']) && check_admin_referer(plugin_basename(__FILE__), 'httpsrdrctn_nonce_name')) {
		    $settings['https'] = isset($_REQUEST['httpsrdrctn_https']) ? $_REQUEST['httpsrdrctn_https'] : 0;
		    $settings['https_domain'] = isset($_REQUEST['httpsrdrctn_https_domain']) ? $_REQUEST['httpsrdrctn_https_domain'] : 0;

		    if (isset($_REQUEST['httpsrdrctn_https_pages_array'])) {
			    $settings['https_pages_array'] = array();
			    // var_dump($httpsrdrctn_options['https_pages_array']);
			    foreach ($_REQUEST['httpsrdrctn_https_pages_array'] as $httpsrdrctn_https_page) {
				    if (!empty($httpsrdrctn_https_page) && $httpsrdrctn_https_page != '') {
					    $httpsrdrctn_https_page = str_replace('https', 'http', $httpsrdrctn_https_page);
					    $settings['https_pages_array'][] = trim(str_replace(home_url(), '', $httpsrdrctn_https_page), '/');
				    }
			    }
		    }

            // Update options in the database.
            update_option('httpsrdrctn_options', $settings, '', 'yes');

            echo '<div class="notice notice-success"><p>'.__("Settings Saved.", 'https-redirection').'</p></div>';

            $httpsrdrctn_obj = new EHSSL_Htaccess();
            $httpsrdrctn_obj->write_to_htaccess();

            // clear caching plugins cache if needed
            // WP Fastest Cache
            if (isset($GLOBALS["wp_fastest_cache"])) {
                $wpfc = $GLOBALS["wp_fastest_cache"];
                if (method_exists($wpfc, 'deleteCache') && is_callable(array($wpfc, 'deleteCache'))) {
                    $wpfc->deleteCache(true);
                }
            }
            // httpsrdrctn_generate_htaccess();

	    }
	    $siteSSLurl = get_home_url(null, '', 'https');

        // Save data for settings page.
        if (isset($_POST['ehssl_debug_log_form_submit']) && check_admin_referer('ehssl_debug_settings_nonce')) {
            $settings['enable_debug_logging'] = isset($_POST['enable_debug_logging']) ? esc_attr($_POST['enable_debug_logging']) : 0;

            update_option('httpsrdrctn_options', $settings)

            ?>
            <div class="notice notice-success">
                <p><?php _e("Settings Saved.", 'https-redirection');?></p>
            </div>
            <?php
        }

        $is_debug_logging_enabled = isset($settings['enable_debug_logging']) ? esc_attr($settings['enable_debug_logging']) : 0;

        ?>
        <div class="ehssl-yellow-box">
            <p>
			    <?php echo sprintf(__("When you enable the HTTPS redirection, the plugin will force redirect the URL to the HTTPS version of the URL. So before enabling this plugin's feature, visit your site's HTTPS URL %s to make sure the page loads correctly. Otherwise you may get locked out if your SSL certificate is not installed correctly on your site or the HTTPS URL is not working and this plugin is auto redirecting to the HTTPS URL.", 'https-redirection'), '<a href="' . $siteSSLurl . '" target="_blank">' . $siteSSLurl . '</a>'); ?>
            </p>
            <p>
                <span style="font-weight:bold; color:red;"><?php _e('Important!', 'https-redirection');?></span>
			    <?php _e("If you're using caching plugins similar to W3 Total Cache or WP Super Cache, you need to clear their cache after you enable or disable automatic redirection option. Failing to do so may result in mixed content warning from browser.", 'https-redirection');?>
            </p>
        </div>
        <div class="postbox">
            <h3 class="hndle"><label for="title"><?php _e("HTTPS Redirection", 'https-redirection');?></label></h3>
            <div class="inside">
			    <?php
			    // Display form on the setting page.
			    if (get_option('permalink_structure')) {
				    // Pretty permalink is enabled. So allow HTTPS redirection feature.
				    ?>
                    <div id="httpsrdrctn_settings_notice" class="updated fade" style="display:none">
                        <p>
                            <strong><?php _e("Notice:", 'https-redirection');?></strong><?php _e("The plugin's settings have been changed. In order to save them please don't forget to click the 'Save Changes' button.", 'https-redirection');?>
                        </p>
                    </div>

                    <form id="httpsrdrctn_settings_form" method="post" action="">
                        <div style="position: relative">
                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row"><?php _e('Enable Automatic Redirection to HTTPS', 'https-redirection');?></th>
                                    <td>
                                        <label>
                                            <input type="checkbox" id="httpsrdrctn-checkbox" name="httpsrdrctn_https" value="1" <?php if ('1' == $settings['https']) {echo "checked=\"checked\" ";}?> />
                                        </label>
                                        <br />
                                        <p class="description"><?php _e("Use this option to make your webpage(s) load in HTTPS version only. If someone enters a non-https URL in the browser's address bar then the plugin will automatically redirect to the HTTPS version of that URL.", 'https-redirection');?></p>
                                    </td>
                                </tr>
                            </table>

                            <div class="ehssl-enable-automatic-redirection httpsrdrctn-overlay <?php echo (is_ssl() ? 'hidden' : ''); ?>"></div>
                        </div>

                        <div style="position: relative">
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Apply HTTPS Redirection To:', 'https-redirection');?></th>
                                    <td>
                                        <div style="margin-bottom: 6px">
                                            <label><input type="radio" name="httpsrdrctn_https_domain" value="1" <?php if ('1' == $settings['https_domain']) {echo "checked=\"checked\" ";}?> /> <?php _e('The whole domain', 'https-redirection');?></label>
                                        </div>
                                        <div style="margin-bottom: 6px">
                                            <label><input type="radio" name="httpsrdrctn_https_domain" value="0" <?php if ('0' == $settings['https_domain']) {echo "checked=\"checked\" ";}?> /> <?php _e('A few pages', 'https-redirection');?></label>
                                        </div>
									    <?php foreach ($settings['https_pages_array'] as $https_page) { ?>
                                            <div style="margin-bottom: 5px">
											    <?php echo str_replace("http://", "https://", home_url()); ?>/<input type="text" name="httpsrdrctn_https_pages_array[]" value="<?php echo $https_page; ?>" /> <span class="button-secondary rewrite_item_delete_btn"><i class="dashicons dashicons-trash"></i></span> <span class="rewrite_item_blank_error"><?php _e('Please enter a page slug value in the field before adding it.', 'https-redirection');?></span>
                                            </div>
									    <?php } ?>
                                        <div class="rewrite_new_item">
										    <?php echo str_replace("http://", "https://", home_url()); ?>/<input type="text" name="httpsrdrctn_https_pages_array[]" placeholder="<?php _e('Enter the page slug','https-redirection'); ?>" value="" /> <span class="button-secondary rewrite_item_add_btn"><i class="dashicons dashicons-plus-alt2"></i></span> <span class="rewrite_item_blank_error"><?php _e('Please enter a page slug value in the field before adding it.', 'https-redirection');?></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div class="ehssl-apply-redirection-on httpsrdrctn-overlay <?php echo ($settings['https'] == 1 ? 'hidden' : ''); ?>"></div>
                        </div>

                        <input type="hidden" name="httpsrdrctn_form_submit" value="submit" />

                        <p class="submit">
                            <input type="submit" class="button-primary" value="<?php _e('Save Changes')?>"  <?php echo !is_ssl() ? 'disabled' : '' ?>/>
                        </p>
					    <?php wp_nonce_field(plugin_basename(__FILE__), 'httpsrdrctn_nonce_name');?>
                    </form>
                    <script>
                        jQuery('input#httpsrdrctn-checkbox').change(function() {
                            if (jQuery(this).is(':checked')) {
                                jQuery('div.ehssl-apply-redirection-on.httpsrdrctn-overlay').fadeOut('fast');
                            } else {
                                jQuery('div.ehssl-apply-redirection-on.httpsrdrctn-overlay').fadeIn('fast');
                            }
                        });
                    </script>
                    <style>
                        .httpsrdrctn-overlay {
                            position: absolute;
                            top: 10px;
                            background-color: white;
                            width: 100%;
                            height: 100%;
                            opacity: 0.5;
                            text-align: center;
                        }
                    </style>

                    <div class="ehssl-red-box">
                        <p><strong><?php _e("Notice:", 'https-redirection');?></strong> <?php _e("It is very important to be extremely attentive when making changes to .htaccess file.", 'https-redirection');?></p>
                        <p><?php _e('If after making changes your site stops functioning, do the following:', 'https-redirection');?></p>
                        <p><?php _e('Step #1: Open .htaccess file in the root directory of the WordPress install and delete everything between the following two lines', 'https-redirection');?></p>
                        <p style="border: 1px solid #ccc; padding: 10px;">
                            # BEGIN HTTPS Redirection Plugin<br />
                            # END HTTPS Redirection Plugin
                        </p>
                        <p><?php _e('Step #2: Save the htaccess file (this will erase any change this plugin made to that file).', 'https-redirection');?></p>
                        <p><?php _e("Step #3: Deactivate the plugin or rename this plugin's folder (which will deactivate the plugin).", 'https-redirection');?></p>

                        <p><?php _e('The changes will be applied immediately after saving the changes, if you are not sure - do not click the "Save changes" button.', 'https-redirection');?></p>
                    </div>

			    <?php } else {?>
                    <!-- pretty permalink is NOT enabled. This plugin can't work. -->
                    <div class="error">
                        <p><?php _e('HTTPS redirection only works if you have pretty permalinks enabled.', 'https-redirection');?></p>
                        <p><?php _e('To enable pretty permalinks go to <em>Settings > Permalinks</em> and select any option other than "default".', 'https-redirection');?></p>
                        <p><a href="options-permalink.php"><?php _e('Enable Permalinks', 'https-redirection');?></a></p>
                    </div>
			    <?php }?>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle"><label for="title"><?php _e("Debug Logging", 'https-redirection');?></label></h3>
            <div class="inside">
            <p>
                <?php _e('Debug logging can be useful to troubleshoot issues on your site. keep it disabled unless you are troubleshooting.', 'https-redirection');?>
            </p>
            <form id="ehssl_debug_settings_form" method="post" action="">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="ehssl-debug-enable-checkbox">
                                <?php _e('Enable Debug Logging', 'https-redirection');?>
                            </label>
                        </th>
                        <td>
                            <input type="checkbox" id="ehssl-debug-enable-checkbox" name="enable_debug_logging" value="1" <?php if ('1' == $is_debug_logging_enabled) {echo "checked=\"checked\" ";}?> />
                            <br />
                            <p class="description"><?php _e("Check this option to enable debug logging.", 'https-redirection');?></p>
                            <p class="description">
                                <a href="<?php echo wp_nonce_url(get_admin_url() . '?ehssl-debug-action=view_log', 'ehssl_view_log_nonce'); ?>" target="_blank">
                                    <?php _e('Click here', 'https-redirection')?>
                                </a>
                                <?php _e(' to view log file.', 'https-redirection');?>
                                <br>
                                <a id="ehssl-reset-log" href="#0" style="color: red">
                                    <?php _e('Click here', 'https-redirection');?>
                                </a>
                                <?php _e(' to reset log file.', 'https-redirection');?>
                            </p>
                        </td>
                    </tr>
                </table>

                <input type="submit" name="ehssl_debug_log_form_submit" class="button-primary" value="<?php _e('Save Changes')?>" />
                <?php wp_nonce_field('ehssl_debug_settings_nonce');?>
            </form>
            </div><!-- end of inside -->
        </div><!-- end of postbox -->
        <script>
            jQuery( document ).ready( function( $ ) {
                const ehssl_ajaxurl = "<?php echo get_admin_url() . 'admin-ajax.php' ?>";
				const ehssl_ajax_nonce = "<?php echo wp_create_nonce('ehssl_settings_ajax_nonce') ?>";
                $( '#ehssl-reset-log' ).on('click', function( e ) {
                    e.preventDefault();
                    $.post( ehssl_ajaxurl,
                            {
                                action: 'ehssl_reset_log',
                                nonce: ehssl_ajax_nonce
                            },
                            function( result ) {
                                if ( result === '1' ) {
                                    alert( '<?php _e('Log file has been reset.', 'https-redirection') ?>' );
                                } else {
                                    alert( '<?php _e('Error trying to reset log: ' , 'https-redirection') ?>' + result );
                                }
                            } );
                } );
            } );
        </script>
        <?php
    }

    public function render_mixed_content_tab()
    {
        global $httpsrdrctn_options;

        $is_https_redirection_enabled = isset($httpsrdrctn_options['https']) && esc_attr($httpsrdrctn_options['https']) == '1' ? true : false;

        if (isset($_POST['ehssl_mixed_content_form_submit']) && check_admin_referer('ehssl_mixed_content_settings_nonce')) {
            $httpsrdrctn_options['force_resources'] = isset($_POST['httpsrdrctn_force_resources']) ? esc_attr($_POST['httpsrdrctn_force_resources']) : 0;
            update_option('httpsrdrctn_options', $httpsrdrctn_options)

            ?>
            <div class="notice notice-success">
                <p><?php _e("Settings Saved.", 'https-redirection');?></p>
            </div>
            <?php
        }
        ?>
        <div class="postbox">
            <h3 class="hndle"><label for="title"><?php _e("Static Resources", 'https-redirection');?></label></h3>
            <div class="inside">
                <?php if(!$is_https_redirection_enabled){ ?>
                    <div class="ehssl-yellow-box">
                        <p>
                            <?php _e("HTTPS redirection is turned off. Turn it on first to change these settings below!", 'https-redirection');?>
                        </p>
                    </div>
                <?php } ?>
                <form action="" method="POST">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?php _e('Force Resources to Use HTTPS URL', 'https-redirection');?></th>
                            <td>
                                <label>
                                    <input type="checkbox" <?php echo !$is_https_redirection_enabled ? "disabled" : ''; ?> name="httpsrdrctn_force_resources" value="1" <?php echo (isset($httpsrdrctn_options['force_resources']) && $httpsrdrctn_options['force_resources'] == '1') ? 'checked="checked"' : ''; ?> />
                                </label>
                                <br />
                                <p class="description"><?php _e('When checked, the plugin will force load HTTPS URL for any static resources in your content. Example: if you have have an image embedded in a post with a NON-HTTPS URL, this option will change that to a HTTPS URL.', 'https-redirection');?></p>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="ehssl_mixed_content_form_submit" class="button-primary" value="<?php _e('Save Changes')?>" <?php if (!$is_https_redirection_enabled) {echo "disabled";}?>/>
                    <?php wp_nonce_field('ehssl_mixed_content_settings_nonce');?>
                </form>
            </div><!-- end of inside -->
        </div><!-- end of postbox -->
        <?php
}
} // End class