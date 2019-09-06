<?php

/**
 * When A/B testing is enabled, we should increase all banner versions to flush the users cache
 */

function cmplz_update_banner_version_all_banners(){
    $banners  = cmplz_get_cookiebanners( );
    if ( $banners ) {
        foreach ( $banners as $banner_item ) {
            $banner = new CMPLZ_COOKIEBANNER($banner_item->ID);
            $banner->banner_version++;
            $banner->save();
        }
    }
}

add_action('admin_init', 'cmplz_check_minimum_one_banner');
function cmplz_check_minimum_one_banner(){
    if (!cmplz_user_can_manage()) return;

    //make sure there's at least one banner
    $cookiebanners = cmplz_get_cookiebanners();
    if (count($cookiebanners)<1){
        $banner = new CMPLZ_COOKIEBANNER();
        $banner->save();
    }

    //if we have one (active) banner, but it's not default, make it default
    $cookiebanners = cmplz_get_cookiebanners();
    if (count($cookiebanners) == 1 && !$cookiebanners[0]->default) {
        $banner = new CMPLZ_COOKIEBANNER($cookiebanners[0]->ID);
        $banner->enable_default();
    }

}

add_action('admin_init', 'cmplz_redirect_to_cookiebanner');
function cmplz_redirect_to_cookiebanner(){
    //on cookiebanner page?
    if (!isset($_GET['page']) || $_GET['page']!='cmplz-cookiebanner') return;
    if (!apply_filters('cmplz_show_cookiebanner_list_view', false) && !isset($_GET['id'])) {
        wp_redirect(add_query_arg('id', cmplz_get_default_banner_id(), admin_url('admin.php?page=cmplz-cookiebanner')));
    }
}

add_action('cmplz_admin_menu', 'cmplz_cookiebanner_admin_menu');
function cmplz_cookiebanner_admin_menu()
{
    if (!cmplz_user_can_manage()) return;

    add_submenu_page(
        'complianz',
        __('Cookie Banner', 'complianz-gdpr'),
        __('Cookie Banner', 'complianz-gdpr'),
        'manage_options',
        'cmplz-cookiebanner',
        'cmplz_cookiebanner_overview'
    );
}

add_action('wp_ajax_cmplz_delete_cookiebanner', 'cmplz_delete_cookiebanner');
function cmplz_delete_cookiebanner(){
    if (!cmplz_user_can_manage()) return;

    if (isset($_POST['cookiebanner_id'])) {
        $banner = new CMPLZ_COOKIEBANNER(intval($_POST['cookiebanner_id']));
        $success = $banner->delete();
        $response = json_encode(array(
            'success' => $success,
        ));
        header("Content-Type: application/json");
        echo $response;
        exit;
    }
}

/**
 * This function is hooked to the plugins_loaded, prio 10 hook, as otherwise there is some escaping we don't want.
 * @todo fix the escaping
 */
add_action('plugins_loaded', 'cmplz_cookiebanner_form_submit', 10);
function cmplz_cookiebanner_form_submit()
{
    if (!cmplz_user_can_manage()) return;

    if (!isset($_GET['id']) && !isset($_POST['cmplz_add_new'])) return;

    if (!isset($_POST['cmplz_nonce'])) return;
    
    if (isset($_POST['cmplz_add_new'])) {
        $banner = new CMPLZ_COOKIEBANNER();
    } else {
        $id = intval($_GET['id']);
        $banner = new CMPLZ_COOKIEBANNER($id);
    }

    $banner->process_form($_POST);

    if (isset($_POST['cmplz_add_new'])) {
        wp_redirect(admin_url('admin.php?page=cmplz-cookiebanner&id='.$banner->id));
        exit;
    }
}


