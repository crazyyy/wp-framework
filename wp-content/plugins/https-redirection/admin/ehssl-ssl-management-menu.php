<?php

class EHSSL_SSL_MGMT_Menu extends EHSSL_Admin_Menu
{
    public $menu_page_slug = EHSSL_SSL_MGMT_MENU_SLUG;

    // Specify all the tabs of this menu in the following array.
    public $dashboard_menu_tabs = array('get-ssl' => 'Get SSL', 'install-ssl' => 'Install SSL');

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
            <h2><?php _e("SSL Management", 'https-redirection') ?></h2>
            <h2 class="nav-tab-wrapper"><?php $this->render_page_tabs(); ?></h2>
            <div id="poststuff">
                <div id="post-body">
                    <?php
                    switch ($tab) {
                        case 'install-ssl':
                            //include_once('file-to-handle-this-tab-rendering.php');//If you want to include a file
                            $this->render_tab_2();
                            break;
                        case 'get-ssl':
                        default:
                            //include_once('file-to-handle-this-tab-rendering.php');//If you want to include a file
                            $this->render_tab_1();
                            break;
                    }
                    ?>
                </div>
            </div>
        </div><!-- end or wrap -->
        <?php
    }

    public function render_tab_1()
    {
        //Render tab 1
        if (EHSSL_Utils::get_domain() == "localhost" || filter_var(EHSSL_Utils::get_domain(), FILTER_VALIDATE_IP)) {
            _e("The SSL Certificates required for HTTPS cannot be issued for WordPress sites that are based on 'localhost' or use an IP address. To effectively utilize SSL certificates, and hence to make the most from our plugin, you should operate your WordPress site on a standard domain. This limitation is not specific from our plugin but is a general rule in the issuance of SSL certificates.", 'https-redirection');
            wp_die();
        }

        global $httpsrdrctn_options;

        // Save data for tab 1
        if (isset($_POST['ehssl_get_ssl_form_submit']) && check_admin_referer('ehssl_get_ssl_nonce')) {
            $httpsrdrctn_options['ehssl_email_for_ssl_certificate'] = isset($_POST['ehssl_email_for_ssl_certificate']) ? sanitize_email($_POST['ehssl_email_for_ssl_certificate']) : get_option('admin_email');
            $httpsrdrctn_options['ehssl_ssl_certificate_mode'] = isset($_POST['ehssl_ssl_certificate_mode']) ? sanitize_text_field($_POST['ehssl_ssl_certificate_mode']) : '';
            update_option('httpsrdrctn_options', $httpsrdrctn_options);

            $is_live_ssl_mode = $httpsrdrctn_options['ehssl_ssl_certificate_mode'] === 'live';

            //EHSSL_SSL_Certificate
            $ssl_certificate = new EHSSL_SSL_Certificate();
            $ssl_certificate_status = $ssl_certificate->handle_ssl_installation($httpsrdrctn_options['ehssl_email_for_ssl_certificate'], $is_live_ssl_mode);

            if (is_wp_error($ssl_certificate_status)) {
                $certificate_error = $ssl_certificate_status->get_error_message();
                if (stripos($certificate_error, '429 Too many Requests') !== false) {
                    $certificate_error = "Too many certificate requests, try again in few hours";
                }
        ?>
                <div class="notice notice-error">
                    <p><?php _e("Error getting SSL:", 'https-redirection'); ?> <?php echo $certificate_error; ?></p>
                </div>
            <?php
            } else { ?>
                <div class="notice notice-success">
                    <p><?php _e($ssl_certificate_status, 'https-redirection'); ?> </p>
                    <?php
                    $certificate_urls = EHSSL_SSL_Certificate::get_certificate_urls();

                    echo "<ul>";
                    foreach ($certificate_urls as $key => $url) {
                        echo "<li><a href='{$url}'>{$key}</a></li>";
                    }
                    echo "</ul>";
                    ?>
                </div>
            <?php
            }
            ?>
        <?php
        }

        $ehssl_ssl_certificate_generator_email = isset($httpsrdrctn_options['ehssl_email_for_ssl_certificate']) ? sanitize_email($httpsrdrctn_options['ehssl_email_for_ssl_certificate']) : '';
        $ehssl_ssl_certificate_mode = isset($httpsrdrctn_options['ehssl_ssl_certificate_mode']) ? sanitize_text_field($httpsrdrctn_options['ehssl_ssl_certificate_mode']) : 'staging';


        ?>
        <div class="postbox">
            <h3 class="hndle"><label for="title">Get SSL</label></h3>
            <div class="inside">
                <form method="post" action="">
                    <p>
                        SSL certificate will be generated for the domain:<br>
                        <b><?php echo EHSSL_Utils::get_domain(); ?></b>
                        <?php
                        $domain_variant = EHSSL_Utils::get_domain_variant(EHSSL_Utils::get_domain());
                        if (EHSSL_Utils::is_domain_accessible($domain_variant)) {
                            echo "<br><b>" . $domain_variant . "</b>";
                        }
                        ?>
                    </p>
                    
                    <table class="form-table">
                        <!-- Certificate mode field -->
                        <tr valign="top">
                            <th scope="row">
                               <span><?php _e('SSL certificate mode:', 'https-redirection'); ?></span>
                            </th>
                            <td>
                                <label><input type="radio" name="ehssl_ssl_certificate_mode" value="staging" style="margin-left: 12px;" <?php if ('staging' == $ehssl_ssl_certificate_mode) {echo "checked=\"checked\" ";}?>><?php _e('Staging', 'https-redirection') ?></label>
                                <label><input type="radio" name="ehssl_ssl_certificate_mode" value="live" style="margin-left: 12px;" <?php if ('live' == $ehssl_ssl_certificate_mode) {echo "checked=\"checked\" ";}?>><?php _e('Live', 'https-redirection') ?></label>
                            </td>
                        </tr>
                         <!-- Email address field -->
                        <tr valign="top">
                            <th scope="row">
                                <label for="ehssl_email_for_ssl_certificate"><?php _e('Email Address:', 'https-redirection'); ?></label>
                            </th>
                            <td>
                                <input type="email" id="ehssl_email_for_ssl_certificate" value="<?php echo esc_attr($ehssl_ssl_certificate_generator_email) ?>" name="ehssl_email_for_ssl_certificate" style="margin-left: 12px;" required>
                            </td>
                        </tr>
                    </table>

                    <!-- Submit button -->
                    <input type="submit" name="ehssl_get_ssl_form_submit" class="button-primary" value="<?php _e('Generate SSL Certificate', 'https-redirection') ?>" />
                    <?php wp_nonce_field('ehssl_get_ssl_nonce'); ?>
                                
                </form>
            </div><!-- end of inside -->
        </div><!-- end of postbox -->
    <?php
    }

    public function render_tab_2()
    {
        //Render tab 1
    ?>
        <div class="postbox">
            <h3 class="hndle"><label for="title">Install SSL</label></h3>
            <?php
            global $httpsrdrctn_options;
            $certificate_urls = EHSSL_SSL_Certificate::get_certificate_urls();
            ?>
            <div class="inside">
                <?php if (is_wp_error($certificate_urls)) { ?>
                    <div class="ehssl-yellow-box">
                            <?php echo $certificate_urls->get_error_message();?>
                    </div>
                <?php } else { ?>
                    <p>Please follow <a href="">this guide</a> to install SSL certificate</p>
                    <p>Certificate Expiry: <?php echo isset($httpsrdrctn_options['ehssl_expiry_ssl_certificate']) ? esc_attr($httpsrdrctn_options['ehssl_expiry_ssl_certificate']) : "" ?></p>
                    <ol>
                        <li>
                            <h4><?php _e('Get Certificate Files', 'https-redirection')?></h4>
                            <p><?php _e('Some documentation goes here...' , 'https-redirection') ?></p>
                            <table class="form-table">
                                <?php foreach ($certificate_urls as $key => $file) { ?>
                                    <tr>
                                        <th><?php esc_attr_e($key) ?></th>
                                        <td>
                                            <input type="text" style="width: 80%; margin-right: 4px" readonly value="<?php echo esc_url($file['path']); ?>" /><button class="button-primary"><?php _e('Copy File Path', 'https-redirection') ?></button>
                                        </td>
                                        <td>
                                            <a href='<?php echo esc_url($file['url'])?>' class="button-secondary"><?php _e('Download File', 'https-redirection') ?></a>
                                            <a href='#' class="button-secondary"><?php _e('Copy File Content', 'https-redirection') ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </li>
                        <li>
                            <h4><?php _e('Add the certificate file paths', 'https-redirection')?></h4>
                            <p><?php _e('Some documentation goes here...' , 'https-redirection') ?></p>
                        </li>
                        <li>
                            <h4><?php _e('Restart the server', 'https-redirection')?></h4>
                            <p><?php _e('Some documentation goes here...' , 'https-redirection') ?></p>
                        </li>
                    </ol>
                    <?php } ?>

            </div><!-- end of inside -->
        </div><!-- end of postbox -->
<?php
    }
} // End class