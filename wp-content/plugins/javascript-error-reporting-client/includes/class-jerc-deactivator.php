<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://amner.me
 * @since      1.0.0
 *
 * @package    Jerc
 * @subpackage Jerc/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Jerc
 * @subpackage Jerc/includes
 * @author     James Amner <jdamner@me.com>
 */
class JercDeactivator
{
    /**
     * Runs when the plugin deactivates
     *
     * Deletes the database of stored events.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function deactivate()
    {
        if (isset($_REQUEST['preserve'])) {
            return;
        }
        global $wpdb;
        $plugin = new Jerc();
        $table_name = $wpdb->prefix . $plugin->getPluginName() . "_data";
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
        return delete_option($plugin->getPluginName() . "_db_version");
    }
}
