<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('SDLOG_Settings')) {
    class SDLOG_Settings
    {
        public function __construct()
        {
            add_action('admin_menu', array($this, 'register_setting_menu'));

            $plugin = plugin_basename(SDLOG_PLUGIN_PATH . 'samudra-log.php');
            add_filter("plugin_action_links_$plugin", array($this, 'plugin_settings_link'));
        }

        /**
         * Register setting menu
         *
         * @return void
         */
        public function register_setting_menu()
        {
            add_options_page(
                'Samudra Log',
                'Samudra Log',
                'manage_options',
                'samudra-log',
                array($this, 'setting_page')
            );
        }

        /**
         * Plugin setting page
         *
         * @return Html
         */
        public function setting_page()
        {
            $serverSoftware = $_SERVER['SERVER_SOFTWARE'];
            $webServerName = explode('/', $serverSoftware)[0];
            
            include SDLOG_PLUGIN_PATH . '/views/admin/setting-page.php';
        }

        /**
         * Add settings link in plugins page list
         *
         * @param Array $links
         * @return Array
         */
        public function plugin_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=samudra-log">Settings</a>';
            array_push($links, $settings_link);
            return $links;
        }
    }

    $SDLOG_Settings = new SDLOG_Settings();
}
