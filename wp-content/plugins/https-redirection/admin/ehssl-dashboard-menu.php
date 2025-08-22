<?php

class EHSSL_Dashboard_Menu extends EHSSL_Admin_Menu
{
    public $menu_page_slug = EHSSL_MAIN_MENU_SLUG;

    // Specify all the tabs of this menu in the following array
    public $dashboard_menu_tabs = array(
        'status' => 'Status',
        // 'tab2' => 'Tab Two'
    );

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
            <h2><?php _e("Dashboard", 'https-redirection') ?></h2>
            <h2 class="nav-tab-wrapper"><?php $this->render_page_tabs(); ?></h2>
            <div id="poststuff">
                <div id="post-body">
                    <?php
                    $tab_keys = array_keys($this->dashboard_menu_tabs);
                    switch ($tab) {
                        case 'status':
                        default:
                            $this->render_status_tab();
                            break;
                    }
                    ?>
                </div>
            </div>
        </div><!-- end or wrap -->
        <?php
    }

    public function render_status_tab()
    {
    ?>
        <div id="ehssl-dashboard-widgets-wrap">
            <div id="ehssl-dashboard-widgets" class="metabox-holder">
                <div class="ehssl-dashboard-widget-column postbox-container">
                    <?php $this->widget_ssl_status(); ?>
                </div>
                <div class="ehssl-dashboard-widget-column postbox-container">
                    <?php
                    if (is_ssl()) {
                        $this->widget_ssl_info();
                    }
                    ?>
                </div>
                <div class="ehssl-dashboard-widget-column postbox-container">
                    <!-- Widgets here -->
                </div>
            </div>
        </div>
        <style>
            #ehssl-dashboard-widgets{
                display: flex;
                justify-content: space-around;
            }
            .ehssl-dashboard-widget-column {
                flex: 1;
                background-color: transparent;
                min-width: 200px;
            }
            .ehssl-dashboard-widget-column .postbox {
                margin: 0px 8px 28px;
            }
        </style>
    <?php
    }

    public function widget_ssl_status()
    {
    ?>
        <div id="ehssl_dashboard_ssl_status" class="sortable-item postbox"  data-item-id="1">
            <div class="postbox-header handle">
                <h2><?php _e("SSL Status", 'https-redirection'); ?></h2>
            </div>

            <div class="inside">
                <div style="padding: 12px 0 6px; display: flex; align-items: center; flex-direction: column;">
                    <?php if (is_ssl()) { ?>
                        <div style="color: green; height: 5rem">
                            <span class="dashicons dashicons-lock" style="transform: scale(4); transform-origin: top center;"></span>
                        </div>
                        <div>
                            <?php _e('Your site is protected!', 'https-redirection') ?>
                        </div>
                    <?php } else { ?>
                        <div style="color: #cc0000; height: 5rem">
                            <span class="dashicons dashicons-dismiss" style="transform: scale(4); transform-origin: top center;"></span>
                        </div>
                        <div>
                            <?php _e('No SSL found!', 'https-redirection') ?>
                        </div>
                    <?php } ?>
                </div>
            </div><!-- end of inside -->
        </div><!-- end of postbox -->
    <?php
    }

    public function widget_ssl_info()
    {
        $ssl_info = EHSSL_SSL_Utils::get_parsed_current_ssl_info_for_dashbaord();
    ?>
        <div id="ehssl_dashboard_ssl_info" class="sortable-item postbox" data-item-id="2">
            <div class="postbox-header handle">
                <h2><?php _e("SSL Information", 'https-redirection'); ?></h2>
            </div>
            <div class="inside">
                <table>
                    <?php foreach ($ssl_info as $section => $fields) { ?>
                        <tr valign="top" style="margin: 24px 0;">
                            <td scope="row">
                                <b style="font-weight: bold;">
                                    <?php _e($section, 'https-redirection'); ?>
                                </b>
                            </td>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php foreach ($fields as $field => $value) { ?>
                            <tr valign="top">
                                <td><?php _e($field, 'https-redirection'); ?></td>
                                <td> : </td>
                                <td><?php echo $value ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div><!-- end of inside -->
        </div><!-- end of postbox -->
    <?php
    }

} //end class