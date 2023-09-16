<?php

/**
 * Fired during plugin activation
 *
 * @link       http://amner.me
 * @since      1.0.0
 *
 * @package    Jerc
 * @subpackage Jerc/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    Jerc
 * @subpackage Jerc/includes
 * @author     James Amner <jdamner@me.com>
 * @since      1.0.0
 */
class JercActivator
{

    /**
     * Runs when the plugin activates.
     *
     * Creates the database table for storing the data.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function activate()
    {
        $plugin = new Jerc();

        if (get_option($plugin->getPluginName() . "_db_version", 0.00) < $plugin->getVersion()) {
            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            global $wpdb;
            $table = $plugin->getPluginName() . "_data";

            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . $table;

            $sql = "CREATE TABLE $table_name ( 
                `id` INT NOT NULL AUTO_INCREMENT , 
                `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                `message` TEXT NULL DEFAULT NULL,
                `script` TEXT NULL DEFAULT NULL , 
                `userId` INT NULL DEFAULT NULL , 
                `userIp` TEXT NULL DEFAULT NULL , 
                `pageUrl` TEXT NULL DEFAULT NULL ,
                `agent` TEXT NULL DEFAULT NULL ,
                PRIMARY KEY (`id`)
            ) $charset_collate;";
            // conditionally create the table or update the schema
            dbDelta($sql);
        }
        update_option($plugin->getPluginName() . '_db_version', $plugin->getVersion());
    }
}