function cmplz_cookiebanner_overview(){

    if (!cmplz_user_can_manage()) return;

    /*
     * Reset the statistics
     * */
    if (class_exists('cmplz_statistics') && (isset($_GET['action']) && $_GET['action']=='reset_statistics'))  {
        COMPLIANZ()->statistics->init_statistics();
    }

    $id = false;
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
    }

    if ($id || (isset($_GET['action']) && $_GET['action']=='new'))  {
        include(dirname(__FILE__)."/edit.php");
    } else {

        include(dirname(__FILE__) . '/class-cookiebanner-table.php');

        $customers_table = new cmplz_CookieBanner_Table();
        $customers_table->prepare_items();

        ?>
        <script>
            jQuery(document).ready(function ($) {
                $(document).on('click', '.cmplz-delete-banner', function (e) {

                    e.preventDefault();
                    var btn = $(this);
                    btn.closest('tr').css('background-color', 'red');
                    var delete_banner_id = btn.data('id');
                    $.ajax({
                        type: "POST",
                        url: '<?php echo admin_url('admin-ajax.php')?>',
                        dataType: 'json',
                        data: ({
                            action: 'cmplz_delete_cookiebanner',
                            cookiebanner_id: delete_banner_id
                        }),
                        success: function (response) {
                            if (response.success) {
                                btn.closest('tr').remove();
                            }
                        }
                    });

                });
            });
        </script>

        <div class="wrap cookie-warning">
        <h1><?php _e("Cookie banner settings", 'complianz-gdpr') ?>
            <?php do_action('cmplz_after_cookiebanner_title'); ?>
        </h1>
            <?php
            if (!COMPLIANZ()->wizard->wizard_completed_once()) {
                cmplz_notice(__('Please complete the wizard to check if you need a cookie warning.', 'complianz-gdpr'), 'warning');
            } else {
                if (!COMPLIANZ()->cookie->site_needs_cookie_warning()) {
                    cmplz_notice(__('Your website does not require a cookie warning, so these settings do not apply.', 'complianz-gdpr'));
                } else {
                    cmplz_notice(__('Your website requires a cookie warning, these settings will determine how the popup will look.', 'complianz-gdpr'));
                }
            }

            do_action('cmplz_before_cookiebanner_list');
            ?>

            <form id="cmplz-cookiebanner-filter" method="get"
                  action="">

                <?php
                $customers_table->search_box(__('Filter', 'complianz-gdpr'), 'cmplz-cookiebanner');
                $customers_table->display();
                ?>
                <input type="hidden" name="page" value="cmplz-cookiebanner"/>
            </form>
            <?php  do_action('cmplz_after_cookiebanner_list'); ?>
        </div>
        <?php
    }
}



/*
 *
 *
 * Here we add scripts and styles for the wysywig editor on the backend
 *
 * */
add_action('admin_enqueue_scripts',  'cmplz_enqueue_cookiebanner_wysiwyg_assets');
function cmplz_enqueue_cookiebanner_wysiwyg_assets($hook){

    if (!cmplz_user_can_manage()) return;

    if (strpos($hook, 'cmplz-cookiebanner') === FALSE) return;

    if (!isset($_GET['id']) && !(isset($_GET['action']) && $_GET['action']=='new')) return;

    $minified = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    wp_register_style('cmplz-cookie', cmplz_url . "core/assets/css/cookieconsent$minified.css", "", cmplz_version);
    wp_enqueue_style('cmplz-cookie');

    $cookiebanner_id = isset($_GET['id']) ? intval($_GET['id']) : cmplz_get_default_banner_id();
    if (cmplz_get_value('use_custom_cookie_css' . $cookiebanner_id)) {
        $custom_css = cmplz_get_value('custom_css' . $cookiebanner_id);
        ('sanitized css' . $custom_css);
        if (!empty($custom_css)) {
            wp_add_inline_style('cmplz-cookie', $custom_css);
        }
    }

    $cookiesettings = COMPLIANZ()->cookie->get_cookiebanner_settings($cookiebanner_id);

    wp_enqueue_script('cmplz-cookie', cmplz_url . "core/assets/js/cookieconsent.js", array('jquery', 'cmplz-admin'), cmplz_version, true);
    wp_localize_script(
        'cmplz-cookie',
        'complianz',
        $cookiesettings
    );

    wp_enqueue_script('cmplz-cookie-config-styling', cmplz_url . "core/assets/js/cookieconfig-styling.js", array('jquery', 'cmplz-cookie'), cmplz_version, true);

}