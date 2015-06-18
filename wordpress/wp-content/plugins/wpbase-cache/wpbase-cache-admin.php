<?php

class WPBase_Cache_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_wpbase_cache_page'));
        add_action('admin_init', array($this, 'wpbase_cache_page_init'));
        add_action('update_option_wpbase_cache_options', array($this, 'update_options'), 10, 2);

        add_action('admin_footer', array($this, 'add_javascript'));
        add_action('wp_ajax_wpbase_cache_flush_all', array($this, 'ajax_flush_cache'));
    }

    public function add_wpbase_cache_page() {
        add_options_page('WPBase Cache', 'WPBase', 'manage_options', 'wpbasecache', array($this, 'create_wpbase_cache_page'));
    }

    public function create_wpbase_cache_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        ?>
        <div class="wrap">
        <?php screen_icon(); ?>
            <h2>WPBase Cache</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('wpbase_cache_options');
                do_settings_sections('wpbasecache');
                ?>
        <?php submit_button(); ?>
                <a class="button" id="wpbase_cache_flush_all">Empty All Caches</a>
            </form>
        </div>
        <?php
    }

    public function wpbase_cache_page_init() {
        register_setting('wpbase_cache_options', 'wpbase_cache_options');

        add_settings_section(
                'wpbase_cache_section', 'WPBase Cache Settings', array($this, 'wpbase_cache_section_desc'), 'wpbasecache'
        );



        add_settings_field(
                'wpbase_cache_options_varnish_cache', 'Enable Varnish Cache', array($this, 'varnish_cache_input'), 'wpbasecache', 'wpbase_cache_section'
        );

        add_settings_field(
                'wpbase_cache_options_send_as', 'Send Mail As', array($this, 'send_as_input'), 'wpbasecache', 'wpbase_cache_section'
        );
    }

    public function wpbase_cache_section_desc() {
        //echo 'These settings are part of wpoven manager plugin.';
    }

    public function varnish_cache_input() {
        $options = get_option('wpbase_cache_options');

        $checked = checked(1, $options['varnish_cache'], FALSE);
        if (!(defined('WPBASE_CACHE_SANDBOX') && WPBASE_CACHE_SANDBOX)) {
            echo "<input id='wpbase_cache_varnish_cache' name='wpbase_cache_options[varnish_cache]' type='checkbox' value='1' $checked />";
        } else {
            echo "<input id='wpbase_cache_varnish_cache' disabled='disabled' name='wpbase_cache_options[varnish_cache]' type='checkbox' value='1' $checked />";
        }
    }

    public function send_as_input() {
        $options = get_option('wpbase_cache_options');

        if($options['send_as']!=''){
            $send_as= $options['send_as'];
        }
        if (!(defined('WPBASE_CACHE_SANDBOX') && WPBASE_CACHE_SANDBOX)) {
            echo "<input id='wpbase_cache_send_as' name='wpbase_cache_options[send_as]' type='text' value='$send_as' />@yourdomain.com <br /><font color='gray'> Leave field empty to disable this feature.</font>";
        } else {
            echo "<input id='wpbase_cache_send_as' disabled='disabled' name='wpbase_cache_options[send_as]' type='checkbox' value='1' />";
        }
    }

    public function add_javascript() {
        $nonce = wp_create_nonce('wpbase_cache_flush_all');
        ?>
        <script type="text/javascript" >
            jQuery(document).ready(function($) {

                $('#wpbase_cache_flush_all').click(function() {
                    var element = $(this);
                    var data = {
                        action: 'wpbase_cache_flush_all',
                        _ajax_nonce: '<?php echo $nonce; ?>'
                    };

                    $.post(ajaxurl, data, function(response) {
                        if (response == 1) {
                            message = 'Sucessfully flushed all caches';
                        } else if (response == -1) {
                            message = 'Unauthorised request';
                        } else {
                            message = response;
                        }
                        element.replaceWith(message);
                    });
                });
            });
        </script>
        <?php
    }

    public function ajax_flush_cache() {
        check_ajax_referer('wpbase_cache_flush_all');

        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to perform this action.'));
        }

        // flush db cache
        global $wpbase_cache;
        $wpbase_cache->flush_all_cache();

        echo 1;
        die;
    }

    public function update_options($oldvalue, $newvalue) {
        
    }

}

$wpbase_cache_admin = new WPBase_Cache_Admin();
