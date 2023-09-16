<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Samudra Log translation class
 */
if (!class_exists('SDLOG_Translation')) {
    class SDLOG_Translation
    {
        /**
         * Class constructor
         */
        public function __construct()
        {
            add_action('init', array($this, 'translation'));
        }

        /**
         * Add translation
         *
         * @return void
         */
        public function translation()
        {
            load_plugin_textdomain('samudra_log', false, 'samudra-log/languages');
        }
    }
    
    $SDLOG_Translation = new SDLOG_Translation();
}
